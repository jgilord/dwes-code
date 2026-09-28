<?php
	function CSVtoArray(String $CSVPath, String|null $index = null) {
		$archivoTextoPlano = file_get_contents($CSVPath);
		$lineasCSV = array_map("trim", explode("\n", $archivoTextoPlano));
		
		$cabeceraCSV = explode(",", array_shift($lineasCSV));

		$res = [];

		foreach ($lineasCSV as $linea) {
			$lineaSplited = explode(",", $linea);
			$objetoCombinado = array_combine($cabeceraCSV, $lineaSplited);

			if ($index !== null && isset($index, $cabeceraCSV)) {
				$res[$objetoCombinado[$index]] = $objetoCombinado;
			} else {
				$res[] = $objetoCombinado;
			}
		}


		return $res;
	}

	function getMarkupFromData(Array $data) {
		$res = "<ul>";

		foreach ($data as $key => $value) {
			$res .= "<li>".$value["matricula"]."</li>";
		}

		$res .= "</ul>";

		return $res;
	}

?>