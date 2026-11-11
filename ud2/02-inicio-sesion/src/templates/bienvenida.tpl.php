<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Sesiones: Bienvenida</title>
  <link rel="stylesheet" href="https://cdn.simplecss.org/simple.css">
  <style>
    h5 {
      margin: 0;
    }
    pre {
      min-height: 200px;
    }
    .notice {
      margin: 1rem 0;
    }

    .notice-succes {
      background-color: #254515;
    }
  </style>
</head>
<body>
  <div style="display: flex; justify-content: space-between; align-items: center;">
    <h1>Login Sesiones</h1>
    <div>
      <a href="../logout/"><button>Cerrar Sesión</button></a>
    </div>
  </div>
  <?php if (isset($flashMessages) && count($flashMessages) > 0): ?>
    <?php foreach ($flashMessages as $msg): ?>
      <p class="notice notice-succes"><?= htmlspecialchars($msg) ?></p>
    <?php endforeach; ?>
  <?php endif; ?>
  
  <h4>Bienvenido/a <?= htmlspecialchars($user["nombre"]) ?></h4>
</body>
</html>