<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Insertar nuevo Libro</title>
  <link rel="stylesheet" href="https://unpkg.com/simpledotcss/simple.css">
  <style>
    h4 {
      margin: 0;
    }
  </style>
</head>
<body>
  <h1>Insertar nuevo Libro</h1>
  <?php if (isset($libroValidado["valido"]) && !$libroValidado["valido"]): ?>
    <h4>Solicitud no válida. Errores: </h4>
    <ul>
      <?php foreach ($libroValidado["errores"] as $error): ?>
        <li>
          <?= htmlspecialchars($error)?>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
  <?php if (!isset($idLibroInsertado)): ?>
  <form method="POST">
    <legend>ISBN</legend>
    <input type="text" name="ISBN" value="<?= isset($libroValidado) ? htmlspecialchars($libroValidado["ISBN"]) : "" ?>">
    <legend>Título</legend>
    <input type="text" name="titulo" value="<?= isset($libroValidado) ? htmlspecialchars($libroValidado["titulo"]) : "" ?>">
    <legend>Autor</legend>
    <input type="text" name="autor" value="<?= isset($libroValidado) ? htmlspecialchars($libroValidado["autor"]) : "" ?>">
    <legend>Año</legend>
    <input type="number" name="anio" value="<?= isset($libroValidado) ? htmlspecialchars($libroValidado["anio"]) : "" ?>">
    <legend>Género</legend>
    <select name="genero" id="genero">
      <option value="">Ninguno</option>
      <?php foreach (GENEROS_VALIDOS as $genero): ?>
        <option 
          value=<?= htmlspecialchars($genero)?>
          <?= isset($libroValidado) && $libroValidado["genero"] === $genero ? "selected" : "" ?>
        >
          <?= htmlspecialchars($genero)?>
        </option>
      <?php endforeach; ?>
    </select>
    <legend>Enviar</legend>
    <button type="submit">Enviar</button>
  </form>
  <?php else: ?>
    <span style="font-style: italic;">Libro añadido con id <?= htmlspecialchars($idLibroInsertado)?></span>
  <?php endif; ?>
  <a href="../"><button>Volver al listado de Libros</button></a>
</body>
</html>