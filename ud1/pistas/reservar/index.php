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

    if (!($reserva["nombre"] = filter_input(INPUT_POST, "nombre", FILTER_UNSAFE_RAW))) {
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
    // if ($reserva["material"] === null) {
    //   $errors[] = "material";
    // }

    if (!($reserva["terminos"] = filter_input(INPUT_POST, "terminos", FILTER_VALIDATE_BOOLEAN))) {
      $errors[] = "terminos";
    }

    $idReserva = getCodigoReserva($reserva);

    if (existeReserva($idReserva)) {
      $errors[] = "reserva ya existente";
    }

    if (empty($errors)) {
      saveReservaCSV($idReserva, $reserva);
      http_response_code(303);
      header('Location: ../confirmacion/?n='.$idReserva);
    } else {
      http_response_code(422);
    }
  }

  include("../templates/reservar.tpl.php");
?>