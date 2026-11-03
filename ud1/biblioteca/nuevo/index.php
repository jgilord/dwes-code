<?php 
  include_once("../src/functions.php");

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $libroValidado = libroValidadoPOST();
  }

  if (isset($libroValidado) && $libroValidado["valido"]) {
    $idLibroInsertado = insertarLibro($pdo, $libroValidado);
  }

  include_once("../src/templates/nuevo.tpl.php");
?>