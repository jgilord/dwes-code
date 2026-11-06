<?php 
  include_once("../src/functions.php");
  

  $accionValidada = getAccionValidadaPOST();
  $resultado = null;
  // dump(print_r(getAccionValidadaPOST(), true));

  if (isset($accionValidada) && $accionValidada["valido"]) {
    if ($accionValidada["accion"] === "borrar") {
      try {
        $resultado = borrarLibro($pdo, $accionValidada["id"]) > 0 ? "Libro eliminado" : "Ese libro no existe";
      } catch (Exception $e) {
        $resultado = $e->getMessage();
      }
    } else if (in_array($accionValidada["accion"], [""])) {

    }
  }
  

  include_once("../src/templates/accion.tpl.php");
?>