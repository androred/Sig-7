<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

require_once 'KlinikModel.php';

// Tangani request
$action = $_GET['action'] ?? 'all';
$klinikModel = new KlinikModel();

try {
    switch($action) {
        case 'all':
            $data = $klinikModel->getAllKlinik();
            break;
        
        case 'kabupaten':
            $kabupaten = $_GET['kabupaten'] ?? '';
            $data = $klinikModel->getKlinikByKabupaten($kabupaten);
            break;
        
        case 'kabupaten_list':
            $data = $klinikModel->getUniqueKabupaten();
            break;
        
        default:
            http_response_code(400);
            $data = ['error' => 'Invalid action'];
    }

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