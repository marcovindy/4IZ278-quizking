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
        
    } else {
        $errors['answer_id'] = 'Musíte vybrat odpoved.';
    }
}

if(empty($errors)){
    echo 'Opověď úspěšně smazána.';
  
}

foreach ($errors as $error) {
    echo $error;
}

header( "refresh:2; url=../custom-quiz.php" ); 

