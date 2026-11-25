<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablero de colores</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            background: #eef1f5;
            color: #2c3e50;
            padding: 30px 15px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        header {
            background: #2c3e50;
            color: #fff;
            padding: 25px 30px;
        }
        header h1 { font-size: 1.6em; }
        header p  { opacity: 0.8; margin-top: 4px; }

        main {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 30px;
            padding: 30px;
        }
        @media (max-width: 760px) {
            main { grid-template-columns: 1fr; }
        }

        h2 {
            font-size: 1.1em;
            margin-bottom: 15px;
            padding-bottom: 6px;
            border-bottom: 2px solid #eef1f5;
        }

        /* ---------- Mensajes ---------- */
        .mensaje {
            margin: 20px 30px 0;
            padding: 12px 16px;
            border-radius: 8px;
            font-weight: 500;
        }
        .mensaje.ok    { background: #e8f8ef; color: #1e8449; border-left: 4px solid #27ae60; }
        .mensaje.error { background: #fdecea; color: #b03a2e; border-left: 4px solid #e74c3c; }

        /* ---------- Formularios ---------- */
        .campo { margin-bottom: 14px; }
        .campo label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .campo input,
        .campo select {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccd3db;
            border-radius: 6px;
            font-size: 1em;
        }
        .campo.con-error input,
        .campo.con-error select { border-color: #e74c3c; }
        .campo .error {
            display: block;
            color: #e74c3c;
            font-size: 0.85em;
            margin-top: 4px;
        }

        .botones { display: flex; gap: 10px; flex-wrap: wrap; }
        button {
            padding: 9px 16px;
            border: none;
            border-radius: 6px;
            font-size: 0.95em;
            font-weight: 600;
            cursor: pointer;
            color: #fff;
        }
        .btn-pintar    { background: #2980b9; }
        .btn-borrar    { background: #7f8c8d; }
        .btn-reiniciar { background: #c0392b; }
        .btn-deshacer  { background: #8e44ad; }
        button:hover   { filter: brightness(1.1); }

        .acciones { margin-top: 25px; display: flex; gap: 10px; flex-wrap: wrap; }

        /* ---------- Tablero ---------- */
        .tablero { border-collapse: collapse; margin: 0 auto; }
        .tablero th {
            width: 50px;
            height: 30px;
            font-size: 0.85em;
            color: #7f8c8d;
        }
        .tablero td.casilla {
            width: 50px;
            height: 50px;
            border: 1px solid #d5dbe1;
            background: #fafbfc;
        }

        /* Un color de la paleta = una clase */
        .c-rojo     { background: #e74c3c !important; }
        .c-azul     { background: #3498db !important; }
        .c-verde    { background: #2ecc71 !important; }
        .c-amarillo { background: #f1c40f !important; }
        .c-morado   { background: #9b59b6 !important; }
        .c-naranja  { background: #e67e22 !important; }

        /* ---------- Estadísticas ---------- */
        .estadisticas { margin-top: 30px; }
        .resumen { margin-bottom: 10px; }
        .recuento { list-style: none; display: flex; flex-wrap: wrap; gap: 10px; }
        .recuento li {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 5px 10px;
            background: #f4f6f8;
            border-radius: 20px;
            font-size: 0.9em;
        }
        .muestra {
            display: inline-block;
            width: 14px;
            height: 14px;
            border-radius: 50%;
        }

        footer {
            background: #f4f6f8;
            text-align: center;
            padding: 12px;
            font-size: 0.85em;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
<div class="container">

    <header>
        <h1>Tablero de colores</h1>
        <p>Desarrollo Web en Entorno Servidor · Sesiones en PHP</p>
    </header>

    <!-- MENSAJES: se muestra como mucho uno, según el resultado de la última acción -->
    <?php if (isset($flashMsg) && isset($flashMsg["success"])): ?>
      <p class="mensaje ok"><?= htmlspecialchars($flashMsg["success"]) ?></p>
    <?php endif; ?>

    <?php if (isset($accionValidada) && isset($accionValidada['errors']["general"]) && $accionValidada['errors']["general"]): ?>
      <p class="mensaje error">No se ha podido realizar la acción. Revisa los datos.</p>
    <?php endif; ?>

    <main>

        <!-- ==================== COLUMNA IZQUIERDA ==================== -->
        <section>
            <h2>Pintar o borrar casilla</h2>

            <form method="post" action="index.php" novalidate>

                <div class="campo
                  <?= (isset($accionValidada) && isset($accionValidada['errors']["row"]) && $accionValidada['errors']["row"]) ? "con-error" : "" ?>
                ">
                    <label for="fila">Fila (1-<?= htmlspecialchars($numFilas??0) ?>) </label>
                    <input type="number" id="fila" name="fila" value="<?= $accionValidada['fila']??"" ?>">
                    <?php if (isset($accionValidada) && isset($accionValidada['errors']["row"]) && $accionValidada['errors']["row"]): ?>
                      <span class="error">La fila debe ser un número entre 1 y <?= htmlspecialchars($numFilas??0) ?>.</span>
                    <?php endif; ?>
                </div>

                <!-- Ejemplo de campo con error: clase con-error + span.error -->
                <div class="campo
                  <?= (isset($accionValidada) && isset($accionValidada['errors']["col"]) && $accionValidada['errors']["col"]) ? "con-error" : "" ?>
                ">
                    <label for="columna">Columna (1-<?= htmlspecialchars($numCol??0) ?>)</label>
                    <input type="number" id="columna" name="columna" value="<?= $accionValidada['columna']??"" ?>">
                    <?php if (isset($accionValidada) && isset($accionValidada['errors']["col"]) && $accionValidada['errors']["col"]): ?>
                      <span class="error">La columna debe ser un número entre 1 y <?= htmlspecialchars($numFilas??0) ?>.</span>
                    <?php endif; ?>
                </div>

                <div class="campo
                  <?= (isset($accionValidada) && isset($accionValidada['errors']["color"]) && $accionValidada['errors']["color"]) ? "con-error" : "" ?>
                ">
                    <label for="color">Color</label>
                    <select id="color" name="color">
                        <option value="null">-- Elige un color --</option>
                        <?php if (constant("PALETA")): ?>
                          <?php foreach (constant("PALETA") as $key => $value): ?>
                            <option value="<?= htmlspecialchars($key) ?>" <?= isset($accionValidada) && $accionValidada["color"] === $key ? "selected" : "" ?>><?= htmlspecialchars($value) ?></option>
                          <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <?php if (isset($accionValidada) && isset($accionValidada['errors']["color"]) && $accionValidada['errors']["color"]): ?>
                      <span class="error">El color a pintar debe ser válido.</span>
                    <?php endif; ?>
                </div>

                <div class="botones">
                    <button type="submit" name="accion" value="pintar" class="btn-pintar">Pintar</button>
                    <button type="submit" name="accion" value="borrar" class="btn-borrar">Borrar casilla</button>
                </div>
            </form>

            <div class="acciones">
                <form method="post" action="index.php">
                    <button type="submit" name="accion" value="reiniciar" class="btn-reiniciar">Reiniciar tablero</button>
                </form>

                <!-- AMPLIACIÓN -->
                <form method="post" action="index.php">
                    <button type="submit" name="accion" value="deshacer" class="btn-deshacer">Deshacer</button>
                </form>
            </div>
        </section>

        <!-- ==================== COLUMNA DERECHA ==================== -->
        <section>
            <h2>Tablero</h2>

            <table class="tablero">
                <tr>
                    <th></th>
                    <?php if (isset($tablero) && isset($tablero[0]) && !empty($tablero[0])): ?>
                      <?php for ($i=0; $i < count($tablero[0])??6 ; $i++): ?>
                        <th><?= $i+1 ?></th>
                      <?php endfor; ?>
                    <?php endif; ?>
                </tr>

                <?php if (isset($tablero) && !empty($tablero)): ?>
                  <?php for ($i=0; $i < count($tablero)??6 ; $i++): ?>
                    <tr>
                      <th><?= $i+1 ?></th>
                      <?php if (isset($tablero[$i]) && !empty($tablero[$i])): ?>
                        <?php for ($j=0; $j < count($tablero[$i])??6 ; $j++): ?>
                          <td class="casilla <?= isset($tablero[$i][$j]) ? "c-".$tablero[$i][$j] : "" ?>"></td>
                        <?php endfor; ?>
                      <?php endif; ?>
                    </tr>
                  <?php endfor; ?>
                <?php endif; ?>
            </table>

            <?php if (isset($stats)): ?>
              <div class="estadisticas">
                  <h2>Estadísticas</h2>
                  <p class="resumen">Casillas pintadas: <strong><?= htmlspecialchars($stats["casillasPintadas"]??0) ?> de <?= htmlspecialchars($stats["casillasTotales"]??0) ?></strong> (<?= htmlspecialchars($stats["progreso"]??0) ?> %)</p>
                  <?php if ($stats["casillasPintadas"] > 0): ?>
                    <ul class="recuento">
                      
                        <?php foreach ($stats["casillasPintadasPorColor"] as $key => $value): ?>
                          <li><span style="text-transform: uppercase;" class="muestra <?= "c-".$key ?>"></span><?= $key ?>: <?= $value ?></li>
                        <?php endforeach; ?>
                    </ul>
                  <?php endif; ?>
              </div>
            <?php endif; ?>
        </section>

    </main>

    <footer>Examen DWES · Curso 2026/2027</footer>
</div>
</body>
</html>
