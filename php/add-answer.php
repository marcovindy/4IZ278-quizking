<?php

//načteme připojení k databázi
require_once '../inc/db.php';

$errors = [];
if (!empty($_POST)) {
    $quizId = $_POST['quiz_id'];
    $questionId = $_POST['question_id'];
    $answer = $_POST['answer'];
    $answerCorrect = $_POST['answer_correct'];

    if (!empty($answer)){
        $query = $db->prepare('INSERT INTO answers (question_id, answer_answer, answer_correct) VALUES (:question_id, :answer, :answer_correct);');
        $query->execute([
            ':question_id' => $questionId,
            ':answer' => $answer,
            ':answer_correct' => $answerCorrect
        ]);
        $url = "Location: ../custom-edit.php?quiz_id=";
        $url .= $quizId;
        header($url);
        exit();
    }
}
