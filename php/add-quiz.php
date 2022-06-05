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

        # kontrola názvu
        if (empty($title)) {
            $errors['quiz_title'] = 'Musíte název kvízu.';
        }

        if (empty($errors)) {

            $query = $db->prepare('INSERT INTO quizzes (quiz_title, quiz_user_id, quiz_category_id, quiz_price, quiz_verified) VALUES (:title, :userID, :category, 0, 0);');
            $query->execute([
                ':title' => $title,
                ':userID' => $userId,
                ':category' => $cat
            ]);

            header("Location: ../custom-quiz.php");
            exit();
        }
    }
}

?>