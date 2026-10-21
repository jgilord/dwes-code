<?php
	// Dump funtion
	function dump($dump) {
		echo "<pre>".$dump."</pre>";
	}
  
  include("../functions.php");

	dump(print_r(CSVtoArray("src/coches.csv", "matricula"), true));
?>