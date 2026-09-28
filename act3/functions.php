<?php
	function CSVtoArray(String $CSVPath, String|null $index = null) {
		$archivoTextoPlano = file_get_contents($CSVPath);
		$lineasCSV = array_map("trim", explode("\n", $archivoTextoPlano));
		
		$cabeceraCSV = explode(",", array_shift($lineasCSV));

		$res = [];

		foreach ($lineasCSV as $linea) {
			$lineaSplited = explode(",", $linea);
			$objetoCombinado = array_combine($cabeceraCSV, $lineaSplited);

			if ($index !== null && isset($index, $cabeceraCSV)) {
				$res[$objetoCombinado[$index]] = $objetoCombinado;
			} else {
				$res[] = $objetoCombinado;
			}
		}


		return $res;
	}

	function getMarkupFromCoches(Array $data) {
		$res = "";
		
		foreach ($data as $key => $value) {
			if ($value["imagen"] !== "") {
				$imagen = $value["imagen"];
			} else {
				$imagen = "https://img.magnific.com/vector-premium/silueta-negra-automovil_606479-557.jpg";
			}

			$res .= '
				<div class="coche">
					<img src="'.$imagen.'" alt="">
					<h2>'.$value["marca"].' '.$value["modelo"].'</h2>
					<ul>
						<li>Marca: '.$value["marca"].'</li>
						<li>Color: '.$value["color"].'</li>
						<li>Matricula: '.$value["matricula"].'</li>
					</ul>
				</div>
			';
		}

		return $res;
	}

?>