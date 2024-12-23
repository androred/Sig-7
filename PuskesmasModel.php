<?php
require_once 'config.php';

class PuskesmasModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getAllPuskesmas() {
        try {
            $query = "SELECT 
                        namobj AS nama, 
                        y AS latitude, 
                        x AS longitude, 
                        wadmkk AS kabupaten,
                        kmppkm AS jenis 
                      FROM puskesmas";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error fetching puskesmas: " . $e->getMessage());
            return [];
        }
    }

    public function getPuskesmasByKabupaten($kabupaten) {
        try {
            $query = "SELECT 
                        namobj AS nama, 
                        y AS latitude, 
                        x AS longitude, 
                        wadmkk AS kabupaten 
                      FROM puskesmas 
                      WHERE wadmkk = :kabupaten";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':kabupaten', $kabupaten);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error fetching puskesmas by kabupaten: " . $e->getMessage());
            return [];
        }
    }

    public function getUniqueKabupaten() {
        try {
            $query = "SELECT DISTINCT wadmkk AS kabupaten FROM puskesmas ORDER BY wadmkk";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch(PDOException $e) {
            error_log("Error fetching unique kabupaten: " . $e->getMessage());
            return [];
        }
    }
}
?>