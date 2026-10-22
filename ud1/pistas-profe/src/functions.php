<?php

function dump(array $var) {
  echo '<pre>' . print_r($var, 1) . '</pre>';
}

function getCSVData(string $path) {
  $data = [];
  if (($filehandler = fopen($path, "r")) !== false) {
    $cabeceras = fgetcsv($filehandler);

    while (($fields = fgetcsv($filehandler)) !== false) {
      $data[] = array_combine($cabeceras, $fields);
    }

    fclose($filehandler);
    return $data;
  }
  return null;
}


function getReservasFromDB() {
  $reservas = null;

  try {
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

    $consulta = $dbh->prepare("
      SELECT 
        r.id,
        r.nombre,
        r.email,
        p.nombre AS pista,
        r.fecha,
        TIME_FORMAT(r.hora, '%H:%i') as hora
      FROM 
        reservas r
      INNER JOIN 
        `lista-pistas` p ON r.pista_id = p.id;
    ");

    $consulta->execute();
    $reservas = $consulta->fetchAll();

    foreach ($reservas as &$reserva) {
      $consultaMateriales = $dbh->prepare("
        SELECT material_id
        FROM `materiales-reserva`
        WHERE reserva_id = ?;
      ");

      $consultaMateriales->execute([$reserva["id"]]);
      $materialesReserva = $consultaMateriales->fetchAll(PDO::FETCH_COLUMN);

      if (!empty($materialesReserva)) {
        $reserva["material"] = join(";", $materialesReserva);
      }
    }

  } catch (Exception $e) {
    echo 'Excepción en getReservasFromDB(): ' . $e->getMessage();
    $reservas = null;
  }

  return $reservas;
}


/**
 * Functión que devuelve un array con los filtros presentes en la query string. Si no se han establecido, devuelve un array vacío si no hay filtros;
 * 
 * @return array $filter Los filtros presentes en la query string
 */

function getValidFiltersFromQueryString() {
  $filters = [
    'pista' => FILTER_UNSAFE_RAW,
    'fecha' => FILTER_UNSAFE_RAW,
  ];

  $filtrosSinValidar = filter_input_array(INPUT_GET, $filters);

  // Validamos

  _validateFilterPista($filtrosSinValidar);
  _validateFilterFecha($filtrosSinValidar);

  return $filtrosSinValidar;
}

function filtraFechaPista(array $reserva, array $filtro) {
  $pasaFiltroPista = true;
  $pasaFiltroFecha = true;
  // Si está establecido filtro pista...
  if (isset($filtro['pista'])) {
    if (($reserva['pista'] !== $filtro['pista'])) {
      $pasaFiltroPista = false;
    }
  }
  // Si el filtro tiene fecha, filtramos la fecha
  if (isset($filtro['fecha'])) {
    if (($reserva['fecha'] !== $filtro['fecha'])) {
      $pasaFiltroFecha = false;
    }
  }
  return $pasaFiltroPista && $pasaFiltroFecha;
}

/** Función auxiliar de validación de pista */
function _validateFilterPista(array|null &$filtro) {
  if (
    isset($filtro['pista'])
    && !empty($filtro['pista'])
    && (in_array($filtro['pista'], PISTAS_VALIDAS))
  ) {
    return;
  } else {
    unset($filtro['pista']);
  }
}

/** Función auxiliar de validación de fecha */
function _validateFilterFecha(array|null &$filtro) {
  if (
    isset($filtro['fecha'])
    && !empty($filtro['fecha'])
  ) {
    $dateArray = explode('-', $filtro['fecha']);

    if ((count($dateArray) === 3)
      && (is_numeric($dateArray[2]))
      && (is_numeric($dateArray[1]))
      && (is_numeric($dateArray[0]))
      && (checkdate($dateArray[1], $dateArray[2], $dateArray[0]))
    ) {

      // La fecha es correcta
      return;
    }
  }

  unset($filtro['fecha']);
}