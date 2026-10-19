<?php
  include("../functions.php");

  $reserva = [];

  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $idReserva = filter_input(INPUT_GET, "n", FILTER_UNSAFE_RAW);
    $reserva = getReservaById($idReserva);
  }

  if (!$reserva) {
    http_response_code(404);
  }

  include("../templates/confirmacion.tpl.php");
?>