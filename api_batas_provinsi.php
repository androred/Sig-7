<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

require_once 'ProvinsiModel.php';

try {
    $provinsiModel = new ProvinsiModel();
    $data = $provinsiModel->getBatasProvinsi();

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