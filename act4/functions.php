<?php
  $tilesIndex = [
    // Fila 0 (0 - 5)
    0  => "bridge-wood-tile",
    1  => "stairs-down-tile",
    2  => "stairs-tile",
    3  => "sand-top-left-tile",
    4  => "sand-top-tile",
    5  => "sand-top-right-tile",

    // Fila 1 (6 - 11)
    6  => "water-top-left-tile",
    7  => "water-top-tile",
    8  => "water-top-right-tile",
    9  => "green-mountain-top-left-tile",
    10 => "green-mountain-top-tile",
    11 => "green-mountain-top-right-tile",

    // Fila 2 (12 - 17)
    12 => "water-left-tile",
    13 => "water-tile",
    14 => "water-right-tile",
    15 => "green-mountain-middle-left-tile",
    16 => "green-mountain-middle-tile",
    17 => "green-mountain-middle-right-tile",

    // Fila 3 (18 - 23)
    18 => "water-bottom-left-tile",
    19 => "water-bottom-tile",
    20 => "water-bottom-right-tile",
    21 => "green-rock-tile",
    22 => "bush-tile",
    23 => "wall-tile",

    // Fila 4 (24 - 29)
    24 => "coast-top-left-tile",
    25 => "coast-top-right-tile",
    26 => "coast-bottom-left-tile",
    27 => "coast-bottom-right-tile",
    28 => "dry-bush-tile",
    29 => "gravestone-tile",

    // Fila 5 (30 - 35)
    30 => "brown-mountain-top-left-tile",
    31 => "brown-mountain-top-tile",
    32 => "brown-mountain-top-right-tile",
    33 => "brown-rock-tile",
    34 => "white-flower-tile",
    35 => "grass-tile",

    // Fila 6 (36 - 41)
    36 => "brown-mountain-bottom-left-tile",
    37 => "brown-mountain-bottom-tile",
    38 => "brown-mountain-bottom-right-tile",
    39 => "grey-mountain-top-left-tile",
    40 => "grey-mountain-top-tile",
    41 => "grey-mountain-top-right-tile",

    // Fila 7 (42 - 47)
    42 => "stone-floor-tile",
    43 => "green-bridge-tile",
    44 => "grey-rock-tile",
    45 => "grey-mountain-bottom-left-tile",
    46 => "grey-mountain-bottom-tile",
    47 => "grey-mountain-bottom-right-tile"
  ];

  function getMarkupTile($tileIndex, ?bool $link = null) {
    global $tilesIndex;
    $res = "<div class='tile ";
    $res .= $tilesIndex[$tileIndex]."'>";

    if ($link) {
      $res .= "<img src='public/link.png'></img>";
    }

    $res .= "</div>";
    return $res;
  }

  function getRandomStage() {
    $stage = [];

    for ($i=0; $i < 32; $i++) { 
      $line = [];
      for ($j=0; $j < 32; $j++) { 
        $line[] = mt_rand(0, 47);
      }
      $stage[] = $line;
    }

    return $stage;
  }
  
  function getBaseStage() {
    $stage = [];

    for ($i=0; $i < 32; $i++) { 
      $line = [];
      for ($j=0; $j < 32; $j++) { 
        $line[] = 35;
      }
      $stage[] = $line;
    }

    return $stage;
  }

  function getBoardMarkup(array $stage, array $link_pos) {
    $res = "";

    foreach ($stage as $x => $stageLines) {
      foreach ($stageLines as $y => $tile) {
        $showLink = false;
        if ($link_pos["x"] === $x && $link_pos["y"] === $y) {
          $showLink = true;
        }
        $res .= getMarkupTile($tile, $showLink);
      }
    }

    return $res;
  }

	function CSVtoBoard(String $CSVPath) {
		$archivoTextoPlano = file_get_contents($CSVPath);
		$filasCSV = array_map("trim", explode("\n", $archivoTextoPlano));
		
		$res = [];

    foreach ($filasCSV as $fila) {
      $res[] = explode(",", $fila);
    }

		return $res;
	}

  function getLinkPos() {
    $res = [];
    $res["x"] = filter_input(INPUT_GET, "link_pos_x", FILTER_VALIDATE_INT);
    $res["y"] = filter_input(INPUT_GET, "link_pos_y", FILTER_VALIDATE_INT);
    // print_r($res);
    return $res;
  }

  function getNextLinkPosURL($dir) {
    $linkPos = getLinkPos();
    $x = $linkPos["x"];
    $y = $linkPos["y"];
    if ($dir === "up" && $x > 0) {
      $x--;
    } else if ($dir === "down" && $x < 31) {
      $x++;
    } else if ($dir === "left" && $y > 0) {
      $y--;
    } else if ($dir === "rigth" && $y < 31) {
      $y++;
    }

    return "/act4/?link_pos_x=".$x."&link_pos_y=".$y;
  }
?>