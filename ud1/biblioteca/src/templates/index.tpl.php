<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Biblioteca de Libros</title>
  <link rel="stylesheet" href="https://unpkg.com/simpledotcss/simple.css">
  <style>
    pre {
      min-height: 300px;
    }
  </style>
</head>
<body>
  <h1>Biblioteca de Libros</h1>
  <form method="GET">
    <legend>Genero</legend>
    <select name="genero" id="genero">
      <option value="">Ninguno</option>
      <?php foreach (GENEROS_VALIDOS as $genero): ?>
        <option value=<?= htmlspecialchars($genero)?>><?= htmlspecialchars($genero)?></option>
      <?php endforeach; ?>
    </select>
    <input type="submit" value="Enviar">
  </form>
  <table>
    <tr>
      <th>ID</th>
      <th>ISBN</th>
      <th>Titulo</th>
      <th>Autor</th>
      <th>Año</th>
      <th>Genero</th>
      <th>Disponibilidad</th>
    </tr>
    <?php foreach ($libros as $libro): ?>
      <tr>
        <?php foreach ($libro as $campo => $valor): ?>
          <?php if ($campo !== "disponible"): ?>
            <td><?= htmlspecialchars($valor) ?></td>
          <?php else: ?>
            <td><?= htmlspecialchars($valor ? "Disponible" : "Prestado") ?></td>
          <?php endif; ?>
        <?php endforeach; ?>
      </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>