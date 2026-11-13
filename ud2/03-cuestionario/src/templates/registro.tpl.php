<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Sesiones: Registro</title>
  <link rel="stylesheet" href="https://cdn.simplecss.org/simple.css">
  <style>
    h5 {
      margin: 0;
    }
    pre {
      min-height: 200px;
    }
  </style>
</head>
<body>
  <div style="display: flex; justify-content: space-between; align-items: center;">
    <h1>Registro</h1>
    <div>
      <a href="../registro/"><button>Registro</button></a>
      <a href="../login/"><button>Iniciar Sesión</button></a>
    </div>
  </div>
  <?php if (isset($usuarioValidado["errors"]) && count($usuarioValidado["errors"]) > 0): ?>
    <h5>No se ha podido completar el registro:</h5>
    <ul>
      <?php foreach ($usuarioValidado["errors"] as $error): ?>
        <li><?= htmlspecialchars($error) ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
  <form action="" method="post">
    <fieldset>
    <label for="name">Nombre</label>
    <input type="text" id="name" name="name" placeholder="Joseda" value="<?= $usuarioValidado["name"] ?? "" ?>">

    <label for="email">Email</label>
    <input type="text" id="email" name="email" placeholder="joseda@joseda.com.es" value="<?= $usuarioValidado["email"] ?? "" ?>">

    <label for="passwd">Contraseña</label>
    <input type="password" id="passwd" name="passwd" placeholder="Contraseña">

    <label for="passwdConfirm">Repetir Contraseña</label>
    <input type="password" id="passwdConfirm" name="passwdConfirm" placeholder="Contraseña">
    <br>
    <br>
    <input type="submit" value="Registrarse" name="register">
    </fieldset>
  </form>
</body>
</html>