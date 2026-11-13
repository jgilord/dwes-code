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

  <h4>Pregunta 1/5  </h4>
  
  <form method="post">
    <h5>¿Qué función de PHP se utiliza para iniciar una sesión o recuperar la existente?</h5>

    <input type="radio" id="question-1" name="respuesta" value="HTML">
    <label for="question-1">HTML</label><br>

    <input type="radio" id="question-2" name="respuesta" value="CSS">
    <label for="question-2">CSS</label><br>

    <input type="radio" id="question-3" name="respuesta" value="JavaScript">
    <label for="question-3">JavaScript</label>

    <input type="radio" id="question-4" name="respuesta" value="JavaScript">
    <label for="question-4">C++</label>
  </form>


  <form method="post">
    <button type="submit" name="to-cuestion" value="previous">🡠 Anterior</button>
    <button type="submit" name="to-cuestion" value="next">Siguiente 🡢</button>
  </form>
</body>
</html>