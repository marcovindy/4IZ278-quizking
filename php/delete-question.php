<?php

//načteme připojení k databázi
require_once '../inc/db.php';
$errors = [];
if (!empty($_GET)) {
    if (!empty($_GET['question_id'])) {
        $quizQuery = $db->prepare('DELETE FROM questions WHERE question_id=:question_id;');
        $quizQuery->execute([
            ':question_id' => ($_GET['question_id'])
        ]);
        if (!empty($_GET['quiz_id'])) {
            $quizId = $_GET['quiz_id'];
            $query = $db->prepare('UPDATE quizzes SET quiz_correct=0 WHERE quiz_id='.$_GET["quiz_id"].';');
            $query->execute();
        }
    } else {
        $errors['question_id'] = 'Musíte vybrat kvíz.';
    }
}

if (empty($errors)) {
    echo 'Otázka úspěšně smazána.';
}

foreach ($errors as $error) {
    echo $error;
}

if (!empty($_GET['question_id']) && !empty($_GET['quiz_id'])) {
    header("refresh:2; url=../custom-edit.php?quiz_id=" . $quizId);
} else {
    header("refresh:2; url=../custom-quiz.php");
}
