<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Dump funtion
function dump($dump) {
  echo "<pre>".$dump."</pre>";
}


function getFamMarkup(array $fam) {
  return "<li>".$fam["cod"]." -> ".$fam["nombre"]."</li>";
}

try {
  $dbh = new PDO(
    'mysql:host=localhost;dbname=dwes;charset=utf8mb4', // DSN
    'dwes', // usuario
    'abc123.', // contraseña
    [ // opciones
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES => false,
    ]
  );

  $server_version = $dbh->getAttribute(PDO::ATTR_SERVER_VERSION);

  echo $server_version . "<br/>";

  // $dbs = $dbh->query('SELECT cod, nombre, tlf FROM tienda ORDER BY nombre');

  // if($dbs) {
  //   $data = $dbs->fetchAll();
  //   var_dump($data);
  // }

  $codFam = filter_input(INPUT_GET, "cod");

  if ($codFam) {
    $consulta = $dbh->prepare('SELECT cod, nombre FROM familia WHERE cod = ?');
    $consulta->execute([$codFam]);
  } else {
    $consulta = $dbh->query('SELECT cod, nombre FROM familia');
  }

  $familias = $consulta->fetchAll();
} catch (Exception $e) {
  echo 'Se lanzo una excepción: ' . $e->getMessage();
}

include("templates/html.tpl.php");
?>