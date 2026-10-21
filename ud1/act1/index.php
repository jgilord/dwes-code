<?php
	// Dump funtion
	function dump($dump) {
		echo "<pre>".$dump."</pre>";
	}


	// Pruebas

	$coches = [
		crearCoche("Seat", "Ibiza", "Rojo", "9876LMN"),
		crearCoche("Renault", "Clio", "Azul", "5432BDF"),
		crearCoche("Peugeot", "208", "Negro", "1122KLP"),
		crearCoche("Volkswagen", "Golf", "Blanco", "8899XCV"),
		crearCoche("Ford", "Focus", "Gris", "4455HRT"),
		crearCoche("Hyundai", "Tucson", "Verde", "3322JMK"),
		crearCoche("Kia", "Sportage", "Plata", "7766NRW"),
		crearCoche("Dacia", "Sandero", "Naranja", "5544PQL"),
		crearCoche("BMW", "Serie 3", "Blanco", "6611VBN"),
		crearCoche("Audi", "A3", "Negro", "2288ZXT")
	];

	// Imprimir todos los coches
	// echo "=== TODOS LOS COCHES ===\n\n";
	// print_r($coches);

	// $color = "Blanco";
	// $cochesColor = obtenerCochesPorColor($coches, $color);

	// echo "\n\n=== TODOS LOS COCHES (".$color.") ===\n\n";
	// print_r($cochesColor);

	// echo "\n\n=== MARCA DE LOS COCHES (".$color.") ===\n\n";
	// foreach($cochesColor as $coche) {
	// 	echo "- ".$coche["marca"]."\n";
	// }

	dump(print_r(indexarCoches($coches), true));

	// Funciones

	function crearCoche($marca, $modelo, $color, $matricula) {
		return array("marca" => $marca, "modelo" => $modelo, "color" => $color, "matricula" => $matricula);
	}

	function obtenerCochesPorColor($coches, $color) {
		$res = [];

		foreach($coches as $coche) {
			if ($coche["color"] === $color) {
				$res[] = $coche;
			}
		}

		return $res;
	}

	function indexarCoches($coches) {
		$res = [];

		foreach($coches as $coche) {
			$res[$coche["matricula"]] = $coche;
		}

		return $res;
	}

	// array_column();
	// array_combine();
	// array_filter();
	// array_is();
	// array_map();
	// array_pop();
	// array_push();
	// array_walk();
	// array_shift();
	// in_array();
	// reset();
	// explode();
	// implode();
?>