<?php

//načteme připojení k databázi
require_once '../inc/db.php';

if (!empty($_POST)) {
    $quizId = $_POST['quiz_id'];
    $questionId = $_POST['question_id'];
    $answer = trim(@$_POST['answer']);
    $answerCorrect = $_POST['answer_correct'];

    if (!empty($answer)) {
        $query = $db->prepare('INSERT INTO answers (question_id, answer_answer, answer_correct) VALUES (:question_id, :answer, :answer_correct);');
        $query->execute([
            ':question_id' => $questionId,
            ':answer' => $answer,
            ':answer_correct' => $answerCorrect
        ]);
        echo "Odpověď úspěšně vytvořena.";
        header("refresh:2; url=../custom-edit.php?quiz_id=".$quizId);
        exit();
    } else {
        echo "Odpověď nemůže být prázdná!";
        header("refresh:2; url=../custom-edit.php?quiz_id=".$quizId);
        exit();
    } 
}else {
    echo "Nepovedlo se vytvořit odpověď.";
    header("refresh:2; url=../custom-edit.php?quiz_id=".$quizId);
    exit();
}
