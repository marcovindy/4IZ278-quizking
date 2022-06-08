<?php

//načteme připojení k databázi
require_once '../inc/db.php';
$errors = [];
if (!empty($_GET)) {
    if (!empty($_GET['answer_id'])) {
        $quizQuery = $db->prepare('DELETE FROM answers WHERE answer_id=:answer_id;');
        $quizQuery->execute([
            ':answer_id' => ($_GET['answer_id'])
        ]);
        if (!empty($_GET['quiz_id'])) {
            $quizId = $_GET['quiz_id'];
            $query = $db->prepare('UPDATE quizzes SET quiz_correct=0 WHERE quiz_id='.$_GET["quiz_id"].';');
            $query->execute();
        }
    } else {
        $errors['answer_id'] = 'Musíte vybrat odpoved.';
    }
}

if (empty($errors)) {
    echo 'Opověď úspěšně smazána.';
}

foreach ($errors as $error) {
    echo $error;
}
if (!empty($_GET['quiz_id']) && !empty($_GET['answer_id'])) {
    header("refresh:2; url=../custom-edit.php?quiz_id=" . $quizId);
} else {
    header("refresh:2; url=../custom-quiz.php");
}
