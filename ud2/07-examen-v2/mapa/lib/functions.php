<?php
const FILAS = 6;
const COLUMNAS = 8;

const TILES = [
'hierba' => ['nombre' => 'Hierba', 'max' => 12],
'agua' => ['nombre' => 'Agua', 'max' => 8],
'arena' => ['nombre' => 'Arena', 'max' => 8],
'arbol' => ['nombre' => 'Árbol', 'max' => 6],
'roca' => ['nombre' => 'Roca', 'max' => 4],
'muro' => ['nombre' => 'Muro', 'max' => 10],
];

function dump($str) {
  echo "<pre>".$str."</pre>";
}

function saveMessageInSession(string $type, string $message) {
  if (!isset($_SESSION["flash-msg"])) {
    $_SESSION["flash-msg"] = [];
  }

  $_SESSION["flash-msg"][$type] = $message;
}

function getMessageFromSession(): array {
  $res = [];

  if (isset($_SESSION["flash-msg"])) {
    $res = $_SESSION["flash-msg"];
    unset($_SESSION["flash-msg"]);
  }

  return $res;
}

function getEmptyMap() {
  $res = [];

  for ($i=0; $i < FILAS; $i++) { 
    $res[$i] = [];
    for ($j=0; $j < COLUMNAS; $j++) { 
      $res[$i][$j] = null;
    }
  }

  return $res;
}

function getMapFromSession() {
  if (!isset($_SESSION["map"])) {
    $_SESSION["map"] = getEmptyMap();
  }

  return $_SESSION["map"];
}

function updateMapInSession(array $map) {
  $_SESSION["map"] = $map;
}

// le tengo que pasar el map para el error de max casillas
function getAccionValidadaFromPost($map) {
  $res = [];

  $res["accion"] = filter_input(INPUT_POST, "accion", FILTER_UNSAFE_RAW);
  $res["row"] = filter_input(INPUT_POST, "fila", FILTER_UNSAFE_RAW);
  $res["col"] = filter_input(INPUT_POST, "columna", FILTER_UNSAFE_RAW);
  $res["tile"] = filter_input(INPUT_POST, "tile", FILTER_UNSAFE_RAW);
  $res["valid"] = true;
  $res["errors"] = [];

  if (isset($res["accion"]) && in_array($res["accion"], ["colocar", "quitar", "reiniciar", "deshacer"])) {
    if (in_array($res["accion"], ["colocar", "quitar"])) {
      if (!(isset($res["row"]) && $res["row"] >= 1 && $res["row"] <= FILAS)) {
        $res["valid"] = false;
        $res["errors"][] = "row";
      }

      if (!(isset($res["col"]) && $res["col"] >= 1 && $res["col"] <= COLUMNAS)) {
        $res["valid"] = false;
        $res["errors"][] = "col";
      }
    }

    if ($res["accion"] === "colocar") {
      if (!(isset($res["tile"]) && in_array($res["tile"], array_keys(TILES)))) {
        $res["valid"] = false;
        $res["errors"][] = "tile";
      } else {
        if (getStatsFromMap($map)["tiles"][$res["tile"]] >= TILES[$res["tile"]]["max"]) {
          if ($res["valid"] && $map[$res["row"]-1][$res["col"]-1] !== $res["tile"]) {
            $res["valid"] = false;
            $res["errors"][] = "max-tile";
          }
        }
      }
      
    }

  } else {
    $res["valid"] = false;
  }

  return $res;
}

function colocarTile(array &$map, array $accionValidada) {
  $row = $accionValidada["row"]-1;
  $col = $accionValidada["col"]-1;
  $tile = $accionValidada["tile"];

  $tileOriginal = $map[$row][$col];
  $map[$row][$col] = $tile;

  saveMessageInSession("success", "Se ha colocado «".TILES[$tile]["nombre"]."» en la casilla (".$accionValidada["row"].", ".$accionValidada["col"].").");
  saveMoveInSession($row, $col, $tileOriginal);
}


function quitarTile(array &$map, array $accionValidada) {
  $row = $accionValidada["row"]-1;
  $col = $accionValidada["col"]-1;

  $tileOriginal = $map[$row][$col];
  
  if (isset($map[$row][$col])) {
    $map[$row][$col] = null;
    saveMessageInSession("success", "Se ha borrado la casilla (".$accionValidada["row"].", ".$accionValidada["col"].") correctamente.");
    saveMoveInSession($row, $col, $tileOriginal);
  } else {
    saveMessageInSession("error", "La casilla (".$accionValidada["row"].", ".$accionValidada["col"].") no puede ser eliminada, no tiene tile.");
  }
}

function reiniciarMap(&$map) {
  // unset($_SESSION["map"]);
  $_SESSION["map"] = getEmptyMap();
  saveMessageInSession("success", "Se ha reiniciado el mapa correctamente.");
}

function getStatsFromMap($map) {
  $res = [];
  $res["totalTiles"] = 0;
  $res["placedTiles"] = 0;
  $res["progress"] = 0;
  $res["tiles"] = [];

  foreach (TILES as $key => $value) {
    $res["tiles"][$key] = 0;
  }

  foreach ($map as $fila) {
    foreach ($fila as $tile) {
      $res["totalTiles"]++;

      if (isset($tile)) {
        $res["placedTiles"]++;
        $res["tiles"][$tile]++;
      }
    }
  }

  $totalProgress = (100 / $res["totalTiles"]) * $res["placedTiles"];
  $res["progress"] = number_format($totalProgress, 2, ',', '.'); 

  return $res;
}

function saveMoveInSession($row, $col, $tile) {
  if (!isset($_SESSION["mov"])) {
    $_SESSION["mov"] = [];
  }

  $_SESSION["mov"][] = [
    "row" => $row,
    "col" => $col,
    "tile" => $tile
  ];
}

function deshacerMovimiento(&$map) {
  if (isset($_SESSION["mov"]) && !empty($_SESSION["mov"])) {
    $mov = array_pop($_SESSION["mov"]);

    $map[$mov["row"]][$mov["col"]] = $mov["tile"];
    saveMessageInSession("success", "Se ha deshecho el último movimiento.");
  } else {
    saveMessageInSession("error", "No se puede deshacer.");
  }
  
}

?>