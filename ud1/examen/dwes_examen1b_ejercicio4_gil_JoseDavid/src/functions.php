<?php

include(__DIR__.'/vars.php');

function dump($var){
  echo '<pre>'.$var.'</pre>';
}

function getDDBBConnection() {
  $dsn = "mysql:host=db;dbname=dwes_examen1b;charset=utf8mb4";

  return new PDO($dsn, "dwes_examen1b", "dwes_examen1b", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
  ]);
}


function getTournamentsFromDB(PDO $dbh) {
  $res = null;

  try {
    $query = "
      SELECT t.id AS torneo_id, t.nombre, t.juego, j.id AS jugador_id, j.nick, i.puntos
      FROM torneos t
      LEFT JOIN inscripciones i ON i.torneo_id = t.id
      LEFT JOIN jugadores j ON j.id = i.jugador_id
      ORDER BY t.nombre, i.puntos DESC
    ";

    $statement = $dbh->prepare($query);
    if ($statement) {
      $statement->execute();
      $res = $statement->fetchAll();
    }

  } catch (Exception $e) {
    echo "Excepcion en getPlayersFromDB(): ".$e;
  }

  return $res;
}

function getPlayersFromTournament(PDO $dbh, int $tournamentId = 1) {
  $players = getTournamentsFromDB($dbh);

  foreach ($players as $key => $value) {
    if ($players[$key]["torneo_id"] !== $tournamentId) {
      unset($players[$key]);
    }
  }

  return $players;
}

function getTournamentsFromDB2(PDO $dbh) {
  $res = null;

  try {
    $query = "
      SELECT id, nombre, juego
      FROM torneos t
    ";

    $statement = $dbh->prepare($query);
    if ($statement) {
      $statement->execute();
      $res = $statement->fetchAll();
    }

  } catch (Exception $e) {
    echo "Excepcion en getTournamentsFromDB(): ".$e;
  }

  return $res;
}

function getPlayersOfTournamentsFromDB(PDO $dbh, int $tournamentId = 1) {
  $res = null;

  try {
    $query = "
      SELECT j.id, j.nick, i.puntos
      FROM torneos t
      LEFT JOIN inscripciones i ON i.torneo_id = t.id
      LEFT JOIN jugadores j ON j.id = i.jugador_id
      WHERE t.id = ?
      ORDER BY t.nombre, i.puntos DESC
    ";

    $statement = $dbh->prepare($query);
    if ($statement) {
      $statement->execute([$tournamentId]);
      $res = $statement->fetchAll();
    }

  } catch (Exception $e) {
    echo "Excepcion en getPlayersOfTournamentsFromDB(): ".$e;
  }

  return $res;
}

// He decidido hacerlo asi ya que veo mejor que primero se obtengan los torneos que hay y despues la informacion de los jugadores de x torneo, para mi tiene mas sentido
function getTournamentsAndPlayersData(PDO $dbh) {
  $torneos = getTournamentsFromDB2($dbh);

  if (isset($torneos)) {
    foreach ($torneos as $key => $value) {
      $torneos[$key]["playersData"] = getPlayersOfTournamentsFromDB($dbh, $torneos[$key]["id"]);
    }
  }

  return $torneos;
}

function getOpcionValidadaGET() {
  $opcion = filter_input(INPUT_GET, "op", FILTER_UNSAFE_RAW);

  if (!(isset($opcion) && in_array($opcion, OPCIONES_VALIDAS_GET))) {
    $opcion = null;
  }

  return $opcion;
}

function getIdGET() {
  $id = filter_input(INPUT_GET, "id", FILTER_UNSAFE_RAW);

  return $id;
}

function getPointsUpdateFromPOST(PDO $dbh) {
  // A ver, esto es muy raro pero es la unica forma como he sabido hacerlo.

  $pointsUpdate["id_torneo"] = filter_input(INPUT_POST, "idTorneo", FILTER_UNSAFE_RAW);
  $pointsUpdate["players"] = [];
  
  if (isset($pointsUpdate["id_torneo"])) {
    $players = getPlayersFromTournament($dbh, $pointsUpdate["id_torneo"]);

    foreach ($players as $key => $value) {
      $puntosJugadorActual = filter_input(INPUT_POST, $players[$key]["nick"], FILTER_UNSAFE_RAW);

      if (isset($puntosJugadorActual)) {
        $pointsUpdate["players"][$players[$key]["jugador_id"]] = $puntosJugadorActual;
      }
    }
  }

  // dump(print_r($pointsUpdate, true));
  return $pointsUpdate;
}

function updatePointsForPlayersFromDB(PDO $dbh, array|null $pointsUpdate = null) {
  $res = null;

  try {
    $query = "
      UPDATE inscripciones
      SET puntos = ?
      WHERE torneo_id = ? AND jugador_id = ?;
    ";

    foreach ($pointsUpdate["players"] as $key => $value) {
      $statement = $dbh->prepare($query);
      if ($statement) {
        $res = $statement->execute([$value, $pointsUpdate["id_torneo"], $key]);
      }
    }

  } catch (Exception $e) {
    echo "Excepcion en updatePointsForPlayersFromDB(): ".$e;
  }

  return $res;
}


function deletePlayerFromDB(PDO $dbh, int|null $idJugador = null) {
  $res = null;

  if (isset($idJugador)) {
    try {
      $query = "
        DELETE FROM jugadores WHERE id = ?;
      ";

      $statement = $dbh->prepare($query);
      if ($statement) {
        $res = $statement->execute([$idJugador]);
      }
    } catch (Exception $e) {
      // echo "Excepcion en updatePointsForPlayersFromDB(): ".$e;
      $res = null;
    }
  }

  return $res;
}