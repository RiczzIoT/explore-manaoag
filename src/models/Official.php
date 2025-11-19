<?php
class Official {
    private $conn;
    private $table = 'officials';

    public function __construct($db) {
        $this->conn = $db;
    }

    
    public function getSingleOfficial($position) {
        $query = "SELECT * FROM " . $this->table . " WHERE position = :position LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':position', $position);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    public function getOfficialsByPosition($position) {
        $query = "SELECT * FROM " . $this->table . " WHERE position = :position ORDER BY `order` ASC, `name` ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':position', $position);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    

    
    public function getAllOfficials() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY `position` DESC, `order` ASC, `name` ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function getOfficialById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    public function create($data) {
        $query = "INSERT INTO " . $this->table . " 
                  SET name = :name, 
                      position = :position, 
                      message = :message, 
                      facebook_url = :facebook_url, 
                      website_url = :website_url, 
                      image_url = :image_url, 
                      `order` = :order";
        
        $stmt = $this->conn->prepare($query);

        
        $data['name'] = htmlspecialchars(strip_tags($data['name']));
        $data['position'] = htmlspecialchars(strip_tags($data['position']));
        $data['message'] = htmlspecialchars(strip_tags($data['message']));
        $data['facebook_url'] = htmlspecialchars(strip_tags($data['facebook_url']));
        $data['website_url'] = htmlspecialchars(strip_tags($data['website_url']));
        $data['image_url'] = htmlspecialchars(strip_tags($data['image_url']));
        $data['order'] = (int)$data['order'];

        
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':position', $data['position']);
        $stmt->bindParam(':message', $data['message']);
        $stmt->bindParam(':facebook_url', $data['facebook_url']);
        $stmt->bindParam(':website_url', $data['website_url']);
        $stmt->bindParam(':image_url', $data['image_url']);
        $stmt->bindParam(':order', $data['order']);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    
    public function update($data) {
        $query = "UPDATE " . $this->table . "
                  SET name = :name, 
                      position = :position, 
                      message = :message, 
                      facebook_url = :facebook_url, 
                      website_url = :website_url, 
                      image_url = :image_url, 
                      `order` = :order
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);

        
        $data['id'] = (int)$data['id'];
        $data['name'] = htmlspecialchars(strip_tags($data['name']));
        $data['position'] = htmlspecialchars(strip_tags($data['position']));
        $data['message'] = htmlspecialchars(strip_tags($data['message']));
        $data['facebook_url'] = htmlspecialchars(strip_tags($data['facebook_url']));
        $data['website_url'] = htmlspecialchars(strip_tags($data['website_url']));
        $data['image_url'] = htmlspecialchars(strip_tags($data['image_url']));
        $data['order'] = (int)$data['order'];

        
        $stmt->bindParam(':id', $data['id']);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':position', $data['position']);
        $stmt->bindParam(':message', $data['message']);
        $stmt->bindParam(':facebook_url', $data['facebook_url']);
        $stmt->bindParam(':website_url', $data['website_url']);
        $stmt->bindParam(':image_url', $data['image_url']);
        $stmt->bindParam(':order', $data['order']);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', (int)$id); 

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    
    public function search($searchTerm) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE `name` LIKE :term 
                  OR `position` LIKE :term";
        
        $stmt = $this->conn->prepare($query);
        $term = '%' . $searchTerm . '%'; 
        $stmt->bindParam(':term', $term);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>