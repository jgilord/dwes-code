<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Actividad 4 - TLOZ: PHP</title>
  <link rel="stylesheet" href="public/style.css">
</head>
<body>
  <header>
    <h1>TLOZ: PHP</h1>
  </header>
  <main>
    <div class="main-frame">
      <?php echo $boardContent??"" ?>
    </div>
    
    <form class="controls" method="POST">
      <?php if ($linkPos["x"] != 0): ?>
      <button id="control-up" name="next-link-pos" type="submit" class="control" value="<?php echo getNextLinkPosFormatted("up", $stage) ?>">🡱</button>
      <?php endif?>
      <?php if ($linkPos["x"] != 31): ?>
      <button id="control-down" name="next-link-pos" type="submit" class="control" value="<?php echo getNextLinkPosFormatted("down", $stage) ?>">🡳</button>
      <?php endif?>
      <?php if ($linkPos["y"] != 31): ?>
      <button id="control-rigth" name="next-link-pos" type="submit" class="control" value="<?php echo getNextLinkPosFormatted("rigth", $stage) ?>">🡲</button>
      <?php endif?>
      <?php if ($linkPos["y"] != 0): ?>
      <button id="control-left" name="next-link-pos" type="submit" class="control" value="<?php echo getNextLinkPosFormatted("left", $stage) ?>">🡰</button>
      <?php endif?>
    </f>
  </main>
  <script>
    // Extra solo para poder usar WASD o flechas, lo unico que hace es detectarlas y clickar en los botones
    const butonUp = document.getElementById('control-up');
    const butonDown = document.getElementById('control-down');
    const butonRigth = document.getElementById('control-rigth');
    const butonLeft = document.getElementById('control-left');

    document.addEventListener('keydown', (event) => {
      if (event.key === 'ArrowUp' || event.key === 'w') { 
        event.preventDefault();
        butonUp.click();
      }
      if (event.key === 'ArrowDown' || event.key === 's') { 
        event.preventDefault();
        butonDown.click();
      }
      if (event.key === 'ArrowRight' || event.key === 'd') { 
        event.preventDefault();
        butonRigth.click();
      }
      if (event.key === 'ArrowLeft' || event.key === 'a') { 
        event.preventDefault();
        butonLeft.click();
      }
    });
  </script>
</body>
</html>