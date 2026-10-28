<?php 
  include_once(__DIR__."/src/functions.php");

  $pdo = conectar();

  dump(contarLibrosDisponible($pdo));
  dump(print_r(obtenerLibro($pdo, 1), true));

  $libros = listarLibros($pdo, "Novela");

  include_once(__DIR__."/src/templates/index.tpl.php");
?>