<?php
class Database {
    private $host;
    private $dbname;
    private $user;
    private $pass;
    private $conn;

    public function __construct($config) {
        $this->host = $config['host'];
        $this->dbname = $config['dbname'];
        $this->user = $config['user'];
        $this->pass = $config['pass'];
    }

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->dbname,
                $this->user,
                $this->pass
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }
        return $this->conn;
    }
}
?>