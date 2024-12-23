<?php
class Database {
    private $host = 'localhost';
    private $db   = 'sig';
    private $user = 'postgres';
    private $pass = 'idza0511';
    private $port = 5432;
    
    public function connect() {
        try {
            $conn = new PDO("pgsql:host=$this->host;port=$this->port;dbname=$this->db", $this->user, $this->pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(PDOException $e) {
            die("Koneksi Error: " . $e->getMessage());
        }
    }
}
?>