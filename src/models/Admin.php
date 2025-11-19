<?php
class Admin {
    private $conn;
    private $table = 'admins';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT id, full_name, username FROM " . $this->table . " WHERE id != 1 ORDER BY full_name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByUsername($username) {
        $query = "SELECT id FROM " . $this->table . " WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        if ($this->findByUsername($data['username'])) {
            return 'Username already exists.';
        }

        $query = "INSERT INTO " . $this->table . " (full_name, username, password_hash) 
                  VALUES (:full_name, :username, :password_hash)";
        
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
        return 'An error occurred.';
    }

    public function delete($id) {
        if ((int)$id === 1) {
            return false;
        }
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', (int)$id);
        return $stmt->execute();
    }
}
?>