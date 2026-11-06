<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Acción de Libro</title>
  <link rel="stylesheet" href="https://unpkg.com/simpledotcss/simple.css">
  <style>
    h4 {
      margin: 0;
    }
  </style>
</head>
<body>
  <?php if (isset($accionValidada) && !$accionValidada["valido"]): ?>
    <h1>Acción de Libro</h1>
    <h4>Solicitud no válida. Errores: </h4>
    <ul>
      <?php foreach ($accionValidada["errores"] as $error): ?>
        <li>
          <?= htmlspecialchars($error)?>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <h1>Acción <?= htmlspecialchars($accionValidada["accion"])?> de Libro</h1>
  <?php endif; ?>

  <?php if (isset($resultado)): ?>
    <span style="font-style: italic;"><?= htmlspecialchars($resultado)?></span>
  <?php endif; ?>
  <br>
  <br>
  <a href="../"><button>Volver al listado de Libros</button></a>
</body>
</html>