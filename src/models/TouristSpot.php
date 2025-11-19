<?php
class TouristSpot {
    private $conn;
    private $table = 'tourist_spots';

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
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // --- FIXED CREATE FUNCTION (Raw Data na ang ise-save) ---
    public function create($data) {
        $query = "INSERT INTO " . $this->table . " 
                  SET name = :name, 
                      description = :description, 
                      image_url = :image_url, 
                      address = :address, 
                      gmap_link = :gmap_link, 
                      category = :category";
        
        $stmt = $this->conn->prepare($query);

        // FIX: Tinanggal ang htmlspecialchars/strip_tags para ma-save yung symbols
        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':description', $data['description']);
        $stmt->bindValue(':image_url', $data['image_url']);
        $stmt->bindValue(':address', $data['address']);
        $stmt->bindValue(':gmap_link', $data['gmap_link']);
        $stmt->bindValue(':category', $data['category']);

        return $stmt->execute();
    }

    // --- FIXED UPDATE FUNCTION (Raw Data na ang ise-save) ---
    public function update($data) {
        $query = "UPDATE " . $this->table . "
                  SET name = :name, 
                      description = :description, 
                      image_url = :image_url, 
                      address = :address, 
                      gmap_link = :gmap_link, 
                      category = :category
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);

        // FIX: Tinanggal ang htmlspecialchars/strip_tags
        $stmt->bindValue(':id', (int)$data['id']);
        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':description', $data['description']);
        $stmt->bindValue(':image_url', $data['image_url']);
        $stmt->bindValue(':address', $data['address']);
        $stmt->bindValue(':gmap_link', $data['gmap_link']);
        $stmt->bindValue(':category', $data['category']);

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
        $stmt->bindValue(':term', $term);
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