<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ejemplo PDO</title>
</head>
<body>
  <ul>
    <?php 
      foreach ($familias as $fam) {
        echo getFamMarkup($fam);
      }
    ?>
  </ul>
</body>
</html>