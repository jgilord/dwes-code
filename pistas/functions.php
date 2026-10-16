<?php
	// Dump funtion
	function dump($dump) {
		echo "<pre>".$dump."</pre>";
	}
  
  function consoleLog($log) {
    echo "<script>console.log('".$log."')</script>";
  }
  
	// Opciones y validación
  $pistas = ["padel-1" => "Pádel 1", "padel-2" => "Pádel 2", "tenis" => "Tenis", "baloncesto" => "Baloncesto"];
  $horas = ["16:00", "17:00", "18:00", "19:00", "20:00", "21:00"];
  $materiales = ["raquetas" => "Raquetas", "balon" => "Balón", "petos" => "Petos", "conos" => "Conos"];

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

  function saveReservaCSV($id, array $reserva) {
		$res = false;

		dump($id);

		array_unshift($reserva, $id);
		$reserva["terminos"] = "true";
		$reserva["material"] = join("&", $reserva["material"]);
		$lineaCSV = "\n".join(",", $reserva);
		dump($lineaCSV);
    $res = file_put_contents("../datos/reservas.csv", $lineaCSV, FILE_APPEND);

    return $res;
  }

  function getCodigoReserva(array $reserva) {
		$res = hash("murmur3a", ($reserva["pista"]."_".$reserva["fecha"]."_".$reserva["hora"]));
    return $res;
  }
	
  function existeReserva($id) {
  	$reservas = CSVtoArray("../datos/reservas.csv", "id");
    return isset($reservas[$id]);
  }

  function getReservaById($id_reserva) {
  	$res = null;
		
		foreach (CSVtoArray("../datos/reservas.csv", "id") as $id => $reserva) {
			if ($id === $id_reserva) {
				$res = $reserva;
			}
		}

    return $res;
  }
?>