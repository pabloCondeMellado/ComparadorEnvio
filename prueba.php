<?php
require_once 'conexion.php';
require_once 'ZonaEnvio.php'; // Incluye el archivo de la clase
require_once 'TarifasEnvio.php'; // Incluye el archivo de la clase

// Instancia de la clase ZonaEnvio
$zonaEnvio = new ZonaEnvio();

// Instancia de la clase TarifasEnvio
$tarifasEnvio = new TarifasEnvio();

// Definir casos de prueba para determinar la zona
$casosPruebaZona = [
    ['origenCP' => 1000, 'destinoCP' => 1500, 'esperado' => 'Zona1'], // Misma provincia
    ['origenCP' => 7100, 'destinoCP' => 51001, 'esperado' => 'Zona4'], // Baleares o Ceuta/Melilla
    ['origenCP' => 1000, 'destinoCP' => 48000, 'esperado' => 'Zona2'], // Provincias limítrofes
    ['origenCP' => 28000, 'destinoCP' => 29000, 'esperado' => 'Zona3'], // Envíos intra peninsulares
    ['origenCP' => 1000, 'destinoCP' => 45000, 'esperado' => 'Zona3_plus'], // Larga distancia peninsular
    ['origenCP' => 35000, 'destinoCP' => 28000, 'esperado' => 'Zona5'], // Canarias y península
    ['origenCP' => 35000, 'destinoCP' => 38000, 'esperado' => 'Zona6'], // Interislas Canarias
    ['origenCP' => 3000, 'destinoCP' => 41510, 'esperado' => 'Zona7'], // Portugal peninsular desde península
    ['origenCP' => 7100, 'destinoCP' => 5000, 'esperado' => 'Zona8'], // Portugal peninsular desde Baleares
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
    ['peso' =>  1, 'zona' => 'zona1', 'tarifaEsperada' => 4.71],
    ['peso' => 3, 'zona' => 'zona2', 'tarifaEsperada' => 6.48],
    ['peso' => 5, 'zona' => 'zona3', 'tarifaEsperada' => 7.57],
    ['peso' => 5, 'zona' => 'zona3_plus', 'tarifaEsperada' => 7.57],
    ['peso' => 10, 'zona' => 'zona5', 'tarifaEsperada' => 10.28],
    ['peso' => 16, 'zona' => 'zona4', 'tarifaEsperada' => 13.41],
];

// Ejecutar pruebas para obtener la tarifa
foreach ($casosDePruebaTarifa as $caso) {
    $peso = $caso['peso'];
    $zona = $caso['zona'];

    if ($peso > 15) {
        // Calcular la tarifa base para 15 kg y agregar el extra
        $pesoExtra = $peso - 15;

        $tarifaExtraEstandar = $tarifasEnvio->pesoExtraEstandar($zona) * $pesoExtra;
        $tarifaExtraPremium = $tarifasEnvio->pesoExtraPremium($zona) * $pesoExtra;
        $tarifaExtraEstandarOficina = $tarifasEnvio->pesoExtraEstandarOficina($zona) * $pesoExtra;
        $tarifaExtraPremiumOficina = $tarifasEnvio->pesoExtraPremiumOficina($zona) * $pesoExtra;

        $tarifaBaseEstandar = $tarifasEnvio->obtenerTarifaPaqEstandar(15, $zona);
        $tarifaBasePremium = $tarifasEnvio->obtenerTarifaPaqPremium(15, $zona);

        $tarifaFinalEstandar = $tarifaBaseEstandar + $tarifaExtraEstandar;
        $tarifaFinalPremium = $tarifaBasePremium + $tarifaExtraPremium;

        echo "Peso: {$peso}, Zona: {$zona}\n";
        echo "Paquete Estándar: Tarifa Final: $tarifaFinalEstandar\n";
        echo "Paquete Premium: Tarifa Final: $tarifaFinalPremium\n";
    } else {
        // Peso dentro del rango estándar
        $tarifa = $tarifasEnvio->obtenerTarifaPaqPremium($peso, $zona);
        echo 'Paquete Premium: ';
        echo "Peso: {$peso}, Zona: {$zona}, Tarifa Obtenida: " . (is_array($tarifa) ? implode(", ", $tarifa) : $tarifa) . "\n";

        $tarifa = $tarifasEnvio->obtenerTarifaPaqEstandar($peso, $zona);
        echo 'Paquete Estándar: ';
        echo "Peso: {$peso}, Zona: {$zona}, Tarifa Obtenida: " . (is_array($tarifa) ? implode(", ", $tarifa) : $tarifa) . "\n";
    }
}
?>
