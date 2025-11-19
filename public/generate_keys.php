<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';

use Minishlink\WebPush\VAPID;

try {
    $keys = VAPID::createVapidKeys();
    
    echo "<h3>Kopyahin mo 'to:</h3>";
    
    echo "<pre><strong>Public Key:</strong><br>";
    echo $keys['publicKey'];
    echo "</pre>";
    
    echo "<pre><strong>Private Key:</strong><br>";
    echo $keys['privateKey'];
    echo "</pre>";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>