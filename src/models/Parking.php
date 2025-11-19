<?php
class Parking {
    private $conn;
    private $table = 'parking_areas';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY `name` ASC";
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
                  SET name = :name, 
                      address = :address,
                      description = :description, 
                      image_url = :image_url, 
                      gmap_link = :gmap_link,
                      operating_hours = :operating_hours,
                      fees = :fees";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':name', htmlspecialchars(strip_tags($data['name'])));
        $stmt->bindValue(':address', htmlspecialchars(strip_tags($data['address'])));
        $stmt->bindValue(':description', htmlspecialchars(strip_tags($data['description'])));
        $stmt->bindValue(':image_url', htmlspecialchars(strip_tags($data['image_url'])));
        $stmt->bindValue(':gmap_link', htmlspecialchars(strip_tags($data['gmap_link'])));
        $stmt->bindValue(':operating_hours', htmlspecialchars(strip_tags($data['operating_hours'])));
        $stmt->bindValue(':fees', htmlspecialchars(strip_tags($data['fees'])));
        return $stmt->execute();
    }

    public function update($data) {
        $query = "UPDATE " . $this->table . "
                  SET name = :name, 
                      address = :address,
                      description = :description, 
                      image_url = :image_url, 
                      gmap_link = :gmap_link,
                      operating_hours = :operating_hours,
                      fees = :fees
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', (int)$data['id']);
        $stmt->bindValue(':name', htmlspecialchars(strip_tags($data['name'])));
        $stmt->bindValue(':address', htmlspecialchars(strip_tags($data['address'])));
        $stmt->bindValue(':description', htmlspecialchars(strip_tags($data['description'])));
        $stmt->bindValue(':image_url', htmlspecialchars(strip_tags($data['image_url'])));
        $stmt->bindValue(':gmap_link', htmlspecialchars(strip_tags($data['gmap_link'])));
        $stmt->bindValue(':operating_hours', htmlspecialchars(strip_tags($data['operating_hours'])));
        $stmt->bindValue(':fees', htmlspecialchars(strip_tags($data['fees'])));
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
                  OR `address` LIKE :term";
        
        $stmt = $this->conn->prepare($query);
        $term = '%' . $searchTerm . '%';
        $stmt->bindValue(':term', $term);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>