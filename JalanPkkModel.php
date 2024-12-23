<?php
require_once 'config.php';

class JalanLingkunganModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getBatasProvinsi() {
        try {
            // Konversi geometri ke GeoJSON
            $query = "SELECT 
                        ogc_fid, 
                        ST_AsGeoJSON(wkb_geometry) AS geojson 
                      FROM jalan_pkk";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error fetching batas provinsi: " . $e->getMessage());
            return [];
        }
    }
}
?>