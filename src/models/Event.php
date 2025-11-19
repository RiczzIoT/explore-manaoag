<?php
class Event {
    private $conn;
    private $table = 'events';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY `start_date` ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getUpcoming() {
         $query = "SELECT * FROM " . $this->table . " 
                  WHERE `start_date` >= NOW()
                  ORDER BY `start_date` ASC";
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
                  SET event_name = :event_name, 
                      description = :description, 
                      image_url = :image_url, 
                      start_date = :start_date,
                      end_date = :end_date,
                      location = :location";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':event_name', htmlspecialchars(strip_tags($data['event_name'])));
        $stmt->bindValue(':description', htmlspecialchars(strip_tags($data['description'])));
        $stmt->bindValue(':image_url', htmlspecialchars(strip_tags($data['image_url'])));
        $stmt->bindValue(':start_date', $data['start_date']);
        
        $endDate = !empty($data['end_date']) ? $data['end_date'] : null;
        $stmt->bindValue(':end_date', $endDate);
        
        $stmt->bindValue(':location', htmlspecialchars(strip_tags($data['location'])));
        return $stmt->execute();
    }

    public function update($data) {
        $query = "UPDATE " . $this->table . "
                  SET event_name = :event_name, 
                      description = :description, 
                      image_url = :image_url, 
                      start_date = :start_date,
                      end_date = :end_date,
                      location = :location
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', (int)$data['id']);
        $stmt->bindValue(':event_name', htmlspecialchars(strip_tags($data['event_name'])));
        $stmt->bindValue(':description', htmlspecialchars(strip_tags($data['description'])));
        $stmt->bindValue(':image_url', htmlspecialchars(strip_tags($data['image_url'])));
        $stmt->bindValue(':start_date', $data['start_date']);
        
        $endDate = !empty($data['end_date']) ? $data['end_date'] : null;
        $stmt->bindValue(':end_date', $endDate);
        
        $stmt->bindValue(':location', htmlspecialchars(strip_tags($data['location'])));
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
                  WHERE `event_name` LIKE :term 
                  OR `description` LIKE :term 
                  OR `location` LIKE :term";
        
        $stmt = $this->conn->prepare($query);
        $term = '%' . $searchTerm . '%';
        $stmt->bindValue(':term', $term);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>