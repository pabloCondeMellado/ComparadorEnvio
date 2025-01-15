<?php
require_once 'conexion.php';
require_once 'ZonaEnvio.php'; // Incluye el archivo de la clase

class TarifasEnvio
{
    private $pdo;

    public function __construct() {
        $conexion = new Conexion();
        $this->pdo = $conexion->conectar();
    }

   function obtenerTarifa($peso, $resultadoZona) {
        
        $sql = "SELECT :zona FROM paqestandar WHERE peso >= :peso  ORDER BY peso LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':peso' => $peso, ':zona' => $resultadoZona]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $resultado ;
    }
}

// Instancia de la clase ZonaEnvio
$zonaEnvio = new ZonaEnvio();

// Instancia de la clase TarifasEnvio
$tarifasEnvio = new TarifasEnvio();

// Definir casos de prueba para determinar la zona
$casosPruebaZona = [
    ['origenCP' => 1000, 'destinoCP' => 1500, 'esperado' => 'Zona 1'], // Mismo provincia
    ['origenCP' => 35000, 'destinoCP' => 35500, 'esperado' => 'Canarias'], // Misma isla
    ['origenCP' => 7100, 'destinoCP' => 51001, 'esperado' => 'Zona 4'], // Baleares o Ceuta/Melilla
    ['origenCP' => 1000, 'destinoCP' => 48000, 'esperado' => 'Zona 2'], // Provincias limítrofes
    ['origenCP' => 28000, 'destinoCP' => 29000, 'esperado' => 'Zona 3'], // Envíos intra peninsulares
    ['origenCP' => 1000, 'destinoCP' => 45000, 'esperado' => 'Zona 3+'], // Larga distancia peninsular
    ['origenCP' => 35000, 'destinoCP' => 28000, 'esperado' => 'Zona 5'], // Canarias y península
    ['origenCP' => 35000, 'destinoCP' => 38000, 'esperado' => 'Zona 6'], // Interislas Canarias
    ['origenCP' => 28000, 'destinoCP' => 5000, 'esperado' => 'Zona 7'], // Portugal peninsular desde península
    ['origenCP' => 7100, 'destinoCP' => 5000, 'esperado' => 'Zona 8'], // Portugal peninsular desde Baleares
];

// Ejecutar pruebas para determinar la zona
foreach ($casosPruebaZona as $caso) {
    $resultadoZona = $zonaEnvio->determinarZonaEnvio($caso['origenCP'], $caso['destinoCP']);
    echo "Origen: {$caso['origenCP']}, Destino: {$caso['destinoCP']}\n";
    echo "Esperado: {$caso['esperado']}, Obtenido: $resultadoZona\n";
    echo ($resultadoZona === $caso['esperado']) ? "✔ Prueba pasada\n\n" : "✘ Prueba fallida\n\n";
}

// Casos de prueba para obtener la tarifa
$casosDePruebaTarifa = [
    ['peso' => 1, 'zona' => 'zona1', 'tarifaEsperada' => 2.72],
    ['peso' => 3, 'zona' => 'zona2', 'tarifaEsperada' => 3.21],
    ['peso' => 5, 'zona' => 'zona3_plus', 'tarifaEsperada' => 4.29],
    ['peso' => 10, 'zona' => 'zona5', 'tarifaEsperada' => 18.46],
    ['peso' => 15, 'zona' => 'zona4', 'tarifaEsperada' => 13.41],
];

// Ejecutar pruebas para obtener la tarifa
foreach ($casosDePruebaTarifa as $caso) {
    $tarifa = $tarifasEnvio->obtenerTarifa($caso['peso'], $caso['zona']);
    echo "Peso: {$caso['peso']}, Zona: {$caso['zona']}, Tarifa Esperada: {$caso['tarifaEsperada']}, Tarifa Obtenida: " . (is_array($tarifa) ? implode(", ", $tarifa) : $tarifa) . "\n";    if ($tarifa == $caso['tarifaEsperada']) {
        echo "✔ Prueba pasada\n";
    } else {
        echo "✘ Prueba fallida\n";
    }
}
?>
