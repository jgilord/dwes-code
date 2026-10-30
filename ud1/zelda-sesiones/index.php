<?php
	include("./functions.php");

	setupSesion();

	// dump("Link Pos en SESSION");
	// dump(print_r($_SESSION["link_pos"], true));

	// dump("Link Pos");
	// dump(print_r(getLinkPos(), true));

	$stage = CSVtoBoard("public/stage.csv");
	$linkPos = getLinkPos();
	$boardContent = getBoardMarkup($stage);

	include("templates/zelda.tpl.php");
?>