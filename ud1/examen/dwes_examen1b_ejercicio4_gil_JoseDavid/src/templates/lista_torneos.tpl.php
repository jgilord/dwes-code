<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Torneos de eSports</title>
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
        <p>Clasificación de los jugadores inscritos en cada torneo</p>
    </header>

    <main>
      <?php foreach ($tournamentsAndPlayersData as $torneo): ?>
        <section>
            <h2><?= htmlspecialchars($torneo["nombre"]) ?> <small>(<?= htmlspecialchars($torneo["juego"]) ?>)</small></h2>
            <a href="./?op=actualizar_puntos&id=<?= htmlspecialchars($torneo["id"]) ?>"><button>Actualizar puntos torneo</button></a>
            <table>
                <thead>
                    <tr>
                        <th>Jugador</th>
                        <th>Puntos</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                  <?php foreach ($torneo["playersData"] as $player): ?>
                    <tr>
                        <td><?= htmlspecialchars($player["nick"]) ?></td>
                        <td><?= htmlspecialchars($player["puntos"]) ?></td>
                        <td><a href="./?op=borrar_jugador&id=<?= htmlspecialchars($player["id"]) ?>"><button>Eliminar</button></a></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
            </table>
        </section>
      <?php endforeach; ?>
    </main>

    <footer>
        <p>DWES - Examen 1B - Ejercicio 1</p>
    </footer>
</body>
</html>
