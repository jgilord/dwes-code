<?php
	function CSVtoArray($CSVPath, $index) {
		$archivoTextoPlano = file_get_contents($CSVPath);
		$lineasCSV = array_map("trim", explode("\n", $archivoTextoPlano));
		
		$cabeceraCSV = explode(",", array_shift($lineasCSV));

		$res = [];
		$indexNumber = 0;

		// Código para sacar el índice numérico a partir de índice texto
		foreach ($cabeceraCSV as $iCabecera => $cabecera) {
			if ($cabecera === $index) {
				$indexNumber = $iCabecera;
			}
		}

		foreach ($lineasCSV as $linea) {
			$lineaSplited = explode(",", $linea);
			$res[$lineaSplited[$indexNumber]] = array_combine($cabeceraCSV, $lineaSplited);
		}

		return $res;
	}

?>