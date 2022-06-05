<?php

//načteme připojení k databázi
require_once '../inc/db.php';
$errors = [];
if (!empty($_POST)) {
    if (!empty($_POST['quiz_id'])) {
        $quizQuery = $db->prepare('DELETE FROM quizzes WHERE quiz_id=:quiz_id;');
        $quizQuery->execute([
            ':quiz_id' => $_POST['quiz_id']
        ]);
        
    } else {
        $errors['quiz_id'] = 'Musíte vybrat kvíz.';
    }
}

if(empty($error)){
    echo 'Kvíz úspěšně smazán.';
  
}

header( "refresh:1; url=../custom-quiz.php" ); 

