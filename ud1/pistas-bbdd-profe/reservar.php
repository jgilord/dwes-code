<?php
//Inicialización entorno
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Includes
include(__DIR__.'/src/vars.php');
include(__DIR__.'/src/functions.php');

if(($_SERVER['REQUEST_METHOD'] === 'POST')&&(isset($_POST['nueva_reserva']))){
  //Proceso la petición
  //Validación de datos
  $datosValidados = validateNuevaReservaInput();
  $datosValidos = true;

  foreach ($datosValidados as $dato) {
    if (!($dato['valido'])) {
      $datosValidos = false;
    }
  }
  
  if ($datosValidos) {
    $saveResult = savePersistentData([
      'dsn' => 'mysql:dbname=reservas_pistas;host=db',
      'username' => 'root',
      'password' => 'zYk8U77FkzRcDjV4NQ9cr6WKHAFNIg91'
    ], 'db', $datosValidados);

    dump($saveResult);
  }
}

//Plantlla
include(__DIR__.'/src/templates/reservar.tpl.php');
?>
