<?php
class User {
    private $conn;
    private $table = 'users';

    public function __construct($db) {
        $this->conn = $db;
    }

    
    public function register($data) {
        
        if ($this->findByUsername($data['username'])) {
            return 'Username already exists.'; 
        }

        $query = "INSERT INTO " . $this->table . "
                  SET full_name = :full_name,
                      username = :username,
                      password_hash = :password_hash";
        
        $stmt = $this->conn->prepare($query);

        
        $fullName = htmlspecialchars(strip_tags($data['full_name']));
        $username = htmlspecialchars(strip_tags($data['username']));
        
        $passwordHash = password_hash($data['password'], PASSWORD_BCRYPT);

        
        $stmt->bindParam(':full_name', $fullName);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password_hash', $passwordHash);

        if ($stmt->execute()) {
            return true; 
        }
        return 'An error occurred. Please try again.'; 
    }

    
    public function login($username, $password) {
        $user = $this->findByUsername($username);

        if ($user && password_verify($password, $user['password_hash'])) {
            return $user; 
        }
        return false; 
    }

    
    public function findByUsername($username) {
        $query = "SELECT * FROM " . $this->table . " WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll() {
        
        $query = "SELECT id, full_name, username FROM " . $this->table . " ORDER BY full_name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', (int)$id); 
        return $stmt->execute();
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