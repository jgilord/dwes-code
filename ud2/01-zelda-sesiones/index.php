<?php
	include("./functions.php");

	setupSesion();

	$stage = CSVtoBoard("public/stage.csv");
	checkNextLinkPosAndUpdate($stage);

	$linkPos = getLinkPos();
	$boardContent = getBoardMarkup($stage);

	include("templates/zelda.tpl.php");
?>