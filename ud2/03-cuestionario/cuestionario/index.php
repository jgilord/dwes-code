<?php
include_once("../src/functions.php");

session_start();
$pdo = getConnectionFromDDBB();

$user = getUserFromSession();
if (!isset($user)) {
  header("Location: ../login/");
}

$questions = getQuestionsDataFromSession();
if (!isset($questions)) {
  $idPreguntas = getIDsPreguntasFromDDBB($pdo);
  $idPreguntasRandom = getIDsPreguntasRandom($idPreguntas, 5);

  $questions = saveQuestionsDataInSession($idPreguntasRandom);
}


dump(print_r($questions, true));


include_once("../src/templates/cuestionario.tpl.php");
?>