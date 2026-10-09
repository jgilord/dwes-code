<?php
	// Dump funtion
	function dump($dump) {
		echo "<pre>".$dump."</pre>";
	}
  
  function consoleLog($log) {
    echo "<script>console.log('".$log."')</script>";
  }
  
	function CSVtoArray(String $CSVPath, String|null $index = null) {
		$archivoTextoPlano = file_get_contents($CSVPath);
		$lineasCSV = array_map("trim", explode("\n", $archivoTextoPlano));
		
		$cabeceraCSV = explode(",", array_shift($lineasCSV));

		$res = [];

		foreach ($lineasCSV as $linea) {
			$lineaSplited = explode(",", $linea);
			$objetoCombinado = array_combine($cabeceraCSV, $lineaSplited);

      $objetoCombinado["material"] = explode("&", $objetoCombinado["material"]);

			if ($index !== null && isset($index, $cabeceraCSV)) {
				$res[$objetoCombinado[$index]] = $objetoCombinado;
			} else {
				$res[] = $objetoCombinado;
			}
		}


		return $res;
	}

  function saveReservaCSV($lineaCSV) {
    $res = file_put_contents("datos/reservas.csv", $lineaCSV, FILE_APPEND);

    return $res;
  }
?>