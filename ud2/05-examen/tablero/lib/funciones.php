<?php
const TAMANO = 6;

const PALETA = [
  'rojo' => 'Rojo',
  'azul' => 'Azul',
  'verde' => 'Verde',
  'amarillo' => 'Amarillo',
  'morado' => 'Morado',
  'naranja' => 'Naranja'
];

function dump($str) {
  echo "<pre>".$str."</pre>";
}



function getTableroEmpty(): array {
  $res = [];

  for ($i=0; $i < TAMANO ; $i++) { 
    $res[$i] = [];
    for ($j=0; $j < TAMANO ; $j++) { 
      $res[$i][$j] = null;
    }
  }

  return $res;
}

function getTableroFromSession(): array {
  $res = null;

  if (!(isset($_SESSION["tablero"]) && !empty($_SESSION["tablero"]))) {
    $_SESSION["tablero"] = getTableroEmpty();
  }

  $res = $_SESSION["tablero"];

  return $res;
}

function getAccionValidadaPOST() {
  $res = [
    "accion" => null,
    "fila" => null,
    "columna" => null,
    "color" => null,
    "valid" => true,
    "errors" => []
  ];

  $opt = filter_input(INPUT_POST, "accion", FILTER_UNSAFE_RAW);
  $res["fila"] = filter_input(INPUT_POST, "fila", FILTER_VALIDATE_INT);
  $res["columna"] = filter_input(INPUT_POST, "columna", FILTER_VALIDATE_INT);
  $res["color"] = filter_input(INPUT_POST, "color", FILTER_UNSAFE_RAW);

  if (isset($opt) && in_array($opt, ["pintar", "borrar", "reiniciar", "deshacer"])) {
    $res["accion"] = $opt;

    // Un poquillo regu el establecer fila y demas dos veces pero bueno no me da tiempo
    if (in_array($opt, ["pintar", "borrar"])) {
      if (!(isset($res["fila"]) && $res["fila"] >= 1 && $res["fila"] <= TAMANO)) {
        $res["valid"] = false;
        $res["errors"]["general"] = true;
        $res["errors"]["row"] = true;
      }

      if (!(isset($res["columna"]) && $res["columna"] >= 1 && $res["columna"] <= TAMANO)) {
        $res["valid"] = false;
        $res["errors"]["general"] = true;
        $res["errors"]["col"] = true;
      }
    }

    if ($opt === "pintar") {
      if (!(isset($res["color"]) && in_array($res["color"], array_keys(PALETA)))) {
        $res["valid"] = false;
        $res["errors"]["general"] = true;
        $res["errors"]["color"] = true;
      }
    }
  } else {
    $res["valid"] = false;
    $res["errors"]["general"] = true;
  }
  
  return $res;
}

function saveChangeInSession(array $change) {
  if (!isset($_SESSION["changes"])) {
    $_SESSION["changes"] = [];
  }

  $_SESSION["changes"][] = $change;
}

function pintarCasillaTablero(array &$tablero, array $opcionValidada) {
  $row = $opcionValidada["fila"] - 1;
  $col = $opcionValidada["columna"] - 1;
  
  $colorAnterior = $tablero[$row][$col];
  
  $tablero[$row][$col] = $opcionValidada["color"];
  
  saveChangeInSession([
    "row" => $row, 
    "col" => $col, 
    "colorAnterior" => $colorAnterior
  ]);
  saveMessageInSession("success", "Casilla (".$opcionValidada["fila"].", ".$opcionValidada["columna"].") pintada de ".$opcionValidada["color"].".");
}

function borrarCasillaTablero(array &$tablero, array $opcionValidada) {
    $row = $opcionValidada["fila"] - 1;
    $col = $opcionValidada["columna"] - 1;
    
    $colorAnterior = $tablero[$row][$col]; 

    if ($colorAnterior !== null) {
      saveChangeInSession([
        "row" => $row, 
        "col" => $col, 
        "colorAnterior" => $colorAnterior
      ]);
      $tablero[$row][$col] = null;
      saveMessageInSession("success", "Casilla (".$opcionValidada["fila"].", ".$opcionValidada["columna"].") borrada de forma correcta.");
    } else {
      saveMessageInSession("error", "La casilla (".$opcionValidada["fila"].", ".$opcionValidada["columna"].") no puede ser borrada.");
    }
}

function deshacerAccionTablero(array &$tablero) {
  if (isset($_SESSION["changes"]) && !empty($_SESSION["changes"])) {
    $ultimaAccion = array_pop($_SESSION["changes"]);
    $tablero[$ultimaAccion["row"]][$ultimaAccion["col"]] = $ultimaAccion["colorAnterior"];
    saveMessageInSession("success", "Última acción deshecha.");
  } else {
    saveMessageInSession("error", "No hay acciones para deshacer.");
  }
}

function reiniciarTablero() {
  $tablero = getTableroEmpty();
  $_SESSION["tablero"] = $tablero;
  $_SESSION["changes"] = [];
  saveMessageInSession("success", "Tablero reiniciado de forma correcta.");
}

function updateTableroInSession($tablero) {
  $_SESSION["tablero"] = $tablero;
}

function saveMessageInSession($type, $message) {
  if (!isset($_SESSION["flash-msg"])) {
    $_SESSION["flash-msg"] = [];
  }

  $_SESSION["flash-msg"][$type] = $message;
}

function readMessagesFromSession() {
  $res = [];

  if (isset($_SESSION["flash-msg"])) {
    $res = $_SESSION["flash-msg"];
    unset($_SESSION["flash-msg"]);
  }

  return $res;
}

function getStatsFromTablero($tablero): array {
  $res = [
    "casillasPintadas" => 0,
    "casillasPintadasPorColor" => [],
    "casillasTotales" => 0,
    "progreso" => 0
  ];

  foreach ($tablero as $filas) {
    foreach ($filas as $casilla) {
      $res['casillasTotales']++;

      if (isset($casilla)) {
        $res['casillasPintadas']++;
        if (!isset($res['casillasPintadasPorColor'][$casilla])) {
          $res['casillasPintadasPorColor'][$casilla] = 0;
        }

        $res['casillasPintadasPorColor'][$casilla]++;
      }
    }
  }

  $progreso = (100 / $res['casillasTotales']) * $res['casillasPintadas'];
  $res['progreso'] = number_format($progreso, 2, '.', ',');

  return $res;
}
