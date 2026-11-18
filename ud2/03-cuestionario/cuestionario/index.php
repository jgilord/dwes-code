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

if ($_SERVER['REQUEST_METHOD'] === "POST") {
  $opcion = getAccionQuestValidadaPOST();
  $answeredQuestion = getAnswerQuestValidadaPOST($questions);

  if (isset($answeredQuestion)) {
    $questions["questionList"][$answeredQuestion["question"]]["answer"] = $answeredQuestion["answer"];
  }

  switch ($opcion) {
    case 'previous':
      if ($questions["current"] > 0) {
        $questions["current"]--;
      }
    break;
    
    case 'next':
      if ($questions["current"] < $questions["total"]-1) {
        $questions["current"]++;
      }
    break;

    case 'submit':
      dump("se envia");
    break;

    default:
    break;
  }

  updateQuestionsDataInSession($questions);
  // header("Location: ./");
}

$currentQuestion = $questions["questionList"][$questions["current"]];
$currentQuestionData = getQuestionByIdFromDDBB($pdo, $currentQuestion["idQuestion"]);

// dump(print_r($questions, true));
// dump(print_r($currentQuestionData, true));

include_once("../src/templates/cuestionario.tpl.php");
?>