<?php
header('Content-Type: application/json');

// --- CONFIG ---
define('BASE_PATH', dirname(__DIR__));
require_once BASE_PATH . '/src/core/Database.php';

// --- UTILITIES ---
function clean_text($t) {
    $t = mb_strtolower($t, 'UTF-8');
    $t = trim($t);
    $t = preg_replace('/[^\p{L}\p{N}\s]+/u', ' ', $t); // remove punctuation
    $t = preg_replace('/\s+/', ' ', $t);
    return $t;
}

function generateMap($name, $address) {
    $query = urlencode($name . " " . $address . " Manaoag, Pangasinan");
    return "<iframe width='100%' height='200' frameborder='0' scrolling='no' marginheight='0' marginwidth='0' src='https://maps.google.com/maps?q={$query}&t=h&z=17&ie=UTF8&iwloc=&output=embed' style='border-radius:8px; margin-top:10px; border:1px solid #ccc;'></iframe>";
}

function generateImage($filename) {
    if (empty($filename) || $filename === 'default.png') return "";
    // Keep paths consistent with project layout
    return "<img src='/explore-manaoag/public/images/{$filename}' style='width:100%; height:150px; object-fit:cover; border-radius:8px; margin-bottom:10px; border:1px solid #eee;'>";
}

function score_text_similarity($needle, $haystack) {
    // needle and haystack are already cleaned lowercase strings
    if ($needle === $haystack) return 1.0;
    if (strpos($haystack, $needle) !== false) return 0.9;
    $n = levenshtein($needle, $haystack);
    $maxlen = max(mb_strlen($needle), mb_strlen($haystack), 1);
    $lev_score = 1 - ($n / $maxlen); // closer to 1 is better
    $sim = 0.0;
    @similar_text($needle, $haystack, $sim);
    $sim = $sim / 100.0; // convert percent to 0-1
    $sx = (soundex($needle) === soundex($haystack)) ? 0.9 : 0.0;
    // Weighted sum
    return max(0, ($sim * 0.5) + ($lev_score * 0.3) + ($sx * 0.2));
}

// --- 1. GET USER MESSAGE ---
$data = json_decode(file_get_contents('php://input'), true);
$rawMessage = $data['message'] ?? '';
$userMessageRaw = trim($rawMessage);

if (empty($userMessageRaw)) {
    echo json_encode(['answer' => 'Please ask a question.']);
    exit;
}

$userMessage = clean_text($userMessageRaw);

// --- 2. CONNECT TO DB ---
$dbConfig = [
    'host' => '127.0.0.1',
    'dbname' => 'db_explore_manaoag',
    'user' => 'root',
    'pass' => ''
];
$database = new Database($dbConfig);
$db = $database->getConnection();
if (!$db) {
    echo json_encode(['answer' => 'System Error: Database connection failed.']);
    exit;
}

// --- 3. INTENT / SYNONYMS / SIGNALS ---
$intent_signals = [
    'products' => ['buy','bili','where can i buy','saan bumili','saan makakabili','order','mag-order','purchase','pabili','pabili ako','tinda','tindahan','pandesal','tinapay','bread','kain','merienda'],
    'delivery' => ['deliver','delivery','mag-deliver','magpa-deliver','deliveries','deliveries','on the go','woi','courier','pick up','pick-up','pickup','padala','padalhan'],
    'spots' => ['spot','place','tour','tourist','where to visit','sight','pasyalan','resort','hotel','basilica','church','muse','museum','heritage','historical','visit','where to go','pasyal'],
    'parking' => ['parking','park','parking area','parking lot','bayad parking','parking fee','parke','parking'],
    'events' => ['event','festival','fiesta','konserto','concert','celebrate','ganap','schedule','upcoming'],
    'guides' => ['guide','tour guide','guide_name','tour guide','guide','book guide','gabay','guide tour','food tour'],
    'links' => ['link','website','web','official','useful link','links','government','povince','pangasinan']
];

// custom synonym map (common local words)
$synonyms = [
    'pandesal' => ['pandesal','tinapay','bread'],
    'tupig' => ['tupig','patupat','puto','kakanin','native delicacy','kakanin'],
    'on the go' => ['on the go','on-the-go','onthego'],
    'woi' => ['woi']
];

// tokenize user for quick checks
$user_tokens = preg_split('/\s+/', $userMessage);

// quick intent detection by presence of signals
$detected_intents = [];
foreach ($intent_signals as $intent => $keywords) {
    foreach ($keywords as $kw) {
        $kw_clean = clean_text($kw);
        if (mb_strpos($userMessage, $kw_clean) !== false) {
            $detected_intents[$intent] = ($detected_intents[$intent] ?? 0) + 1;
        }
    }
}
// synonyms check
foreach ($synonyms as $k => $variants) {
    foreach ($variants as $v) {
        if (mb_strpos($userMessage, clean_text($v)) !== false) {
            // map synonyms to probable intent: pandesal => products
            if ($k === 'pandesal' || $k === 'tupig') {
                $detected_intents['products'] = ($detected_intents['products'] ?? 0) + 2;
            }
            if ($k === 'on the go' || $k === 'woi') {
                $detected_intents['delivery'] = ($detected_intents['delivery'] ?? 0) + 2;
            }
        }
    }
}

// If user asks a question starting with where/where can i/ saan, prefer product/delivery/spots
if (preg_match('/\b(where|saan|how|paano|sino|saan ba)\b/', $userMessage)) {
    // boost general discovery intents
    $detected_intents['products'] = ($detected_intents['products'] ?? 0) + 0.5;
    $detected_intents['spots'] = ($detected_intents['spots'] ?? 0) + 0.3;
    $detected_intents['delivery'] = ($detected_intents['delivery'] ?? 0) + 0.3;
}

// --- 4. UNIVERSAL FETCH (pull data to PHP to perform fuzzy matching) ---
$tables_to_fetch = [
    'tourist_spots' => "SELECT id, name, description, address, image_url, category FROM tourist_spots",
    'products' => "SELECT id, name, description, image_url, category FROM products",
    'delivery_services' => "SELECT id, name, description, image_url, contact_number FROM delivery_services",
    'parking_areas' => "SELECT id, name, address, description, image_url, fees, operating_hours FROM parking_areas",
    'guides' => "SELECT id, guide_name, description, image_url, contact_number, specialization FROM guides",
    'events' => "SELECT id, event_name, description, image_url, start_date, location FROM events",
    'useful_links' => "SELECT id, title, url, description, category FROM useful_links"
];

$fetched = [];
foreach ($tables_to_fetch as $key => $sql) {
    try {
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $fetched[$key] = $rows ?: [];
    } catch (Exception $e) {
        $fetched[$key] = [];
    }
}

// --- 5. FUZZY RANKING ACROSS TABLES ---
$results = []; // each item: ['type'=>, 'score'=>, 'row'=>, 'label'=>]

function rank_candidates($candidates, $userMessage, $fields, $typeName) {
    $out = [];
    $needle = $userMessage;
    foreach ($candidates as $row) {
        $best = 0.0;
        $combined_text = [];
        foreach ($fields as $f) {
            if (!isset($row[$f])) continue;
            $val = clean_text((string)$row[$f]);
            if ($val === '') continue;
            $s = score_text_similarity($needle, $val);
            $best = max($best, $s);
            $combined_text[] = $val;
        }
        // token overlap boost
        $token_overlap = 0;
        $needle_tokens = preg_split('/\s+/', $needle);
        $haytext = implode(' ', $combined_text);
        foreach ($needle_tokens as $t) {
            if (mb_strlen($t) < 2) continue;
            if (mb_strpos($haytext, $t) !== false) $token_overlap += 0.05;
        }
        $final_score = min(1.0, ($best * 0.9) + $token_overlap);
        // penalize stale events (past) slightly unless user explicitly said event
        if ($typeName === 'events' && isset($row['start_date'])) {
            $start = strtotime($row['start_date']);
            if ($start !== false && $start < time()) {
                $final_score *= 0.8;
            }
        }
        if ($final_score > 0.18) {
            $out[] = ['type'=>$typeName, 'score'=>$final_score, 'row'=>$row];
        }
    }
    // sort desc by score
    usort($out, function($a,$b){ return $b['score'] <=> $a['score']; });
    return $out;
}

// generate candidate lists per table
$results = array_merge(
    rank_candidates($fetched['tourist_spots'], $userMessage, ['name','description','category','address'], 'spots'),
    rank_candidates($fetched['products'], $userMessage, ['name','description','category'], 'products'),
    rank_candidates($fetched['delivery_services'], $userMessage, ['name','description'], 'delivery'),
    rank_candidates($fetched['parking_areas'], $userMessage, ['name','address','description'], 'parking'),
    rank_candidates($fetched['guides'], $userMessage, ['guide_name','description','specialization'], 'guides'),
    rank_candidates($fetched['events'], $userMessage, ['event_name','description','location'], 'events'),
    rank_candidates($fetched['useful_links'], $userMessage, ['title','description','category'], 'links')
);

// If no good fuzzy matches found, fallback to SQL LIKE search across key tables (quick)
if (empty($results)) {
    $keyword = '%' . str_replace(' ', '%', $userMessage) . '%';
    // try many tables for lenient LIKE
    $try_sqls = [
        ['sql'=>"SELECT name, description, address, image_url, category FROM tourist_spots WHERE name LIKE :k OR description LIKE :k OR category LIKE :k", 'type'=>'spots'],
        ['sql'=>"SELECT name, description, image_url, category FROM products WHERE name LIKE :k OR description LIKE :k OR category LIKE :k", 'type'=>'products'],
        ['sql'=>"SELECT name, description, image_url, contact_number FROM delivery_services WHERE name LIKE :k OR description LIKE :k", 'type'=>'delivery'],
        ['sql'=>"SELECT name, address, description, image_url FROM parking_areas WHERE name LIKE :k OR address LIKE :k OR description LIKE :k", 'type'=>'parking'],
        ['sql'=>"SELECT guide_name, description, image_url, specialization FROM guides WHERE guide_name LIKE :k OR description LIKE :k OR specialization LIKE :k", 'type'=>'guides'],
    ];
    foreach ($try_sqls as $t) {
        try {
            $st = $db->prepare($t['sql']);
            $st->bindValue(':k', $keyword);
            $st->execute();
            $rows = $st->fetchAll(PDO::FETCH_ASSOC);
            if ($rows) {
                foreach ($rows as $r) {
                    $results[] = ['type'=>$t['type'], 'score'=>0.5, 'row'=>$r];
                }
            }
        } catch (Exception $e) {}
    }
}

// --- 6. DECIDE BEST RESPONSE BASED ON DETECTED INTENTS & TOP RESULTS ---
usort($results, function($a,$b){ return $b['score'] <=> $a['score']; });

$top = $results[0] ?? null;

// If detected intent strongly points to a category, prioritize those results
if ($detected_intents) {
    // find highest detected intent
    arsort($detected_intents);
    $primary_intent = array_key_first($detected_intents);
    // attempt to pick a top result matching that intent
    foreach ($results as $r) {
        if ($r['type'] === $primary_intent) {
            $top = $r;
            break;
        }
    }
}

// Build HTML responses per type
if ($top && $top['score'] >= 0.25) {
    $type = $top['type'];
    $row = $top['row'];

    if ($type === 'spots') {
        $img = generateImage($row['image_url'] ?? '');
        $address = $row['address'] ?? 'Manaoag';
        $map = generateMap($row['name'] ?? 'Spot', $address);
        $desc = $row['description'] ?? '';
        $category = $row['category'] ?? '';
        $html = "{$img}<b>{$row['name']}</b> ({$category})<br>📍 {$address}<br><br>{$desc}<br>{$map}";
        echo json_encode(['answer' => $html]);
        exit;
    }

    if ($type === 'products') {
        $img = generateImage($row['image_url'] ?? '');
        $desc = $row['description'] ?? '';
        $category = $row['category'] ?? 'Food';
        $html = "{$img}<b>{$row['name']}</b> ({$category})<br>{$desc}";
        // optionally, suggest delivery if delivery intent present
        if (isset($detected_intents['delivery'])) {
            $html .= "<br><br><i>Need delivery? Ask 'deliver' or 'saan magpa-deliver'.</i>";
        }
        echo json_encode(['answer' => $html]);
        exit;
    }

    if ($type === 'delivery') {
        $img = generateImage($row['image_url'] ?? '');
        $contact = $row['contact_number'] ?? '';
        $desc = $row['description'] ?? '';
        $html = "{$img}Delivery Service: <b>{$row['name']}</b><br>{$desc}<br>📞 {$contact}";
        echo json_encode(['answer' => $html]);
        exit;
    }

    if ($type === 'parking') {
        $img = generateImage($row['image_url'] ?? '');
        $fees = $row['fees'] ?? 'Varies';
        $hours = $row['operating_hours'] ?? '';
        $addr = $row['address'] ?? '';
        $map = generateMap($row['name'] ?? 'Parking', $addr);
        $html = "{$img}<b>{$row['name']}</b><br>Address: {$addr}<br>Fees: {$fees} <br>Hours: {$hours}<br>{$map}";
        echo json_encode(['answer' => $html]);
        exit;
    }

    if ($type === 'guides') {
        $img = generateImage($row['image_url'] ?? '');
        $contact = $row['contact_number'] ?? '';
        $spec = $row['specialization'] ?? '';
        $html = "{$img}<b>{$row['guide_name']}</b><br>Specialization: {$spec}<br>{$row['description']}<br>📞 {$contact}";
        echo json_encode(['answer' => $html]);
        exit;
    }

    if ($type === 'events') {
        $img = generateImage($row['image_url'] ?? '');
        $date = isset($row['start_date']) ? date('F j, Y', strtotime($row['start_date'])) : '';
        $loc = $row['location'] ?? '';
        $html = "{$img}<b>{$row['event_name']}</b><br>📅 {$date} @ {$loc}<br><i>{$row['description']}</i>";
        $html .= generateMap($row['event_name'] ?? 'Event', $loc);
        echo json_encode(['answer' => $html]);
        exit;
    }

    if ($type === 'links') {
        $title = $row['title'] ?? $row['name'] ?? 'Link';
        $desc = $row['description'] ?? '';
        $url = $row['url'] ?? '#';
        $html = "<b>{$title}</b><br>{$desc}<br><a href='{$url}' target='_blank' rel='noopener noreferrer'>{$url}</a>";
        echo json_encode(['answer' => $html]);
        exit;
    }
}

// --- 7. FAQ fallback (smart) ---
$stmt = $db->prepare("SELECT answer FROM faqs WHERE question LIKE :k OR answer LIKE :k LIMIT 1");
$like = '%' . str_replace(' ', '%', $userMessage) . '%';
$stmt->bindValue(':k', $like);
$stmt->execute();
$faq = $stmt->fetch(PDO::FETCH_ASSOC);
if ($faq) {
    echo json_encode(['answer' => $faq['answer']]);
    exit;
}

// --- 8. Intent-driven suggestions (if nothing found) ---
$suggest = [];
if (isset($detected_intents['products'])) $suggest[] = "Try searching product names (e.g., 'Tupig', 'Patupat', 'Pandesal').";
if (isset($detected_intents['delivery'])) $suggest[] = "Try 'delivery', 'On the Go', or a courier name like 'WOI'.";
if (isset($detected_intents['spots'])) $suggest[] = "Try 'Manaoag Hotel' or 'Minor Basilica of Our Lady of Manaoag'.";
if (isset($detected_intents['parking'])) $suggest[] = "Try 'parking' to list parking areas.";
if (isset($detected_intents['guides'])) $suggest[] = "Try 'guide' or 'food tour' to find local guides.";

$sugg_text = $suggest ? "<br><br><i>Suggestions: " . implode(' ', $suggest) . "</i>" : "";
echo json_encode(['answer' => "I'm sorry, I couldn't find anything matching that. Try searching for 'Resorts', 'Food', 'Parking', 'Delivery', or specific names like 'Manaoag Hotel'." . $sugg_text]);
exit;
?>
