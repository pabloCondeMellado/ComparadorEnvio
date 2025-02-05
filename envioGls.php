<?php 
    public function determinarZonaEnvio($origenCP, $destinoCP,$destinoPais){
        // Definir las provincias y sus códigos postales
        $provincias = [
            'Álava' => range(1000, 1999),
            'Albacete' => range(2000, 2999),
            'Alicante' => range(3000, 3999),
            'Almería' => range(4000, 4999),
            'Asturias' => range(33000, 33999),
            'Ávila' => range(5000, 5999),
            'Badajoz' => range(6000, 6999),
            'Barcelona' => range(8000, 8999),
            'Burgos' => range(9000, 9999),
            'Cáceres' => range(10000, 10999),
            'Cádiz' => range(11000, 11999),
            'Cantabria' => range(39000, 39999),
            'Castellón' => range(12000, 12999),
            'Ciudad Real' => range(13000, 13999),
            'Córdoba' => range(14000, 14999),
            'Cuenca' => range(16000, 16999),
            'Girona' => range(17000, 17999),
            'Granada' => range(18000, 18999),
            'Guadalajara' => range(19000, 19999),
            'Huelva' => range(21000, 21999),
            'Huesca' => range(22000, 22999),
            'Jaén' => range(23000, 23999),
            'La Rioja' => range(26000, 26999),
            'León' => range(24000, 24999),
            'Lleida' => range(25000, 25999),
            'Lugo' => range(27000, 27999),
            'Madrid' => range(28000, 28999),
            'Málaga' => range(29000, 29999),
            'Murcia' => range(30000, 30999),
            'Navarra' => range(31000, 31999),
            'Ourense' => range(32000, 32999),
            'Palencia' => range(34000, 34999),
            'Pontevedra' => range(36000, 36999),
            'Salamanca' => range(37000, 37999),
            'Segovia' => range(40000, 40999),
            'Sevilla' => range(41000, 41999),
            'Soria' => range(42000, 42999),
            'Tarragona' => range(43000, 43999),
            'Teruel' => range(44000, 44999),
            'Toledo' => range(45000, 45999),
            'Valencia' => range(46000, 46999),
            'Valladolid' => range(47000, 47999),
            'Vizcaya' => range(48000, 48999),
            'Zamora' => range(49000, 49999),
            'Zaragoza' => range(50000, 50999),
            'Ceuta' => range(51000, 51099),
            'Melilla' => range(52000, 52099)
        ];
    }
    
       // Definir las Islas Baleares y sus códigos postales
       $baleares = range(07001,07699);
       $balearesMenor= range(07700,07899);

       // Definir las Islas Canarias y sus códigos postales
       $canarias = range(35000,35499);
       $canariaMenor= range(35000,35669);
        //Comprobamos que el envio sea a baleares
       if($this->esBaleares($destinoCP)){
            return 'baleares';
        } 
        if($this->esBalearesMenor($destinoCP)){
            return 'baleares_menor';
        }
        //Comprobamos que el envío sea a canaria
        if($this->esCanarias($destinoCP)){
            return 'canarias';
        }
        if($this->esCanariasMenor($destinoCP)){
            return 'canarias_menor';
        }
       //Comprobamos que el envio sea entre provincia
       foreach ($provincias as $provincia => $rango) {
        if (in_array($origenCP, $rango) && in_array($destinoCP, $rango)) {
            return 'provincia'; 
        } else{
            return 'peninsula';
        }
    }   

    private function esBaleares($destinoCP){
        return ($destinoCP >= 07000 && $destinoCP<=07699);
    }
    
    private function esBalearesMenor($destinoCP){
        return ($destinoCP>=07700 && $destinoCP<=07899);
    }

    private function esCanarias($destinoCP){
        return ($destinoCP >= 35000 && $destinoCP<=35499);
    }
        
    private function esCanariasMenor($destinoCP){
        return ($destinoCP>=35000 && $destinoCP<=35669);
    }
?>