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
        <option 
          value=<?= htmlspecialchars($genero)?>
          <?= isset($generoValidadoGET) && $generoValidadoGET === $genero ? "selected" : "" ?>
        >
          <?= htmlspecialchars($genero)?>
        </option>
      <?php endforeach; ?>
    </select>
    <input type="submit" value="Enviar">
  </form>
  <?php if (isset($libros) && count($libros) > 0): ?>
    <table>
      <tr>
        <th>ID</th>
        <th>ISBN</th>
        <th>Titulo</th>
        <th>Autor</th>
        <th>Año</th>
        <th>Genero</th>
        <th>Disponibilidad</th>
        <th>Acción</th>
        <th>Eliminar</th>
      </tr>
      <?php foreach ($libros as $libro): ?>
        <tr>
          <?php foreach ($libro as $campo => $valor): ?>
            <?php if ($campo === "disponible"): ?>
              <td><?= htmlspecialchars($valor ? "Disponible" : "Prestado") ?></td>
            <?php elseif ($campo === "titulo"): ?>
              <td><a href="./ficha?id=<?= htmlspecialchars($libro["id"]) ?>"><?= htmlspecialchars($valor) ?></a></td>
            <?php else: ?>
              <td><?= htmlspecialchars($valor) ?></td>
            <?php endif; ?>
          <?php endforeach; ?>
          <td>
            <form method="POST">
              <input type="hidden" name="id" value="<?= htmlspecialchars($libro["id"]) ?>">
              <input type="hidden" name="accion" value=<?= htmlspecialchars($valor ? "prestar" : "devolver") ?>>
              <button type="submit"><?= htmlspecialchars($valor ? "Prestar" : "Devolver") ?></button>
            </form>
          </td>
          <td>
            <form method="POST">
              <input type="hidden" name="id" value="<?= htmlspecialchars($libro["id"]) ?>">
              <input type="hidden" name="accion" value="borrar">
              <button type="submit">❌</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  <?php else: ?>
    <span style="font-style: italic;">No hay libros para mostrar</span>
  <?php endif; ?>
  <a href="./nuevo"><button>Registrar nuevo Libro</button></a>
</body>
</html>