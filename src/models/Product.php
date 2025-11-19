<?php
class Product {
    private $conn;
    private $table = 'products';

    public function __construct($db) {
        $this->conn = $db;
    }

    
    public function getAll($limit = null) {
        $query = "SELECT * FROM " . $this->table . " ORDER BY `name` ASC";
        if ($limit) {
            $query .= " LIMIT " . (int)$limit;
        }
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    public function create($data) {
        $query = "INSERT INTO " . $this->table . " 
                  SET name = :name, 
                      description = :description, 
                      image_url = :image_url, 
                      category = :category";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', htmlspecialchars(strip_tags($data['name'])));
        $stmt->bindParam(':description', htmlspecialchars(strip_tags($data['description'])));
        $stmt->bindParam(':image_url', htmlspecialchars(strip_tags($data['image_url'])));
        $stmt->bindParam(':category', htmlspecialchars(strip_tags($data['category'])));
        return $stmt->execute();
    }

    
    public function update($data) {
        $query = "UPDATE " . $this->table . "
                  SET name = :name, 
                      description = :description, 
                      image_url = :image_url, 
                      category = :category
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', (int)$data['id']); 
        $stmt->bindParam(':name', htmlspecialchars(strip_tags($data['name'])));
        $stmt->bindParam(':description', htmlspecialchars(strip_tags($data['description'])));
        $stmt->bindParam(':image_url', htmlspecialchars(strip_tags($data['image_url'])));
        $stmt->bindParam(':category', htmlspecialchars(strip_tags($data['category'])));
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
                  WHERE `name` LIKE :term 
                  OR `description` LIKE :term 
                  OR `category` LIKE :term";
        
        $stmt = $this->conn->prepare($query);
        $term = '%' . $searchTerm . '%';
        $stmt->bindParam(':term', $term);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function getCounts() {
        $query = "SELECT COUNT(id) as total FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }
}
?>