<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Torneos de eSports: Actualizar Puntos</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
    <style>
      pre {
        min-height: 200px;
      }
    </style>
</head>
<body>
    <header>
        <h1>Torneos de eSports</h1>
        <p>Actualizar Puntos</p>
    </header>

    <main>
      <?php if (isset($idTorneo)): ?>
        <?php if (isset($nombreTorneo) && isset($juegoTorneo)): ?>
          <h2><?= htmlspecialchars($nombreTorneo) ?> <small>(<?= htmlspecialchars($juegoTorneo) ?>)</small></h2>
        <?php endif; ?>
      <form action="" method="POST">
        <input type="hidden" name="idTorneo" value="<?= htmlspecialchars($idTorneo) ?>" >
        <?php foreach($playersData as $player): ?>
          <legend><?= htmlspecialchars($player["nick"]) ?></legend>
          <input type="number" name="<?= htmlspecialchars($player["jugador_id"]) ?>" value="<?= htmlspecialchars($player["puntos"]) ?>">
        <?php endforeach; ?>
        <br>
        <br>
        <button type="submit">Actualizar Puntos de los Jugadores</button>
      </form>
      <?php else: ?>
        <span>Para actualizar los Puntos de los jugadores de un Torneo debes indica la ID en la URL</span>
      <?php endif; ?>
      <br>
      <br>
      <a href="./?op=lista_torneos"><button>Volver al listado</button></a>
    </main>

    <footer>
        <p>DWES - Examen 1B - Ejercicio 1</p>
    </footer>
</body>
</html>
