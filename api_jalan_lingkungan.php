<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

require_once 'JalanLingkunganModel.php';

try {
    $jalanlingkunganModel = new JalanLingkunganModel();
    $data = $jalanlingkunganModel->getBatasProvinsi();

    echo json_encode([
        'status' => 'success',
        'data' => $data
    ]);
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>