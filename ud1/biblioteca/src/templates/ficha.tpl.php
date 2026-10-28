<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ficha de Libro</title>
  <link rel="stylesheet" href="https://unpkg.com/simpledotcss/simple.css">
</head>
<body>
  <h1>Ficha Libro</h1>
  <?php if (isset($libro) && $libro): ?>
    <table>
      <tr>
        <?php foreach (array_keys($libro) as $campo): ?>
          <th><?= htmlspecialchars($campo) ?></th>
        <?php endforeach; ?>
      </tr>
      <tr>
        <?php foreach ($libro as $campo => $valor): ?>
          <?php if ($campo !== "disponible"): ?>
            <td><?= htmlspecialchars($valor) ?></td>
          <?php else: ?>
            <td><?= htmlspecialchars($valor ? "Disponible" : "Prestado") ?></td>
          <?php endif; ?>
        <?php endforeach; ?>
      </tr>
    </table>
  <?php else: ?>
    <span style="font-style: italic;">Libro no encontrado</span>
  <?php endif; ?>
</body>
</html>