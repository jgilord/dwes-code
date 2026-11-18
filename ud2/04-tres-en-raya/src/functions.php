<?php

function getMatchFromSession(): array {
  $res = [];

  if(isset($_SESSION["match"]) && !empty($_SESSION["match"])) {
    $res = $_SESSION["match"];
  } else {
    $res = [
      "currentPlayer" => "X",
      "board" => [
        ["", "", ""],
        ["", "", ""],
        ["", "", ""]
      ]
    ];
  }

  return $res;
}

function getMoveValidatedFromPOST(): array|null {
  $res = null;

  $casilla = filter_input(INPUT_POST, "casilla", FILTER_UNSAFE_RAW);

  if (isset($casilla)) {
    $cords = str_split($casilla);

  }

  return $res;
}