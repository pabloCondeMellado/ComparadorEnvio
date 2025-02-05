<?php
require_once 'TarifasEnvio.php'; // Incluye la clase TarifasEnvio
require_once 'ZonaEnvio.php'; // Incluye la clase ZonaEnvio
$tarifa = new TarifasEnvio();
$tarifa1 = new TarifasEnvio(); // Crea un objeto de la clase TarifasEnvio
$determinarZona = new ZonaEnvio();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['origenCP']) && isset($_POST['destinoCP']) && isset($_POST['peso'])) {

        $origenCP = htmlspecialchars($_POST['origenCP']);
        $destinoCP = htmlspecialchars($_POST['destinoCP']);
        $origenPais = htmlspecialchars($_POST['origenPais']);
        $destinoPais = htmlspecialchars($_POST['destinoPais']);
        // Datos enviados por el cliente
        $peso_real = htmlspecialchars($_POST['peso']); // Peso real (en kilogramos)
        $largo = htmlspecialchars($_POST['largo']);    // Largo (en centímetros)
        $ancho = htmlspecialchars($_POST['ancho']);    // Ancho (en centímetros)
        $alto = htmlspecialchars($_POST['alto']);      // Alto (en centímetros)

        // Calcular el peso volumétrico
        $peso_volumetrico = ($largo * $ancho * $alto) / 6000;
        $peso_aplicable = 0;
        // Comparar ambos pesos
        if ($peso_volumetrico > $peso_real) {
            $peso_aplicable = $peso_volumetrico;
        } else {
            $peso_aplicable = $peso_real;
        }

        $pesoSeur=$peso_aplicable;
        // Validar que los campos no estén vacíos
        if (empty($origenCP) || empty($destinoCP) || empty($peso_real)) {
            echo '<p style="color: red;">Error: Todos los campos son requeridos.</p>';
            exit;
        }

        // Validar que los campos sean numéricos
        if (!is_numeric($origenCP) || !is_numeric($destinoCP) || !is_numeric($peso_real)) {
            echo '<p style="color: red;">Error: Los campos deben ser numéricos.</p>';
            exit;
        }

        // Validar que el peso sea mayor a 0
        if ($peso_real <= 0) {
            echo '<p style="color: red;">Error: El peso debe ser mayor a 0.</p>';
            exit;
        }

        // Obtener la zona de origen y destino
        $zonaEnvio = $determinarZona->determinarZonaEnvio($origenCP, $destinoCP, $destinoPais);

        $zonaEnvioSeur = $determinarZona->determinarZonaEnvioSeur( $destinoCP);
        // Obtener la tarifa correspondiente para Paquete Estándar
        $tarifaEstandar = $tarifa->obtenerTarifaPaqEstandar($peso_aplicable, $zonaEnvio);

        // Obtener la tarifa correspondiente para Paquete Premium
        $tarifaPremium = $tarifa->obtenerTarifaPaqPremium($peso_aplicable, $zonaEnvio);
        // Obtener la tarifa correspondiente para Paquete Estándar
        $tarifaEstandarOficina = $tarifa->obtenerTarifaPaqEstandarOficina($peso_aplicable, $zonaEnvio);

        // Obtener la tarifa correspondiente para Paquete Premium
        $tarifaPremiumOficina = $tarifa->obtenerTarifaPaqPremiumOficina($peso_aplicable, $zonaEnvio);
        // Obtener la tarifa correspondiente para Paquete Seur
        $tarifaSeur = $tarifa->obtenerTarifaSeur($pesoSeur, $zonaEnvioSeur);
        // Obtener la tarifa correspondiente para Paquete Ligero (solo si el peso está dentro del rango)
        $tarifaLigero = null;
        if ($peso_aplicable <= 2 && $peso_aplicable >= 0.05) {
            $tarifaLigero = $tarifa->obtenerTarifaPaqLigero($peso_aplicable, $zonaEnvio);
        }
        if($pesoSeur>20){
            $tarifaExtraSeur = $tarifa1->pesoExtraSeur($zonaEnvioSeur) * (ceil($pesoSeur) - 20);
            $tarifaSeur = $tarifa->obtenerTarifaSeur(20, $zonaEnvioSeur)+$tarifaExtraSeur;
        }

        if ($peso_aplicable > 15) {


            $tarifaExtraEstandar = $tarifa1->pesoExtraEstandar($zonaEnvio) * (ceil($peso_aplicable) - 15);
            $tarifaExtraPremium = $tarifa1->pesoExtraPremium($zonaEnvio) * (ceil($peso_aplicable) - 15);


            if ($destinoPais == "España") {
                $tarifaExtraEstandarOficina = $tarifa1->pesoExtraEstandarOficina($zonaEnvio) * (ceil($peso_aplicable) - 15);
                $tarifaExtraPremiumOficina = $tarifa1->pesoExtraPremiumOficina($zonaEnvio) * (ceil($peso_aplicable) - 15);
            }

            $tarifaEstandar = $tarifa->obtenerTarifaPaqEstandar(15, $zonaEnvio) + $tarifaExtraEstandar;
            $tarifaPremium = $tarifa->obtenerTarifaPaqPremium(15, $zonaEnvio) + $tarifaExtraPremium;


            if ($destinoPais == "España") {
                $tarifaEstandarOficina = $tarifa->obtenerTarifaPaqEstandarOficina(15, $zonaEnvio) + $tarifaExtraEstandarOficina;
                $tarifaPremiumOficina = $tarifa->obtenerTarifaPaqPremiumOficina(15, $zonaEnvio) + $tarifaExtraPremiumOficina;
            }
        }
        // Especificar el tipo de contenido como HTML
        header('Content-Type: text/html; charset=UTF-8');

        ?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="styles.css">
            <title>Resultados de Tarifas de Envío</title>
        </head>
        <style>
            /* Reset de márgenes y padding */
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            /* Estilo básico del cuerpo */
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f9;
                padding: 20px;
                color: #333;
                max-width: 50%;
                margin: 0 auto;
            }

            /* Título principal */
            h2 {
                font-size: 28px;
                color: #333;
                text-align: center;
                margin-bottom: 20px;
            }

            /* Párrafos */
            p {
                font-size: 18px;
                color: #555;
                margin-bottom: 20px;
            }

            /* Estilo para los contenedores de tarifas */
            div {
                margin-bottom: 20px;
            }

            /* Estilo para las tarifas */
            .tarifa-container {
                display: flex;
                justify-content: space-between;
                padding: 10px 20px;
                border: 1px solid #ddd;
                border-radius: 6px;
                background-color: #ffffff;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            /* Estilo para el nombre de la tarifa */
            .tarifa-container h3 {
                font-size: 20px;
                color: #333;
                margin-right: 10px;
                flex-grow: 1;
            }

            /* Estilo para el precio de la tarifa */
            .tarifa-container p {
                font-size: 18px;
                font-weight: bold;
                color: #4CAF50;
            }

            /* Estilo para las tarifas con error */
            .error {
                color: red;
                font-weight: bold;
            }

            /* Estilo para los mensajes de error */
            .error-message {
                padding: 10px;
                background-color: #fdd;
                border-radius: 6px;
                color: #a33;
            }

            /* Estilos responsivos */
            @media (max-width: 600px) {
                body {
                    padding: 15px;
                }

                h2 {
                    font-size: 24px;
                }

                .tarifa-container {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .tarifa-container h3,
                .tarifa-container p {
                    margin-bottom: 8px;
                }

                .tarifa-container p {
                    font-size: 16px;
                }
            }
        </style>

        <body>

            <h2>Resultados de Tarifas de Envío</h2>
            <p><strong>Zona de Envío:</strong> <?php echo $zonaEnvio ?> </p>
            <p><strong>Peso Volumétrico:</strong> <?php echo $peso_aplicable ?> </p>
            <?php
            // Mostrar tarifa estándar
            if ($tarifaEstandar) {
                echo '<div class="tarifa-container">';
                echo '<h3>Tarifa Paquete Estándar</h3>';
                echo '<p>' . $tarifaEstandar . ' EUR</p>';
                echo '</div>';
            } else {
                echo '<div class="tarifa-container">';
                echo '<h3>Tarifa Paquete Estándar</h3>';
                echo '<p class="error-message">Error: No se encontró una tarifa para los datos proporcionados.</p>';
                echo '</div>';
            }

            // Mostrar tarifa premium
            if ($tarifaPremium) {
                echo '<div class="tarifa-container">';
                echo '<h3>Tarifa Paquete Premium</h3>';
                echo '<p>' . $tarifaPremium . ' EUR</p>';
                echo '</div>';
            } else {
                echo '';
            }
            // Mostrar tarifa seur
            if ($tarifaSeur) {
                echo '<div class="tarifa-container">';
                echo '<h3>Tarifa Seur</h3>';
                echo '<p>' . $tarifaSeur. ' EUR</p>';
                echo '</div>';
            } else {
                echo '';
            }


            // Mostrar tarifa ligera (si corresponde)
            if ($peso_aplicable <= 2) {
                echo '<div class="tarifa-container">';
                echo '<h3>Tarifa Paquete Ligero</h3>';
                echo '<p>' . $tarifaLigero . ' EUR</p>';
                echo '</div>';
            } else {
                echo '';
            }
            // Mostrar tarifa estándar
            if ($destinoPais == "España") {
                echo '<div class="tarifa-container">';
                echo '<h3>Recoger paquete en oficina Estandar</h3>';
                echo '<p>' . $tarifaEstandarOficina . ' EUR</p>';
                echo '</div>';
            }

            // Mostrar tarifa premium
            if ($destinoPais == "España") { {
                    echo '<div class="tarifa-container">';
                    echo '<h3>Recoger paquete en oficina Premium</h3>';
                    echo '<p>' . $tarifaPremiumOficina . ' EUR</p>';
                    echo '</div>';
                }
            }
    }
}
?>
</body>

</html>