<?php
require_once 'Conexion.php'; // Incluye la clase de conexión

class TarifasEnvio
{
    private $pdo;

    public function __construct() {
        $conexion = new Conexion();
        $this->pdo = $conexion->conectar();
    }

    public function obtenerTarifa($peso, $zona) {
        $sql = "SELECT :zona FROM paqestandar WHERE  peso >= :peso ORDER BY peso LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':zona' => $zona, ':peso' => $peso]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $resultado;
    }
}

// Instancia de la clase TarifasEnvio
$tarifasEnvio = new TarifasEnvio();

// Casos de prueba
$casosDePrueba = [
    ['peso' => 1, 'zona' => 'zona1', 'tarifaEsperada' => 2.72],
    ['peso' => 3, 'zona' => 'zona2', 'tarifaEsperada' => 3.21],
    ['peso' => 5, 'zona' => 'zona3_plus', 'tarifaEsperada' => 4.29],
    ['peso' => 10, 'zona' => 'zona5', 'tarifaEsperada' => 18.46],
    ['peso' => 15, 'zona' => 'zona4', 'tarifaEsperada' => 13.41],
];

foreach ($casosDePrueba as $caso) {
    $tarifa = $tarifasEnvio->obtenerTarifa($caso['peso'], $caso['zona']);
    echo "Peso: {$caso['peso']}, Zona: {$caso['zona']}, Tarifa Esperada: {$caso['tarifaEsperada']}, Tarifa Obtenida: $tarifa\n";
    if ($tarifa == $caso['tarifaEsperada']) {
        echo "Prueba pasada\n";
    } else {
        echo "Prueba fallida\n";
    }
}
?>
