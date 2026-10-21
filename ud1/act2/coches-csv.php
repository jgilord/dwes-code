<?php
	// Dump funtion
	function dump($dump) {
		echo "<pre>".$dump."</pre>";
	}

  $fp = fopen("src/coches.csv", "r");
	$coches = [];

	$cabeceraCsv = fgetcsv($fp);

	while ($data = fgetcsv($fp)) {
		$coches[$data[3]] = array_combine($cabeceraCsv, $data);
	}

	fclose($fp);
	
	// echo "<h1>=== TODOS LOS COCHES ===</h1>";
	// dump(print_r($coches, true));

	function obtenerCochesPorColor($coches, $color) {
		$res = [];

		foreach($coches as $coche) {
			if ($coche["color"] === $color) {
				$res[$coche["matricula"]] = $coche;
			}
		}

		return $res;
	}
	
	// echo "<h1>=== TODOS LOS COCHES BLANCOS ===</h1>";
	// dump(print_r(obtenerCochesPorColor($coches,"Blanco"), true));

	// =========================== FILE GET CONTENTS ===========================
	$archivoTextoPlano = file_get_contents("src/coches.csv");
	dump($archivoTextoPlano);
	

	echo "<h1>=== TODOS LOS COCHES ===</h1>";
	$lineasCSV = explode("\n", $archivoTextoPlano);
	$lineasCSV = array_map("trim", $lineasCSV);

	$coches = [];
	$cabeceraCsv = explode(",", $lineasCSV[0]);

	// dump(print_r($cabeceraCsv, true));

	for ($i = 1; $i < count($lineasCSV); $i++) {
		$linea = explode(",", $lineasCSV[$i]);
		$coches[$linea[3]] = array_combine($cabeceraCsv, $linea);
	}

	dump(print_r($coches, true));
?>