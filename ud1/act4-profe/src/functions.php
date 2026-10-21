<?php

  function dump($var){
    echo '<pre>'.print_r($var,1).'</pre>';
  }
  function getBoardMarkup($board_data){
    $output = '<div class="board-container">';

    // Pinto a link solo si recibo la posicion
    $linkPos = getLinkPos();
    if ($linkPos["x"] !== null && $linkPos["y"] !== null) {
      $output .= "<img class='link' src='public/img/link.png'>";
    }

    foreach($board_data as $fila){
      foreach ($fila as $tile_value){
        $output .= '<div class="tile '.$tile_value.'-tile"></div>';
      }
    }

    $output .= '</div>';

    return $output;
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

  function jslog($log) {
    echo "<script>console.log(".$log.")</script>";
  }

  function getLinkPos() {
    $res = [];
    $res["x"] = filter_input(INPUT_GET, "link_pos_x", FILTER_VALIDATE_INT);
    $res["y"] = filter_input(INPUT_GET, "link_pos_y", FILTER_VALIDATE_INT);
    
    return $res;
  }
?>