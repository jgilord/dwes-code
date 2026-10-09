<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Práctica: reserva de pistas deportivas</title>
  <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
  <style>
    h3 {
      margin-bottom: 0;
    }
  </style>
</head>
<body>
  <h1>Reservas de pistas deportivas</h1>
  <table>
    <tr>
      <th>Nombre</th>
      <th>Email</th>
      <th>Pista</th>
      <th>Fecha</th>
      <th>Hora</th>
      <th>Material</th>
      <th>Términos</th>
    </tr>
    <?php foreach ($reservas as $reserva): ?>
      <tr>
        <td><?= htmlspecialchars($reserva["nombre"]) ?></td>
        <td><?= htmlspecialchars($reserva["email"]) ?></td>
        <td><?= htmlspecialchars($reserva["pista"]) ?></td>
        <td><?= htmlspecialchars($reserva["fecha"]) ?></td>
        <td><?= htmlspecialchars($reserva["hora"]) ?></td>
        <td>
          <?php foreach ($reserva["material"] as $material): ?>
            <span><?= htmlspecialchars($material) ?></span><br>
          <?php endforeach; ?>
        </td>
        <td><?= htmlspecialchars($reserva["terminos"]) ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
  <h3>Filtrar</h3>
  <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
    <legend>Pista</legend>
    <select name="pista" id="pista">
      <option value="padel-1">Pádel 1</option>
      <option value="padel-2">Pádel 2</option>
      <option value="tenis">Tenis</option>
      <option value="baloncesto">Baloncesto</option>
    </select>

    <br>
    <legend>Fecha</legend>
    <input type="date" name="fecha" id="fecha">

    <br>
    <button>Filtrar</button>
  </form>
</body>
</html>