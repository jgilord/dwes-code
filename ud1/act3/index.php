<?php
  include("functions.php");

  $coches = CSVtoArray("src/coches.csv", "matricula");
  $output = getMarkupFromCoches($coches);

  include("templates/coches.tpl.php");
?>