<?php
class Faq {
    private $conn;
    private $table = 'faqs';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY `category` ASC, `question` ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table . " 
                  SET question = :question, 
                      answer = :answer,
                      category = :category";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':question', htmlspecialchars(strip_tags($data['question'])));
        $stmt->bindValue(':answer', $data['answer']); 
        $stmt->bindValue(':category', htmlspecialchars(strip_tags($data['category'])));
        return $stmt->execute();
    }

    public function update($data) {
        $query = "UPDATE " . $this->table . "
                  SET question = :question, 
                      answer = :answer,
                      category = :category
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        // FIX: bindValue na lahat
        $stmt->bindValue(':id', (int)$data['id']);
        $stmt->bindValue(':question', htmlspecialchars(strip_tags($data['question'])));
        $stmt->bindValue(':answer', $data['answer']);
        $stmt->bindValue(':category', htmlspecialchars(strip_tags($data['category'])));
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', (int)$id);
        return $stmt->execute();
    }

    public function search($searchTerm) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE `question` LIKE :term 
                  OR `answer` LIKE :term";
        
        $stmt = $this->conn->prepare($query);
        $term = '%' . $searchTerm . '%';
        $stmt->bindValue(':term', $term);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>