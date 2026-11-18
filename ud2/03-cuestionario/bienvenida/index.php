<?php
include_once("../src/functions.php");

session_start();

// Forzar FlashMsg
// saveFlashMessage("Inicio de sesión completado de forma correcta!");

$flashMessages = readFlashMessages();
$user = getUserFromSession();

if (!isset($user)) {
  header("Location: ../login/");
}

$cuestionario = getQuestionsDataFromSession();

include_once("../src/templates/bienvenida.tpl.php");
?>