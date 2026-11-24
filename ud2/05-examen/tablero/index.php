<?php
// ===== INICIALIZACIÓN DEL ENTORNO =====
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// ===== LÓGICA DE NEGOCIO =====
include_once(__DIR__."/lib/funciones.php");
session_start();

$tablero = getTableroFromSession();

// dump(print_r($tablero, 1));

if ($_SERVER['REQUEST_METHOD'] === "POST") {
  $accionValidada = getAccionValidadaPOST();
  // dump(print_r($accionValidada, 1));

  if (isset($accionValidada['accion']) && $accionValidada['valid']) {
    switch ($accionValidada['accion']) {
      case 'pintar':
        pintarCasillaTablero($tablero, $accionValidada);
        updateTableroInSession($tablero);
      break;
      
      case 'borrar':
        borrarCasillaTablero($tablero, $accionValidada);
        updateTableroInSession($tablero);
      break;

      case 'reiniciar':
        reiniciarTablero();
      break;

      case 'deshacer':
        deshacerAccionTablero($tablero);
        updateTableroInSession($tablero);
      break;

      default:
      break;
    }

    header("Location: ./index.php");
    die();
  } else {
    saveMessageInSession("error", "No se ha podido realizar la acción. Revisa los datos.");
  }
}

// ===== LÓGICA DE PRESENTACIÓN =====
// No se porque si no le pongo esto de alguna manera en el post llega y se borra.
$flashMsg = readMessagesFromSession();
$numFilas = count($tablero);
$numCol = count($tablero[0]);
$stats = getStatsFromTablero($tablero);

// dump(print_r($stats, 1));

include_once(__DIR__."/templates/index.tpl.php");