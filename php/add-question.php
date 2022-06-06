<?php

//načteme připojení k databázi
require_once '../inc/db.php';

$errors = [];
if (!empty($_POST)) {
    $quizId = $_POST['quiz_id'];
    $question = $_POST['question'];

    if (!empty($question)){
        $query = $db->prepare('INSERT INTO questions (question_quiz_id, question_question) VALUES (:question_quiz_id, :question_question);');
        $query->execute([
            ':question_quiz_id' => $quizId,
            ':question_question' => $question
        ]);
        $url = "Location: ../custom-edit.php?quiz_id=";
        $url .= $quizId;
        header($url);
        exit();
    }
}
