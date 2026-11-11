<?php
include_once("../src/functions.php");

session_start();

// Forzar FlashMsg
// saveFlashMessage("Registro completado. Ya puedes iniciar sesión.");

$flashMessages = readFlashMessages();
$pdo = getConnectionFromDDBB();

if (getUserFromSession() !== null) {
  header("Location: ../bienvenida/");
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
  $usuarioValidado = getValidatedLoginUser();
  if (isset($usuarioValidado) && $usuarioValidado["valid"]) {
    $res = getLoggedUserDDBB($pdo, $usuarioValidado);
    if ($res) {
      saveUserInSession($res);
      saveFlashMessage("Inicio de sesión completado de forma correcta!");
      header("Location: ../bienvenida/");
    } else {
      $usuarioValidado["valid"] = false;
      $usuarioValidado["errors"][] = "Email o contraseña incorrectos.";
    }
  }
}

include_once("../src/templates/login.tpl.php");
?>