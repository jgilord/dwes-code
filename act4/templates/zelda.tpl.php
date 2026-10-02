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
    <div class="controls">
      <a href="<?php echo getNextLinkPosURL("up") ?>"><button class="control">🡱</button></a>
      <a href="<?php echo getNextLinkPosURL("down") ?>"><button class="control">🡳</button></a>
      <a href="<?php echo getNextLinkPosURL("rigth") ?>"><button class="control">🡲</button></a>
      <a href="<?php echo getNextLinkPosURL("left") ?>"><button class="control">🡰</button></a>
    </div>
  </main>
</body>
</html>