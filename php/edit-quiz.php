<?php

//načteme připojení k databázi
require_once '../inc/db.php';

session_start();

$errors = [];

if (empty($_SESSION)) {
    $errors['user'] = 'Zde nemůžete, pokud nejste příhlášení.';
    header("Location: ../index.php");
    exit();
}

 if (!empty($_POST['category'])){

    $categoryQuery=$db->prepare('SELECT * FROM categories WHERE category_id=:category LIMIT 1;');
    $categoryQuery->execute([
        ':category'=>$_POST['category']
    ]);
    if ($categoryQuery->rowCount()==0){
        $errors['category']='Zvolená kategorie neexistuje!';
        $_POST['category']='0';
    }

}else{
    $errors['category']='Musíte vybrat kategorii.';
}

if (!empty($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    if (!empty($_POST)) {

        # zpracování formuláře

        $title = trim(@$_POST['quiz_title']);
        $cat = trim(@$_POST['category']);
        $_POST['quiz_id'];

        # kontrola názvu
        if (empty($title)) {
            $errors['quiz_title'] = 'Musíte název kvízu.';
        }

        if (empty($errors)) {
            $query = $db->prepare('UPDATE quizzes SET quiz_title="'.$title.'", quiz_category_id='.$cat.' WHERE quiz_id='.$_POST["quiz_id"].';');
         $query->execute();

            header("Location: ../custom-quiz.php");
            exit();
        }
    }
}
