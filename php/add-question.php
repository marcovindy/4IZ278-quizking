<?php

//načteme připojení k databázi
require_once '../inc/db.php';

if (!empty($_POST['quiz_id'])) {
    $quizId = $_POST['quiz_id'];
    $question = trim(@$_POST['question']);

    if (!empty($question)) {
        $query = $db->prepare('INSERT INTO questions (question_quiz_id, question_question) VALUES (:question_quiz_id, :question_question);');
        $query->execute([
            ':question_quiz_id' => $quizId,
            ':question_question' => $question
        ]);
        echo "Otákza úspěšně vytvořena.";
        header("refresh:2; url=../custom-edit.php?quiz_id=".$quizId);
        exit();
    } else {
        echo "Otákza nemůže být prázdná!";
        header("refresh:2; url=../custom-edit.php?quiz_id=".$quizId);
        exit();
    }
   
} else {
    echo "Musíte vybrat kvíz.";
    header("refresh:2; url=../custom-edit.php");
    exit();
}
