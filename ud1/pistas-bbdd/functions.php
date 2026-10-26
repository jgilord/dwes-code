<?php
	// Dump funtion
	function dump($dump) {
		echo "<pre>".$dump."</pre>";
	}
  
  function consoleLog($log) {
    echo "<script>console.log('".$log."')</script>";
  }
  
	$dbh = new PDO(
		'mysql:host=db;dbname=reserva-pistas;charset=utf8mb4', // DSN
		'userPistas', // usuario
		'userPistas', // contraseña
		[ // opciones
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES => false,
		]
	);

	// Opciones y validación
  $pistas = getListaFromDB($dbh, "pistas");
  $horas = ["16:00", "17:00", "18:00", "19:00", "20:00", "21:00"];
  $materiales = getListaFromDB($dbh, "materiales");

	function getReservasFromCSV(String $CSVPath, ?String $index = null) {
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

	function getReservasFromDB($dbh, $id = null) {
		$reservas = null;

		try {
			$query = "
				SELECT 
					r.id,
					r.nombre,
					r.email,
					p.id AS pista,
					r.fecha,
					TIME_FORMAT(r.hora, '%H:%i') as hora
				FROM 
					reservas r
				INNER JOIN 
					`lista-pistas` p ON r.pista_id = p.id";

			if ($id) {
				$query .= "
				WHERE r.id = ?;
				";
			} else {
				$query .= ";";
			}

			$consulta = $dbh->prepare($query);

			if ($id) {
				$consulta->execute([$id]);
			} else {
				$consulta->execute();
			}

			$reservas = $consulta->fetchAll();

			foreach ($reservas as &$reserva) {
				$consultaMateriales = $dbh->prepare("
					SELECT material_id
					FROM `materiales-reserva`
					WHERE reserva_id = ?;
				");

				$consultaMateriales->execute([$reserva["id"]]);
				$materialesReserva = $consultaMateriales->fetchAll(PDO::FETCH_COLUMN);
				$reserva["material"] = $materialesReserva??[];
			}
			
			if ($id && isset($reservas[0])) {
				$reservas = $reservas[0];
			}

		} catch (Exception $e) {
			echo 'Excepción en getReservasFromDB(): ' . $e->getMessage();
			$reservas = null;
		}

		// dump(print_r($reservas, true));
		return $reservas;
	}

	function getListaFromDB($dbh, $lista) {
		$pistas = null;

		try {
			switch ($lista) {
				case 'pistas':
				$query = "SELECT * FROM `lista-pistas`;";
				break;
				case 'materiales':
				$query = "SELECT * FROM `lista-materiales`;";
				break;
				
				default:
				$query = "SELECT * FROM `lista-pistas`;";
				break;
			}
			
			$consulta = $dbh->prepare($query);

			$consulta->execute();
			$pistas = $consulta->fetchAll();

			foreach ($pistas as $key => $value) {
				$pistas[$pistas[$key]["id"]] = $pistas[$key]["nombre"];
				unset($pistas[$key]);
			}

		} catch (Exception $e) {
			echo 'Excepción en getListaFromDB(): ' . $e->getMessage();
			$pistas = null;
		}

		return $pistas;
	}

  function saveReservaBBDD($dbh, $id, array $reserva) {
		$res = false;

		// dump(print_r($reserva, true));

		try {
			$consulta = $dbh->prepare("
				INSERT INTO `reservas`
				VALUES (?, ?, ?, ?, ?, ?);
			");

			$res = $consulta->execute([
				$id,
				$reserva["nombre"],
				$reserva["email"],
				$reserva["pista"],
				$reserva["fecha"],
				$reserva["hora"]
			]);

			if ($res && !empty($reserva["material"])) {
				$query = "
					INSERT INTO `materiales-reserva`
					VALUES
				";

				$valores = [];
				for ($i = 0; $i < count($reserva["material"]); $i++) {
					$valores[] = "(?, ?)";
				}
				$query .= implode(", ", $valores) . ";";

				$params = [];
				foreach ($reserva["material"] as $material) {
					$params[] = $id;
					$params[] = $material;
				}

				$consultaMateriales = $dbh->prepare($query);
				$res = $consultaMateriales->execute($params);
			}

		} catch (Exception $e) {
			echo 'Excepción en saveReservaBBDD(): ' . $e->getMessage();
			$res = false;
		}

    return $res;
  }

  function getCodigoReserva(array $reserva) {
		$res = hash("murmur3a", ($reserva["pista"]."_".$reserva["fecha"]."_".$reserva["hora"]));
    return $res;
  }
	
	function existeReserva($dbh, $id = "") {
		$res = null;

		try {
			$consulta = $dbh->prepare("
				SELECT id = ? as 'exists'
				FROM `reservas` 
				WHERE id = ?;
			");

			$consulta->execute([$id, $id]);
			$res = $consulta->fetch();

			if (isset($res["exists"])) {
				$res = $res["exists"];
			} else {
				$res = false;
			}

		} catch (Exception $e) {
			echo 'Excepción en getReservasFromDB(): ' . $e->getMessage();
			$res = null;
		}

		return $res;
	}

	// dump(print_r(getReservasFromDB($dbh, "045a07ea")));
?>