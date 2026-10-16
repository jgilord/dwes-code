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
    <p class="notice" style=" background-color: red;">Los siguiente campos no son válidos: <?php echo join(", ",$errors) ?></p>
  <?php endif ?>
  <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <legend>Nombre</legend>
    <input type="text" name="nombre" id="nombre" required>

    <br>
    <legend>Email</legend>
    <input type="email" name="email" id="email">

    <br>
    <legend>Pista</legend>
    <select name="pista" id="pista">
      <?php foreach ($pistas as $clave => $valor): ?>
        <option value="<?= htmlspecialchars($clave) ?>"><?= htmlspecialchars($valor) ?></option>
      <?php endforeach; ?>
    </select>

    <br>
    <legend>Fecha</legend>
    <input type="date" name="fecha" id="fecha" value="<?= $curDateFormated ?>" min="<?= $curDateFormated ?>" max="<?= $maxDateFormated ?>">

    <br>
    <legend>Hora</legend>
    <?php foreach ($horas as $hora): ?>
    <input type="radio" id="hora-<?=htmlspecialchars($hora)?>" name="hora" value="<?=htmlspecialchars($hora)?>">
    <label for="hora-<?=htmlspecialchars($hora)?>"><?=htmlspecialchars($hora)?></label>
    <?php endforeach; ?>

    <br>
    <legend>Material</legend>
      <?php foreach ($materiales as $clave => $valor): ?>
      <input type="checkbox" id="material-<?= htmlspecialchars($clave) ?>" name="material[]" value="<?= htmlspecialchars($clave) ?>">
      <label for="material-<?= htmlspecialchars($clave) ?>"><?= htmlspecialchars($valor) ?></label>
    <?php endforeach; ?>

    <br>
    <legend>Términos y condiciones</legend>
    <input type="checkbox" id="terminos" name="terminos">
    <label for="terminos">Acepto los términos</label>

    <br>
    <br>
    <button type="submit">✔ Reservar</button>
  </form>
  <a href="../"><button>🡠 Volver a la lista de reservas</button></a>
</body>
</html>