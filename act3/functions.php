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
				$imagen = htmlspecialchars($value["imagen"]);
			} else {
				$imagen = "https://img.magnific.com/vector-premium/silueta-negra-automovil_606479-557.jpg";
			}

			$res .= '
				<div class="coche">
					<img src="'.htmlspecialchars($imagen).'" alt="">
					<h2>'.htmlspecialchars($value["marca"]).' '.htmlspecialchars($value["modelo"]).'</h2>
					<ul>
						<li>Marca: '.htmlspecialchars($value["marca"]).'</li>
						<li>Color: '.htmlspecialchars($value["color"]).'</li>
						<li>Matricula: '.htmlspecialchars($value["matricula"]).'</li>
					</ul>
				</div>
			';
		}

		return $res;
	}

?>