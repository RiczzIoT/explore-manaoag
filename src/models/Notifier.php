<?php



use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

class Notifier {
    private $db;
    private $webPush;
    private $auth;

    public function __construct($db) {
        $this->db = $db;
        
        
        $config = require(BASE_PATH . '/src/core/config.php');
        $this->auth = $config['vapid'];

        $this->webPush = new WebPush($this->auth);
    }

    
    public function sendToAll($title, $message) {
        
        $query = "SELECT * FROM push_subscriptions";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $subscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        
        $payload = json_encode([
            'title' => $title,
            'body' => $message,
            
            
            'icon' => '/explore-manaoag/public/images/manaoag-seal.png' 
        ]);

        
        foreach ($subscriptions as $sub) {
            $subscription = Subscription::create([
                'endpoint' => $sub['endpoint'],
                'publicKey' => $sub['p256dh'],
                'authToken' => $sub['auth'],
            ]);
            
            $this->webPush->queueNotification(
                $subscription,
                $payload
            );
        }

        
        $results = [];
        foreach ($this->webPush->flush() as $report) {
            $endpoint = $report->getRequest()->getUri()->__toString();
            if ($report->isSuccess()) {
                $results[] = "Message sent successfully for: {$endpoint}";
            } else {
                $results[] = "Message failed to send for: {$endpoint} with reason: {$report->getReason()}";
            }
        }
        return $results; 
    }
}
?>