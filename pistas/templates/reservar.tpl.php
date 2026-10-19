<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Práctica: reserva de pistas deportivas</title>
  <!-- <link rel="stylesheet" href="public/style.css"> -->
  <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
  <style>
    pre {
      min-height: 24rem;
    }
  </style>
</head>
<body>
  <h1>Reserva de pista</h1>
  <?php if ($request && !empty($errors)): ?>
    <p class="notice" style=" background-color: red;">Errores: <?php echo join(", ",$errors) ?></p>
  <?php endif ?>
  <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <legend>Nombre</legend>
    <input type="text" name="nombre" id="nombre" required value="<?= htmlspecialchars($reserva["nombre"] ?? "") ?>">

    <br>
    <legend>Email</legend>
    <input type="email" name="email" id="email" value="<?= htmlspecialchars($reserva["email"] ?? "") ?>">

    <br>
    <legend>Pista</legend>
    <select name="pista" id="pista">
      <?php foreach ($pistas as $clave => $valor): ?>
        <option value="<?= htmlspecialchars($clave) ?>" <?php echo(isset($reserva["pista"]) && $reserva["pista"] === $clave ? "selected" : "") ?>>
          <?= htmlspecialchars($valor) ?>
        </option>
      <?php endforeach; ?>
    </select>

    <br>
    <legend>Fecha</legend>
    <input type="date" name="fecha" id="fecha" value="<?= htmlspecialchars($reserva["fecha"] ?? $curDateFormated) ?>" min="<?= $curDateFormated ?>" max="<?= $maxDateFormated ?>">

    <br>
    <legend>Hora</legend>
    <?php foreach ($horas as $hora): ?>
    <input
      type="radio"
      id="hora-<?=htmlspecialchars($hora)?>"
      name="hora"
      value="<?=htmlspecialchars($hora)?>"
      <?php echo(isset($reserva["hora"]) && $reserva["hora"] === $hora ? "checked" : "") ?>
    >
    <label for="hora-<?=htmlspecialchars($hora)?>"><?=htmlspecialchars($hora)?></label>
    <?php endforeach; ?>

    <br>
    <legend>Material</legend>
      <?php foreach ($materiales as $clave => $valor): ?>
      <input
        type="checkbox"
        id="material-<?= htmlspecialchars($clave) ?>"
        name="material[]"
        value="<?= htmlspecialchars($clave) ?>"
        <?php echo(in_array($clave, $reserva["material"] ?? []) ? "checked" : "") ?>
      >
      <label for="material-<?= htmlspecialchars($clave) ?>"><?= htmlspecialchars($valor) ?></label>
    <?php endforeach; ?>

    <br>
    <legend>Términos y condiciones</legend>
    <input required type="checkbox" id="terminos" name="terminos" <?php echo(isset($reserva["terminos"]) && $reserva["terminos"] ? "checked" : "") ?>>
    <label for="terminos">Acepto los términos</label>

    <br>
    <br>
    <button type="submit">✔ Reservar</button>
  </form>
  <a href="../"><button>🡠 Volver a la lista de reservas</button></a>
</body>
</html>