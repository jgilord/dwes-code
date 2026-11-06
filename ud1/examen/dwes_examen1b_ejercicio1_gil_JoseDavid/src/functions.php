<?php

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


function getPlayersFromDB(PDO $dbh) {
  $res = null;

  try {
    $query = "
      SELECT t.id AS torneo_id, t.nombre, t.juego, j.nick, i.puntos
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

function getTournamentsFromDB(PDO $dbh) {
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

function getPlayersOfTournamentsFromDB(PDO $dbh, int $tournamentId = 0) {
  $res = null;

  try {
    $query = "
      SELECT j.nick, i.puntos
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
// En el ejercicio 2 las demás partes para coger por ejemplo los jugadores de x torneo he usado tu query grande y filtrado. Esta de las 2 formas.
function getTournamentsAndPlayersData(PDO $dbh) {
  $torneos = getTournamentsFromDB($dbh);

  if (isset($torneos)) {
    foreach ($torneos as $key => $value) {
      $torneos[$key]["playersData"] = getPlayersOfTournamentsFromDB($dbh, $torneos[$key]["id"]);
    }
  }

  return $torneos;
}