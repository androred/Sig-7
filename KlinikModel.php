<?php
require_once 'config.php';

class KlinikModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Ambil semua data klinik
    public function getAllKlinik() {
        try {
            $query = "SELECT 
                        namobj AS nama, 
                        y AS latitude, 
                        x AS longitude, 
                        wadmkk AS kabupaten 
                      FROM klinik";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error fetching klinik: " . $e->getMessage());
            return [];
        }
    }

    // Ambil klinik berdasarkan kabupaten
    public function getKlinikByKabupaten($kabupaten) {
        try {
            $query = "SELECT 
                        namobj AS nama, 
                        y AS latitude, 
                        x AS longitude, 
                        wadmkk AS kabupaten 
                      FROM klinik 
                      WHERE wadmkk = :kabupaten";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':kabupaten', $kabupaten);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error fetching klinik by kabupaten: " . $e->getMessage());
            return [];
        }
    }

    // Ambil daftar kabupaten unik
    public function getUniqueKabupaten() {
        try {
            $query = "SELECT DISTINCT wadmkk AS kabupaten FROM klinik ORDER BY wadmkk";
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