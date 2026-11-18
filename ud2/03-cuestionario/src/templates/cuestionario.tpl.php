<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Sesiones: Login</title>
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

    h4, h5 {
      margin: 0;
    }

    h4 {
      margin-bottom: 0.5rem;
    }
  </style>
</head>
<body>
  <div style="display: flex; justify-content: space-between; align-items: center;">
    <h1>Cuestionario</h1>
    <div>
      <a href="../logout/"><button>Cerrar Sesión</button></a>
    </div>
  </div>

  <h4>Pregunta <?= htmlspecialchars($questions["current"]+1 ?? "0") ?>/<?= htmlspecialchars($questions["total"] ?? "0") ?></h4>
  
  <form method="post">
    <h5><?= htmlspecialchars($currentQuestionData["enunciado"] ?? "Enunciado") ?><h5>
    <input type="hidden" name="question" value="<?= $questions["current"] ?>">

    <input type="radio" id="question-1" name="answer" value="A" <?= $currentQuestion["answer"] === "A" ? "checked" : "" ?>>
    <label for="question-1">
      <?= htmlspecialchars($currentQuestionData["opcion_a"] ?? "Opción A") ?>
    </label><br>

    <input type="radio" id="question-2" name="answer" value="B" <?= $currentQuestion["answer"] === "B" ? "checked" : "" ?>>
    <label for="question-2">
      <?= htmlspecialchars($currentQuestionData["opcion_b"] ?? "Opción B") ?>
    </label><br>

    <input type="radio" id="question-3" name="answer" value="C" <?= $currentQuestion["answer"] === "C" ? "checked" : "" ?>>
    <label for="question-3">
      <?= htmlspecialchars($currentQuestionData["opcion_c"] ?? "Opción C") ?>
    </label><br>

    <input type="radio" id="question-4" name="answer" value="D" <?= $currentQuestion["answer"] === "D" ? "checked" : "" ?>>
    <label for="question-4">
      <?= htmlspecialchars($currentQuestionData["opcion_d"] ?? "Opción D") ?>
    </label><br><br>

    <!-- <button type="submit" name="action" value="answer">Enviar</button> -->
    <div style="display: flex; justify-content: space-between; margin-top: 1rem;">
      <button type="submit" name="action" value="previous" <?= $questions["current"] > 0 ? "" : "disabled" ?>>🡠 Anterior</button>
      <?php if($questions["current"] < $questions["total"]-1): ?>
        <button type="submit" name="action" value="next">Siguiente 🡢</button>
      <?php else: ?>
        <button type="submit" name="action" value="submit">Enviar</button>
      <?php endif; ?>
    </div>
  </form>
</body>
</html>