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
        
    } else {
        $errors['question_id'] = 'Musíte vybrat kvíz.';
    }
}

if(empty($errors)){
    echo 'Otázka úspěšně smazána.';
  
}

foreach ($errors as $error) {
    echo $error;
}

header( "refresh:2; url=../custom-quiz.php" ); 

