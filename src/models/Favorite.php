<?php
class Favorite {
    private $conn;
    private $table = 'user_favorites';

    public function __construct($db) {
        $this->conn = $db;
    }


    public function isFavorite($userId, $itemType, $itemId) {
        $query = "SELECT id FROM " . $this->table . " 
                  WHERE user_id = :user_id AND item_type = :item_type AND item_id = :item_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':item_type', $itemType);
        $stmt->bindParam(':item_id', $itemId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    }


    public function add($userId, $itemType, $itemId) {
        if ($this->isFavorite($userId, $itemType, $itemId)) {
            return true;
        }
        
        $query = "INSERT INTO " . $this->table . " (user_id, item_type, item_id) 
                  VALUES (:user_id, :item_type, :item_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':item_type', $itemType);
        $stmt->bindParam(':item_id', $itemId);
        return $stmt->execute();
    }


    public function remove($userId, $itemType, $itemId) {
        $query = "DELETE FROM " . $this->table . " 
                  WHERE user_id = :user_id AND item_type = :item_type AND item_id = :item_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':item_type', $itemType);
        $stmt->bindParam(':item_id', $itemId);
        return $stmt->execute();
    }


    public function getAllByUser($userId) {
        $query = "
            (SELECT 'spot' as type, p.id, p.name, p.image_url, p.description FROM tourist_spots p
             JOIN user_favorites f ON f.item_id = p.id
             WHERE f.user_id = :user_id AND f.item_type = 'spot')
            UNION
            (SELECT 'product' as type, pr.id, pr.name, pr.image_url, pr.description FROM products pr
             JOIN user_favorites f ON f.item_id = pr.id
             WHERE f.user_id = :user_id AND f.item_type = 'product')
            UNION
            (SELECT 'parking' as type, pk.id, pk.name, pk.image_url, pk.description FROM parking_areas pk
             JOIN user_favorites f ON f.item_id = pk.id
             WHERE f.user_id = :user_id AND f.item_type = 'parking')
        ";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>