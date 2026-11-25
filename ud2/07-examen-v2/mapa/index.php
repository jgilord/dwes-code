<?php

/* ***** INICIALIZACIÓN DEL ENTORNO ***** */
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* ***** LÓGICA DE NEGOCIO ***** */
include_once(__DIR__."/lib/functions.php");
$map = getMapFromSession();
// dump(print_r($map, 1));

// saveMessageInSession("success", "hola1");
// saveMessageInSession("error", "hola2");

$accionValidada = getAccionValidadaFromPost($map);

if (isset($accionValidada) && $accionValidada["valid"]) {
  switch ($accionValidada["accion"]) {
    case 'colocar':
      colocarTile($map, $accionValidada);
      updateMapInSession($map);
    break;

    case 'quitar':
      quitarTile($map, $accionValidada);
      updateMapInSession($map);
    break;

    case 'reiniciar':
      reiniciarMap($map);
    break;

    case 'deshacer':
      deshacerMovimiento($map);
      updateMapInSession($map);
    break;
    
    default:
      # code...
      break;
  }

  header("Location: ./index.php");
  die();
}

/* ***** LÓGICA DE PRESENTACIÓN ***** */
$numFilas = FILAS;
$numColumnas = COLUMNAS;
$tiles = TILES;
$messages = getMessageFromSession();
$stats = getStatsFromMap($map);
// dump(print_r($messages, 1));
// dump(print_r($accionValidada, 1));
// dump(print_r($stats, 1));


include_once(__DIR__."/templates/index.tpl.php");

?>