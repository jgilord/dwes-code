<?php
  include("functions.php");

  // $reservas = getReservasFromCSV("datos/reservas.csv", "id");
  $reservas = getReservasFromDB($dbh);
  // dump(print_r($reservas, true));

  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $filtroFecha = filter_input(INPUT_GET, "fecha", FILTER_DEFAULT);
    $filtroPista = filter_input(INPUT_GET, "pista", FILTER_DEFAULT);

    if ($filtroFecha) {
      $reservas = array_filter(
        $reservas,
        function($reserva) use ($filtroFecha) {
          return $reserva["fecha"] === $filtroFecha;
        },
      );
    }

    if ($filtroPista) {
      $reservas = array_filter(
        $reservas,
        function($reserva) use ($filtroPista) {
          return $reserva["pista"] === $filtroPista;
        },
      );
    }

    // dump(print_r($reservas, true));
  }

  include("templates/index.tpl.php")
?>