<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

require_once 'PuskesmasModel.php';

$action = $_GET['action'] ?? 'all';
$puskesmasModel = new PuskesmasModel();

try {
    switch($action) {
        case 'all':
            $data = $puskesmasModel->getAllPuskesmas();
            break;
        
        case 'kabupaten':
            $kabupaten = $_GET['kabupaten'] ?? '';
            $data = $puskesmasModel->getPuskesmasByKabupaten($kabupaten);
            break;
        
        case 'kabupaten_list':
            $data = $puskesmasModel->getUniqueKabupaten();
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