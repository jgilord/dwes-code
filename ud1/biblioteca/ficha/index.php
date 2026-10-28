<?php 
  include_once("../src/functions.php");

  $idLibro = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

  if ($idLibro) {
    $libro = obtenerLibro($pdo, $idLibro);
  }

  include_once("../src/templates/ficha.tpl.php");
?>