<?php
class Feedback {
    private $conn;
    private $table = 'feedback';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Kunin lahat ng feedback (para sa admin)
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY `created_at` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Kunin lang yung mga "Approved" (para sa public)
    public function getAllApproved($itemType, $itemId) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE item_type = :item_type AND item_id = :item_id AND is_approved = 1
                  ORDER BY `created_at` DESC";
        $stmt = $this->conn->prepare($query);
        // FIX: bindValue na
        $stmt->bindValue(':item_type', $itemType);
        $stmt->bindValue(':item_id', $itemId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Kumuha by ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Gumawa ng bagong feedback
    public function create($data) {
        $query = "INSERT INTO " . $this->table . " 
                  SET user_id = :user_id, 
                      user_name = :user_name,
                      rating = :rating, 
                      comment = :comment, 
                      item_type = :item_type, 
                      item_id = :item_id,
                      is_approved = 0"; // Laging pending
        
        $stmt = $this->conn->prepare($query);
        
        // CRITICAL FIX: Pinalitan ng bindValue lahat para gumana ang htmlspecialchars
        $stmt->bindValue(':user_id', $data['user_id']);
        $stmt->bindValue(':user_name', htmlspecialchars(strip_tags($data['user_name'])));
        $stmt->bindValue(':rating', $data['rating']);
        $stmt->bindValue(':comment', htmlspecialchars(strip_tags($data['comment'])));
        $stmt->bindValue(':item_type', htmlspecialchars(strip_tags($data['item_type'])));
        $stmt->bindValue(':item_id', $data['item_id']);
        
        return $stmt->execute();
    }

    // I-approve ang feedback
    public function approve($id) {
        $query = "UPDATE " . $this->table . " SET is_approved = 1 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
    
    // I-unapprove ang feedback
    public function unapprove($id) {
        $query = "UPDATE " . $this->table . " SET is_approved = 0 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    // Mag-delete
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', (int)$id);
        return $stmt->execute();
    }

    // --- ITO YUNG DAGDAG PARA SA DASHBOARD ---
    public function getPendingCount() {
        $query = "SELECT COUNT(id) as total FROM " . $this->table . " WHERE is_approved = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }
}
?>