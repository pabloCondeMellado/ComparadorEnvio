<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

require_once 'ZonaEnvio.php';
require_once 'ShippingCalculator.php';

$request = $_POST;

try {
    $controller = new ShippingCalculatorController();
    $response = $controller->calcularEnvio($request);
    echo json_encode($response);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}