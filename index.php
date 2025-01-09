<?php

require_once 'ShippingCalculatorController.php';
require_once 'ShippingCalculator.php';

$request = $_POST;

try {
    $controller = new ShippingCalculatorController();
    $response = $controller->calcularEnvio($request);
    echo json_encode($response);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}