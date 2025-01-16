<?php
require_once 'TarifasEnvio.php'; // Incluye la clase TarifasEnvio
require_once 'ZonaEnvio.php'; // Incluye la clase ZonaEnvio
$tarifa = new TarifasEnvio(); // Crea un objeto de la clase TarifasEnvio
$determinarZona=new ZonaEnvio();
if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['origenCP']) && isset($_POST['destinoCP']) && isset($_POST['peso'])){

        $origenCP = $_POST['origenCP'];
        $destinoCP = $_POST['destinoCP'];
        $peso = $_POST['peso'];
        
        // Validar que los campos no estén vacíos
        if(empty($origenCP) || empty($destinoCP) || empty($peso)){
            echo json_encode(['error' => 'Todos los campos son requeridos']);
            exit;
        }
        
        // Validar que los campos sean numéricos
        if(!is_numeric($origenCP) || !is_numeric($destinoCP) || !is_numeric($peso)){
            echo json_encode(['error' => 'Los campos deben ser numéricos']);
            exit;
        }
        
        // Validar que el peso sea mayor a 0
        if($peso <= 0){
            echo json_encode(['error' => 'El peso debe ser mayor a 0']);
            exit;
        }
        
     
        
        // Validar que los códigos postales sean válidos
        if(strlen($origenCP) != 5 || strlen($destinoCP) != 5){
            echo json_encode(['error' => 'Los códigos postales deben tener 5 dígitos']);
            exit;
        }
        
        // Validar que los códigos postales sean numéricos
        if(!is_numeric($origenCP) || !is_numeric($destinoCP)){
            echo json_encode(['error' => 'Los códigos postales deben ser numéricos']);
            exit;
        }
        
        // Validar que los códigos postales sean válidos
        if($origenCP < 10000 || $origenCP > 99999 || $destinoCP < 10000 || $destinoCP > 99999){
            echo json_encode(['error' => 'Los códigos postales deben estar entre 10000 y 99999']);
            exit;
        }

        // Obtener la zona de origen y destino
       $determinarZona->determinarZonaEnvio($origenCP,$destinoCP);
        // Obtener la tarifa correspondiente
        $tarifaEstandar = $tarifa->obtenerTarifaPaqEstandar($_POST['peso'],  $determinarZona->determinarZonaEnvio($origenCP,$destinoCP));
        
        if($tarifaEstandar){
            echo json_encode(['Paquete Estandar' => $tarifaEstandar]);
        } else {
            echo json_encode(['error' => 'No se encontró una tarifa para los datos proporcionados']);
        }
        echo json_encode([$determinarZona->determinarZonaEnvio($origenCP,$destinoCP)]);

        $tarifaPremium = $tarifa->obtenerTarifaPaqPremium($_POST['peso'],  $determinarZona->determinarZonaEnvio($origenCP,$destinoCP));
        if($tarifaPremium){
            echo json_encode(['Paquete Premium' => $tarifaPremium]);
        } else {
             echo json_encode(['error'=> 'No se encontró una tarifa para los datos proporcionados']);
         }
         if($peso<=2 && $peso>=0.05){
         $tarifaLigero = $tarifa->obtenerTarifaPaqLigero($_POST['peso'],  $determinarZona->determinarZonaEnvio($origenCP,$destinoCP));
         if($tarifaLigero){
            echo json_encode(['Paquete Ligero'=> $tarifaLigero]);
            } else {
                echo json_encode(['error'=> 'No se encontró una tarifa para los datos proporcionados']);
                }
            }
}
}