<?php
session_start();
header('Content-Type: application/json');

define('BASE_PATH', dirname(__DIR__));
require_once BASE_PATH . '/src/core/Database.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['endpoint'])) {
    echo json_encode(['success' => false, 'message' => 'No endpoint.']);
    exit;
}

$dbConfig = [
    'host' => '127.0.0.1',
    'dbname' => 'db_explore_manaoag',
    'user' => 'root',
    'pass' => '' 
];
$database = new Database($dbConfig);
$db = $database->getConnection();

if (!$db) {
    echo json_encode(['success' => false, 'message' => 'DB error.']);
    exit;
}

try {
    $endpoint = $data['endpoint'];
    $p256dh = $data['keys']['p256dh'];
    $auth = $data['keys']['auth'];
    $userId = $_SESSION['user_id'] ?? null;

    $query = "INSERT INTO push_subscriptions (endpoint, p256dh, auth, user_id) 
              VALUES (:endpoint, :p256dh, :auth, :user_id)
              ON DUPLICATE KEY UPDATE 
              p256dh = :p256dh, auth = :auth, user_id = :user_id";
              
    $stmt = $db->prepare($query);
    $stmt->bindParam(':endpoint', $endpoint);
    $stmt->bindParam(':p256dh', $p256dh);
    $stmt->bindParam(':auth', $auth);
    $stmt->bindParam(':user_id', $userId);
    
    $stmt->execute();

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>