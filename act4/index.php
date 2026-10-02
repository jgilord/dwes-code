<!-- 1. Una cuadricula de 32x32 tiles -->
<!-- 2. Conseguir que la cuadricula tenga sprites -->

<!-- 3. Stage  -->

<?php
	include("functions.php");

	$stage = CSVtoBoard("public/stage.csv");
	$boardContent = getBoardMarkup($stage, getLinkPos());

	include("templates/zelda.tpl.php");
?>