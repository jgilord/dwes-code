<?php
include_once("../src/functions.php");

session_start();

$usuarioValidado = null;
$pdo = getConnectionFromDDBB();

if (getUserFromSession() !== null) {
  header("Location: ../bienvenida/");
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
  $usuarioValidado = getValidatedRegisterUser($pdo);
  if (isset($usuarioValidado) && $usuarioValidado["valid"]) {
    $res = registerUserDDBB($pdo, $usuarioValidado);
    if ($res) {
      saveFlashMessage("Registro completado. Ya puedes iniciar sesión.");
      header("Location: ../login/");
    }
  }
}

include_once("../src/templates/registro.tpl.php");
?>