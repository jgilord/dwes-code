<?php
  $tilesIndex = [
    0 => "grass-tile",
    1 => "water-tile",
    2 => "wall-tile",
    3 => "bush-tile"
  ];

  function getMarkupTile($tileIndex) {
    global $tilesIndex;
    return "<div class='tile ".$tilesIndex[$tileIndex]."'></div>";
  }

  function getMarkupFrameTilesRandom() {
    $res = "";

    for ($i=0; $i < 1024; $i++) { 
      $res .= getMarkupTile(mt_rand(0, 3));
      // $res .= getMarkupTile(2);
    }

    return $res;
  }

  function getMarkupFrameTiles(array $stage) {
    $res = "";

    foreach ($stage as $stageLines) {
      foreach ($stageLines as $tile) {
        $res .= getMarkupTile($tile);
      }
    }

    return $res;
  }
?>