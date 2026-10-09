<?php
  include("functions.php");

  $pistas = ["padel-1" => "Pádel 1", "padel-2" => "Pádel 2", "tenis" => "Tenis", "baloncesto" => "Baloncesto"];
  $horas = ["16:00", "17:00", "18:00", "19:00", "20:00", "21:00"];
  $materiales = ["raquetas" => "Raquetas", "balon" => "Balón", "petos" => "Petos", "conos" => "Conos"];

  $request = false;
  $error = false;
  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $camposReserva = [];
    $errorMessage = "Los siguiente campos no son válidos: ";
    $lineaCSV = "\n";

    $request = true;

    if ($camposReserva["nombre"] = filter_input(INPUT_POST, "nombre", FILTER_DEFAULT)) {
      $lineaCSV .= $camposReserva["nombre"].",";
    } else {
      $error = true;
      $errorMessage .= "Nombre, ";
    }

    if ($camposReserva["email"] = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL)) {
      $lineaCSV .= $camposReserva["email"].",";
    } else {
      $error = true;
      $errorMessage .= "Email, ";
    }

    if ($camposReserva["pista"] = filter_input(INPUT_POST, "pista", FILTER_DEFAULT)) {
      $lineaCSV .= $camposReserva["pista"].",";
    } else {
      $error = true;
      $errorMessage .= "Pista, ";
    }

    if ($camposReserva["fecha"] = filter_input(INPUT_POST, "fecha", FILTER_DEFAULT)) {
      $lineaCSV .= $camposReserva["fecha"].",";
    } else {
      $error = true;
      $errorMessage .= "Fecha, ";
    }

    if ($camposReserva["hora"] = filter_input(INPUT_POST, "hora", FILTER_DEFAULT)) {
      $lineaCSV .= $camposReserva["hora"].",";
    } else {
      $error = true;
      $errorMessage .= "Hora, ";
    }

    $camposReserva["material"] = filter_input(INPUT_POST, 'material', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    if ($camposReserva["material"] !== null) {
      for ($i=0; $i < count($camposReserva["material"]); $i++) { 
        $lineaCSV .= $camposReserva["material"][$i];
        if ($i !== count($camposReserva["material"])-1) {
          $lineaCSV .= "&";
        }
      }
      $lineaCSV .= ",";
    }

    $camposReserva["terminos"] = filter_input(INPUT_POST, "terminos", FILTER_VALIDATE_BOOLEAN);
    if ($camposReserva["terminos"]) {
      $lineaCSV .= "true";
    } else {
      $error = true;
      $errorMessage .= "Términos y condiciones";
    }

    if (!$error) {
      saveReservaCSV($lineaCSV);
    }
  }

  include("templates/reservar.tpl.php");
?>