<?php
require_once 'Conexion.php'; // Incluye la clase de conexión

class TarifasEnvio
{
    private $pdo;

    public function __construct() {
        $conexion = new Conexion();
        $this->pdo = $conexion->conectar();
    }

    public function obtenerTarifaPaqEstandar($peso, $zona) {

      
        
        // Construir la consulta SQL con el nombre de la zona dinámicamente
        $sql = "SELECT $zona FROM paqestandar WHERE peso >= :peso ORDER BY peso LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':peso' => $peso]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($resultado) {
            return $resultado[$zona]; // Devolver el valor correspondiente a la zona
        } else {
            return null; // Si no se encuentra ningún resultado
        }
    }
    
    
    public function obtenerTarifaPaqPremium($peso, $zona) {

        $zona = strtolower(trim($zona));
        // Asegúrate de que el valor de $zona es válido y corresponde con una columna
        $zonasValidas = ['zona1', 'zona2', 'zona3_plus', 'zona4', 'zona5','zona6'];
        
        // Verificar que la zona es válida antes de construir la consulta
        if (!in_array($zona, $zonasValidas)) {
            throw new Exception("Zona inválida : $zona");
        }
        
        // Construir la consulta SQL con el nombre de la zona dinámicamente
        $sql = "SELECT $zona FROM paqpremium WHERE peso >= :peso ORDER BY peso LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':peso' => $peso]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($resultado) {
            return $resultado[$zona]; // Devolver el valor correspondiente a la zona
        } else {
            return null; // Si no se encuentra ningún resultado
        }
    }
    
    public function obtenerTarifaPaqLigero($peso, $zona) {

        $zona = strtolower(trim($zona));
        // Asegúrate de que el valor de $zona es válido y corresponde con una columna
        $zonasValidas = ['zona1', 'zona2', 'zona3_plus', 'zona4', 'zona5','zona6'];
        
        // Verificar que la zona es válida antes de construir la consulta
        if (!in_array($zona, $zonasValidas)) {
            throw new Exception("Zona inválida : $zona");
        }
        
        // Construir la consulta SQL con el nombre de la zona dinámicamente
        $sql = "SELECT $zona FROM paqligero WHERE peso >= :peso ORDER BY peso LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':peso' => $peso]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($resultado) {
            return $resultado[$zona]; // Devolver el valor correspondiente a la zona
        } else {
            return null; // Si no se encuentra ningún resultado
        }
    }
    
    public function obtenerTarifaDevolucion($peso, $zona) {

        $zona = strtolower(trim($zona));
        // Asegúrate de que el valor de $zona es válido y corresponde con una columna
        $zonasValidas = ['zona1', 'zona2', 'zona3_plus', 'zona4', 'zona5','zona6'];
        
        // Verificar que la zona es válida antes de construir la consulta
        if (!in_array($zona, $zonasValidas)) {
            throw new Exception("Zona inválida : $zona");
        }
        
        // Construir la consulta SQL con el nombre de la zona dinámicamente
        $sql = "SELECT $zona FROM devolucion_paqueteria WHERE peso >= :peso ORDER BY peso LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':peso' => $peso]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($resultado) {
            return $resultado[$zona]; // Devolver el valor correspondiente a la zona
        } else {
            return null; // Si no se encuentra ningún resultado
        }
    }
    public function pesoExtraEstandar( $zona) {
        $zona = strtolower(trim($zona));
        $zonasValidas = ['zona1', 'zona2', 'zona3_plus', 'zona4', 'zona5','zona6','zona7'];
         // Verificar que la zona es válida antes de construir la consulta
         if (!in_array($zona, $zonasValidas)) {
            throw new Exception("Zona inválida : $zona");
        }
        
        // Construir la consulta SQL con el nombre de la zona dinámicamente
        $sql = "SELECT $zona FROM paqestandar WHERE id=8 ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($resultado) {
            return $resultado[$zona]; // Devolver el valor correspondiente a la zona
        } else {
            return null; // Si no se encuentra ningún resultado
        }

    }
    
    public function pesoExtraPremium( $zona) {
        $zona = strtolower(trim($zona));
        $zonasValidas = ['zona1', 'zona2', 'zona3_plus', 'zona4', 'zona5','zona6','zona7'];
         // Verificar que la zona es válida antes de construir la consulta
         if (!in_array($zona, $zonasValidas)) {
            throw new Exception("Zona inválida : $zona");
        }
        
        // Construir la consulta SQL con el nombre de la zona dinámicamente
        $sql = "SELECT $zona FROM paqpremium WHERE id=8 ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($resultado) {
            return $resultado[$zona]; // Devolver el valor correspondiente a la zona
        } else {
            return null; // Si no se encuentra ningún resultado
        }
        
    }
    public function pesoExtraEstandarOficina( $zona) {
        $zona = strtolower(trim($zona));
        $zonasValidas = ['zona1', 'zona2', 'zona3_plus', 'zona4', 'zona5','zona6','zona7'];
         // Verificar que la zona es válida antes de construir la consulta
         if (!in_array($zona, $zonasValidas)) {
            throw new Exception("Zona inválida : $zona");
        }
        
        // Construir la consulta SQL con el nombre de la zona dinámicamente
        $sql = "SELECT $zona FROM paqestandar_oficina WHERE id=8 ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($resultado) {
            return $resultado[$zona]; // Devolver el valor correspondiente a la zona
        } else {
            return null; // Si no se encuentra ningún resultado
        }
        
    }
    public function pesoExtraPremiumOficina( $zona) {
        $zona = strtolower(trim($zona));
        $zonasValidas = ['zona1', 'zona2', 'zona3_plus', 'zona4', 'zona5','zona6','zona7'];
         // Verificar que la zona es válida antes de construir la consulta
         if (!in_array($zona, $zonasValidas)) {
            throw new Exception("Zona inválida : $zona");
        }
        
        // Construir la consulta SQL con el nombre de la zona dinámicamente
        $sql = "SELECT $zona FROM paqpremium_oficina WHERE id=8 ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($resultado) {
            return $resultado[$zona]; // Devolver el valor correspondiente a la zona
        } else {
            return null; // Si no se encuentra ningún resultado
        }
        
    }
    
    public function obtenerTarifaPaqPremiumOficina($peso, $zona) {

        $zona = strtolower(trim($zona));
        // Asegúrate de que el valor de $zona es válido y corresponde con una columna
        $zonasValidas = ['zona1', 'zona2', 'zona3_plus', 'zona4', 'zona5','zona6'];
        
        // Verificar que la zona es válida antes de construir la consulta
        if (!in_array($zona, $zonasValidas)) {
            throw new Exception("Zona inválida : $zona");
        }
        
        // Construir la consulta SQL con el nombre de la zona dinámicamente
        $sql = "SELECT $zona FROM paqpremium_oficina WHERE peso >= :peso ORDER BY peso LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':peso' => $peso]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($resultado) {
            return $resultado[$zona]; // Devolver el valor correspondiente a la zona
        } else {
            return null; // Si no se encuentra ningún resultado
        }
    }
    
    public function obtenerTarifaPaqEstandarOficina($peso, $zona) {

        $zona = strtolower(trim($zona));
        // Asegúrate de que el valor de $zona es válido y corresponde con una columna
        $zonasValidas = ['zona1', 'zona2', 'zona3_plus', 'zona4', 'zona5','zona6'];
        
        // Verificar que la zona es válida antes de construir la consulta
        if (!in_array($zona, $zonasValidas)) {
            throw new Exception("Zona inválida : $zona");
        }
        
        // Construir la consulta SQL con el nombre de la zona dinámicamente
        $sql = "SELECT $zona FROM paqestandar_oficina WHERE peso >= :peso ORDER BY peso LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':peso' => $peso]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($resultado) {
            return $resultado[$zona]; // Devolver el valor correspondiente a la zona
        } else {
            return null; // Si no se encuentra ningún resultado
        }
    }
    
}

?>
