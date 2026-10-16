<?php
  include("../functions.php");

  $reserva = [];

  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $idReserva = filter_input(INPUT_GET, "n", FILTER_UNSAFE_RAW);
    $reserva = getReservaById($idReserva);
  }

  if ($reserva) {
    dump(print_r($reserva, true));
  }

  include("../templates/confirmacion.tpl.php");
?>