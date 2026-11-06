<?php

//Startup errors (dev mode)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__.'/src/functions.php');

$opcionGET = getOpcionValidadaGET();
$dbh = getDDBBConnection();

//Script principal
switch ($opcionGET) {
  case 'lista_torneos':
    $tournamentsAndPlayersData = getTournamentsAndPlayersData($dbh);
    // dump(print_r($tournamentsAndPlayersData, true));

    include(__DIR__.'/src/templates/lista_torneos.tpl.php');
  break;

  case 'actualizar_puntos':
    $idTorneo = getIdGET();
    $playersData = null;

    if (isset($idTorneo)) {
      $playersData = getPlayersFromTournament($dbh, $idTorneo);
      $nombreTorneo = $playersData[array_keys($playersData)[0]]["nombre"];
      $juegoTorneo = $playersData[array_keys($playersData)[0]]["juego"];
      // dump(print_r($playersData, true));
      
      $pointsUpdateFromPOST = getPointsUpdateFromPOST($dbh);
      if (isset($pointsUpdateFromPOST["id_torneo"]) && isset($pointsUpdateFromPOST["players"])) {
        $resultado = updatePointsForPlayersFromDB($dbh, $pointsUpdateFromPOST);
        if ($resultado) {
          header("Location: ./index.php?op=lista_torneos");
        }
      }
      
    }


    include(__DIR__.'/src/templates/actualizar_puntos.tpl.php');
  break;
  
  case 'borrar_jugador':
    $idJugador = getIdGET();

    deletePlayerFromDB($dbh, $idJugador);

    header("Location: ./index.php?op=lista_torneos");
  break;
  
  default:
    header("Location: ./index.php?op=lista_torneos");
  break;
}
