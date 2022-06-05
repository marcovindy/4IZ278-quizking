<?php

//načteme připojení k databázi
require_once 'inc/db.php';

session_start();

$errors = [];

if (empty($_SESSION)) {
    $errors['user'] = 'Zde nemůžete, pokud nejste příhlášení.';
    header("refresh:3, Location: index.php");
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
            $errors['quiz_title'] = 'Musíte zadat název kvízu.';
        }

        if (empty($errors)) {

            $query = $db->prepare('INSERT INTO quizzes (quiz_title, quiz_user_id, quiz_category_id, quiz_price, quiz_verified) VALUES (:title, :userID, :category, 0, 0);');
            $query->execute([
                ':title' => $title,
                ':userID' => $userId,
                ':category' => $cat
            ]);

            header("refresh:3, Location: custom-quiz.php");
            $text="";
            if(empty($errors)){
                $text="Kvíz byl vytvořen";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Rezbar">
    <meta name="keywords" content="Rezbar, woodcurving, woodstatutes, wood, drevo, sochy, dekorace, motorovapila, motorovka">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Marek Vaníček">
    <title>QuizKing</title>
    <link rel="icon" href="img/favicon/favicon.ico" type="image/x-icon">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oleo+Script+Swash+Caps&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="assets/fontawesome/css/all.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>



</head>

<body>
    <?php require_once('inc/header.php'); ?>

    <?php require_once('inc/nav.php'); ?>

    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-8 col-sm-12">

                    <div class="form-box">
                      
                        <h1>
                    <?php 
                    foreach ($errors as $error){
                        echo $error;
                    }
                    ?>        
                    </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>