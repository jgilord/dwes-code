<?php
  include("../functions.php");

  $request = false;
  $errors = [];

  $curDate = new DateTime("now");
  $curDateFormated = $curDate->format("Y-m-d");
  $maxDateFormated = $curDate->modify("+14 days")->format("Y-m-d");
  $reserva = [];
  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request = true;

    $reserva["nombre"] = filter_input(INPUT_POST, "nombre", FILTER_UNSAFE_RAW);
    if (!($reserva["nombre"]) || (strlen($reserva["nombre"]) < 2 || strlen($reserva["nombre"]) > 60)) {
      $errors[] = "nombre";
    }

    if (!($reserva["email"] = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL))) {
      $errors[] = "email";
    }

    $reserva["pista"] = filter_input(INPUT_POST, "pista", FILTER_UNSAFE_RAW);
    if (!(isset($pistas[$reserva["pista"]]))) {
      $errors[] = "pista";
    }

    if (!($reserva["fecha"] = filter_input(INPUT_POST, "fecha", FILTER_UNSAFE_RAW))) {
      $errors[] = "fecha";
    }

    $reserva["hora"] = filter_input(INPUT_POST, "hora", FILTER_UNSAFE_RAW);
    if (!(in_array($reserva["hora"], $horas))) {
      $errors[] = "hora";
    }

    $reserva["material"] = filter_input(INPUT_POST, 'material', FILTER_UNSAFE_RAW, FILTER_REQUIRE_ARRAY);
    if (!empty($reserva["material"])) {
      foreach ($reserva["material"] as $material) {
        if (!(isset($materiales[$material]))) {
          $errors["material"] = "material";
        }
      }
    }

    if (!($reserva["terminos"] = filter_input(INPUT_POST, "terminos", FILTER_VALIDATE_BOOLEAN))) {
      $errors[] = "terminos";
    }

    $idReserva = getCodigoReserva($reserva);

    if (existeReserva($dbh, $idReserva)) {
      $errors[] = "reserva ya existente";
    }

    if (empty($errors)) {
      saveReservaBBDD($dbh, $idReserva, $reserva);
      http_response_code(303);
      header('Location: ../confirmacion/?n='.$idReserva);
    } else {
      http_response_code(422);
    }
  }

  include("../templates/reservar.tpl.php");
?>