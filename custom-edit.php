<?php

//načteme připojení k databázi
require_once 'inc/db.php';

$errors = [];
if (!empty($_POST)) {
    if (!empty($_POST['quiz_id'])) {

        $quizQuery = $db->prepare('SELECT quizzes.* FROM quizzes WHERE quizzes.quiz_id=:quiz_id LIMIT 1;');
        $quizQuery->execute([
            ':quiz_id' => $_POST['quiz_id']
        ]);
        if ($quizQuery->rowCount() == 0) {
            $errors['quiz_id'] = 'Zvolený kvíz neexistuje!';
            $_POST['quiz_id'] = '';
        }
    } else {
        $errors['quiz_id'] = 'Musíte vybrat kvíz.';
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
            <div class="card p-4">
                <div class="row">

                    <form method="post">


                        <button type="submit" class="btn btn-primary">uložit...</button>
                        <a href="index.php" class="btn btn-light">zrušit</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>