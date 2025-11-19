<?php
class Guide {
    private $conn;
    private $table = 'guides';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll($limit = null) {
        $query = "SELECT * FROM " . $this->table . " ORDER BY `guide_name` ASC";
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
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table . " 
                  SET guide_name = :guide_name, 
                      description = :description, 
                      image_url = :image_url, 
                      contact_number = :contact_number,
                      facebook_link = :facebook_link,
                      specialization = :specialization";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':guide_name', htmlspecialchars(strip_tags($data['guide_name'])));
        $stmt->bindValue(':description', htmlspecialchars(strip_tags($data['description'])));
        $stmt->bindValue(':image_url', htmlspecialchars(strip_tags($data['image_url'])));
        $stmt->bindValue(':contact_number', htmlspecialchars(strip_tags($data['contact_number'])));
        $stmt->bindValue(':facebook_link', htmlspecialchars(strip_tags($data['facebook_link'])));
        $stmt->bindValue(':specialization', htmlspecialchars(strip_tags($data['specialization'])));
        return $stmt->execute();
    }

    public function update($data) {
        $query = "UPDATE " . $this->table . "
                  SET guide_name = :guide_name, 
                      description = :description, 
                      image_url = :image_url, 
                      contact_number = :contact_number,
                      facebook_link = :facebook_link,
                      specialization = :specialization
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        // FIX: bindValue na lahat
        $stmt->bindValue(':id', (int)$data['id']);
        $stmt->bindValue(':guide_name', htmlspecialchars(strip_tags($data['guide_name'])));
        $stmt->bindValue(':description', htmlspecialchars(strip_tags($data['description'])));
        $stmt->bindValue(':image_url', htmlspecialchars(strip_tags($data['image_url'])));
        $stmt->bindValue(':contact_number', htmlspecialchars(strip_tags($data['contact_number'])));
        $stmt->bindValue(':facebook_link', htmlspecialchars(strip_tags($data['facebook_link'])));
        $stmt->bindValue(':specialization', htmlspecialchars(strip_tags($data['specialization'])));
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
                  WHERE `guide_name` LIKE :term 
                  OR `description` LIKE :term
                  OR `specialization` LIKE :term";
        
        $stmt = $this->conn->prepare($query);
        $term = '%' . $searchTerm . '%';
        $stmt->bindValue(':term', $term);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>