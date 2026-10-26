<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Práctica: reserva de pistas deportivas</title>
  <!-- <link rel="stylesheet" href="public/style.css"> -->
  <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
  <style>
    h3 {
      margin-top: 1rem;
      margin-bottom: 0.5rem;
    }
    table {
      margin: 0;
    }
  </style>
</head>
<body>
  <h1>Reserva de pista</h1>
  <?php if ($reserva): ?>
  <p class="notice" style=" background-color: green;">Reserva realizada de forma correcta!</p>
  <h3>Reserva #<?= htmlspecialchars($reserva["id"]) ?></h3>

  <ul>
    <?php foreach ($reserva as $clave => $valor): ?>
      <?php if (!($clave === "id" || $clave === "material" || $clave === "terminos")): ?>
        <li><?= htmlspecialchars($clave) ?>: <?= htmlspecialchars($valor) ?></li>
      <?php endif ?>
      <?php if ($clave === "material"): ?>
        <li>materiales: <?= htmlspecialchars(join(", ", $reserva["material"])) ?></li>
      <?php endif ?>
    <?php endforeach; ?>
  </ul>
  <?php else: ?>
  <p class="notice" style=" background-color: red;">Solicitud de reserva invalida. 404</p>
  <?php endif ?>
  <a href="../"><button>🡠 Volver a la lista de reservas</button></a>
  <a href="../reservar"><button>⟲ Realizar una nueva reserva</button></a>
</body>
</html>