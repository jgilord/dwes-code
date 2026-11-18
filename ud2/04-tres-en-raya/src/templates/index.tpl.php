<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tres en raya</title>
  <link rel="stylesheet" href="https://cdn.simplecss.org/simple.css">
  <style>
    h5, h3, p {
      margin: 0;
    }
    pre {
      min-height: 200px;
    }
    .notice {
      margin: 1rem 0;
    }
    p {
      margin-bottom: 1rem;
    }

    body {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .notice-succes {
      background-color: #254515;
    }

    .tablero {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      grid-template-rows: repeat(3, 1fr);
      width: 200px;
      height: 200px;
      border-radius: 1rem;
      overflow: hidden;
      outline: 1px solid white;
    }

    .casilla {
      color: white;
      background-color: transparent;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 0;
      margin: 0;
      padding: 0;
      border-radius: 0;
      outline: 1px solid white;
      transition: 0.1s;
      &:hover {
        background-color: red;
        color: black;
      }
    }
  </style>
</head>
<body>
  <h1>Tres en raya</h1>

  <?php if(isset($match)): ?>
    <h3>Turno de <?= htmlspecialchars($match["currentPlayer"]??"X") ?></h3>
    <p>Selecciona una casilla</p>
    <form class="tablero" method="POST">
      <!-- <button type="submit" name="casilla" value="0-0" class="casilla"></button> -->
      <?php foreach($match["board"] as $iFila => $filasTablero): ?>
        <?php foreach($filasTablero as $iCol => $casilla): ?>
          <button type="submit" name="casilla" value="<?= htmlspecialchars($iFila) ?>-<?= htmlspecialchars($iCol) ?>" class="casilla">
            <?= htmlspecialchars($casilla) ?>
          </button>
        <?php endforeach; ?>
      <?php endforeach; ?>
    </form>
  <?php endif; ?>
  <br><br>
  <button>Reiniciar</button>
</body>
</html>