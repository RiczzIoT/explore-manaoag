<?php
header('Content-Type: application/json');

define('BASE_PATH', dirname(__DIR__));
require_once BASE_PATH . '/src/core/Database.php';
require_once BASE_PATH . '/src/models/Faq.php';

$data = json_decode(file_get_contents('php://input'), true);
$userMessage = $data['message'] ?? '';

$response = ['answer' => 'I am sorry, I do not understand that question. Please try asking in a different way.'];

if (empty($userMessage)) {
    echo json_encode($response);
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
    echo json_encode(['answer' => 'Error: Could not connect to the database.']);
    exit;
}

$faqModel = new Faq($db);
$results = $faqModel->search($userMessage);

if (!empty($results)) {
    $response['answer'] = $results[0]['answer'];
}

echo json_encode($response);
exit;
?>