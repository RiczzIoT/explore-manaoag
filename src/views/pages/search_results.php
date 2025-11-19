<style>
.spots-header { text-align: center; background-color: #003366; color: white; padding: 40px 20px; margin-bottom: 40px; }
.spots-header h2 { font-size: 3em; font-weight: 900; }
.spots-header p { font-size: 1.2em; color: #eee; margin-top: 10px; }
.search-results-container { max-width: 1200px; margin: 0 auto; padding: 0 20px; min-height: 50vh; }
.results-section { margin-bottom: 40px; }
.results-section h3 { font-size: 2em; color: #003366; margin-top: 0; margin-bottom: 20px; border-bottom: 2px solid #ddd; padding-bottom: 10px; }

.global-no-results {
    text-align: center;
    padding: 50px;
    background: #f9fafb;
    border-radius: 8px;
    border: 1px dashed #ccc;
}
.global-no-results i { font-size: 3em; color: #9ca3af; margin-bottom: 15px; }
.global-no-results p { font-size: 1.2em; color: #555; }

.spot-card { display: flex; background: #fff; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); overflow: hidden; margin-bottom: 20px; }
.spot-card img { width: 250px; height: 180px; object-fit: cover; }
.spot-card-content { padding: 20px; flex-grow: 1; }
.spot-card-content h3 { font-size: 1.5em; color: #003366; margin-bottom: 10px; margin-top: 0; }
.spot-card-content p { font-size: 1em; line-height: 1.6; color: #555; }
.map-link-btn { display: inline-block; background-color: #007bff; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none; font-weight: bold; margin-top: 15px; }

.official-card { display: inline-block; width: 220px; text-align: center; border: 2px solid #003366; border-radius: 10px; padding: 15px; margin: 10px; background-color: #fff; vertical-align: top; }
.official-card img { width: 100%; height: 250px; object-fit: cover; border-radius: 8px; margin-bottom: 10px; }
.official-card h3 { color: #003366; font-size: 1.2em; margin: 10px 0 5px; }
.official-card p { font-size: 1em; color: #555; text-transform: capitalize; margin: 0; }

.faq-item { background: #fff; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 10px; }
.faq-item summary { font-size: 1.2em; font-weight: bold; padding: 15px; cursor: pointer; outline: none; }
.faq-item div { padding: 0 15px 15px; line-height: 1.6; color: #555; }
</style>

<div class="spots-header">
    <h2>Search Results</h2>
    <p>You searched for: "<strong><?php echo htmlspecialchars($searchTerm); ?></strong>"</p>
</div>

<div class="search-results-container">

    <?php 
    $totalResults = count($links) + count($faqs) + count($guides) + count($spots) + 
                    count($parking) + count($delivery) + count($events) + 
                    count($products) + count($officials);
    ?>

    <?php if ($totalResults === 0): ?>
        <div class="global-no-results">
            <i class="fa-regular fa-face-frown"></i>
            <p>Sorry, no results found for "<?php echo htmlspecialchars($searchTerm); ?>".</p>
            <p style="font-size: 0.9em; margin-top: 10px;">Try checking your spelling or use different keywords.</p>
            <a href="index.php?page=home" style="display: inline-block; margin-top: 20px; color: #007bff; text-decoration: none; font-weight: bold;">&larr; Go back Home</a>
        </div>

    <?php else: ?>
        <?php if (!empty($events)): ?>
        <div class="results-section">
            <h3>Events & Festivals</h3>
            <?php foreach ($events as $event): ?>
                <div class="spot-card">
                    <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($event['image_url'] ?? 'default.png'); ?>" alt="<?php echo htmlspecialchars($event['event_name']); ?>">
                    <div class="spot-card-content">
                        <h3><a href="index.php?page=events#event-<?php echo $event['id']; ?>"><?php echo htmlspecialchars($event['event_name']); ?></a></h3>
                        <p><strong>When:</strong> <?php echo date('F j, Y, g:i a', strtotime($event['start_date'])); ?></p>
                        <p><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($spots)): ?>
        <div class="results-section">
            <h3>Tourist Spots & Places</h3>
            <?php foreach ($spots as $spot): ?>
                <div class="spot-card">
                    <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($spot['image_url'] ?? 'default.png'); ?>" alt="<?php echo htmlspecialchars($spot['name']); ?>">
                    <div class="spot-card-content">
                        <h3><a href="index.php?page=spots#spot-<?php echo $spot['id']; ?>"><?php echo htmlspecialchars($spot['name']); ?></a></h3>
                        <p><?php echo nl2br(htmlspecialchars($spot['description'])); ?></p>
                        <?php if (!empty($spot['gmap_link'])): ?>
                            <a href="<?php echo htmlspecialchars($spot['gmap_link']); ?>" target="_blank" class="map-link-btn">View on Google Maps</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($products)): ?>
        <div class="results-section">
            <h3>Food & Products</h3>
            <?php foreach ($products as $product): ?>
                <div class="spot-card">
                    <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($product['image_url'] ?? 'default.png'); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <div class="spot-card-content">
                        <h3><a href="index.php?page=products#product-<?php echo $product['id']; ?>"><?php echo htmlspecialchars($product['name']); ?></a></h3>
                        <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($guides)): ?>
        <div class="results-section">
            <h3>Digital Tour Guides</h3>
            <?php foreach ($guides as $guide): ?>
                <div class="spot-card">
                    <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($guide['image_url'] ?? 'default.png'); ?>" alt="<?php echo htmlspecialchars($guide['guide_name']); ?>">
                    <div class="spot-card-content">
                        <h3><a href="index.php?page=guides#guide-<?php echo $guide['id']; ?>"><?php echo htmlspecialchars($guide['guide_name']); ?></a></h3>
                        <p><strong>Specialization:</strong> <?php echo htmlspecialchars($guide['specialization']); ?></p>
                        <p><?php echo nl2br(htmlspecialchars($guide['description'])); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($parking)): ?>
        <div class="results-section">
            <h3>Parking Areas</h3>
            <?php foreach ($parking as $park): ?>
                <div class="spot-card">
                    <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($park['image_url'] ?? 'default.png'); ?>" alt="<?php echo htmlspecialchars($park['name']); ?>">
                    <div class="spot-card-content">
                        <h3><a href="index.php?page=parking#parking-<?php echo $park['id']; ?>"><?php echo htmlspecialchars($park['name']); ?></a></h3>
                        <p><strong>Fees:</strong> <?php echo htmlspecialchars($park['fees']); ?></p>
                        <p><?php echo nl2br(htmlspecialchars($park['description'])); ?></p>
                        <?php if (!empty($park['gmap_link'])): ?>
                            <a href="<?php echo htmlspecialchars($park['gmap_link']); ?>" target="_blank" class="map-link-btn">View on Google Maps</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($delivery)): ?>
        <div class="results-section">
            <h3>Delivery Services</h3>
            <?php foreach ($delivery as $del): ?>
                <div class="spot-card">
                    <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($del['image_url'] ?? 'default.png'); ?>" alt="<?php echo htmlspecialchars($del['name']); ?>">
                    <div class="spot-card-content">
                        <h3><a href="index.php?page=delivery#delivery-<?php echo $del['id']; ?>"><?php echo htmlspecialchars($del['name']); ?></a></h3>
                        <p><strong>Contact:</strong> <?php echo htmlspecialchars($del['contact_number']); ?></p>
                        <p><?php echo nl2br(htmlspecialchars($del['description'])); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($officials)): ?>
        <div class="results-section">
            <h3>Government Officials</h3>
            <?php foreach ($officials as $official): ?>
                <div class="official-card">
                    <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($official['image_url'] ?? 'default.png'); ?>" alt="<?php echo htmlspecialchars($official['name']); ?>">
                    <h3><a href="index.php?page=<?php echo $official['position']; ?>"><?php echo htmlspecialchars($official['name']); ?></a></h3>
                    <p><?php echo htmlspecialchars($official['position']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($links)): ?>
        <div class="results-section">
            <h3>Useful Links</h3>
            <?php foreach ($links as $link): ?>
                <div class="spot-card">
                    <div class="spot-card-content">
                        <h3><a href="<?php echo htmlspecialchars($link['url']); ?>" target="_blank"><?php echo htmlspecialchars($link['title']); ?></a></h3>
                        <p><?php echo nl2br(htmlspecialchars($link['description'])); ?></p>
                        <a href="<?php echo htmlspecialchars($link['url']); ?>" target="_blank" class="map-link-btn">Visit Link</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
        <?php if (!empty($faqs)): ?>
        <div class="results-section">
            <h3>Frequently Asked Questions</h3>
            <?php foreach ($faqs as $faq): ?>
                <details class="faq-item">
                    <summary><?php echo htmlspecialchars($faq['question']); ?></summary>
                    <div><?php echo nl2br(htmlspecialchars($faq['answer'])); ?></div>
                </details>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    <?php endif; ?>

</div>