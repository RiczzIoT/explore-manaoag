<?php
class Link {
    private $conn;
    private $table = 'useful_links';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY `title` ASC";
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
                  SET title = :title, 
                      url = :url,
                      description = :description, 
                      category = :category";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindValue(':title', htmlspecialchars(strip_tags($data['title'])));
        $stmt->bindValue(':url', htmlspecialchars(strip_tags($data['url'])));
        $stmt->bindValue(':description', htmlspecialchars(strip_tags($data['description'])));
        $stmt->bindValue(':category', htmlspecialchars(strip_tags($data['category'])));
        return $stmt->execute();
    }

    public function update($data) {
        $query = "UPDATE " . $this->table . "
                  SET title = :title, 
                      url = :url,
                      description = :description, 
                      category = :category
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        
        $stmt->bindValue(':id', (int)$data['id']);
        $stmt->bindValue(':title', htmlspecialchars(strip_tags($data['title'])));
        $stmt->bindValue(':url', htmlspecialchars(strip_tags($data['url'])));
        $stmt->bindValue(':description', htmlspecialchars(strip_tags($data['description'])));
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
                  WHERE `title` LIKE :term 
                  OR `description` LIKE :term
                  OR `category` LIKE :term";
        
        $stmt = $this->conn->prepare($query);
        $term = '%' . $searchTerm . '%';
        $stmt->bindParam(':term', $term);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>