<?php
class Content {
    private $conn;
    private $table = 'site_content';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllAsArray() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $contentArray = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $contentArray[$row['content_key']] = $row['content_value'];
        }
        return $contentArray;
    }

    public function update($key, $value) {
        $query = "UPDATE " . $this->table . " SET content_value = :value WHERE content_key = :key";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':value', $value);
        $stmt->bindParam(':key', $key);
        return $stmt->execute();
    }
}
?>