<?php

//načteme připojení k databázi
require_once 'inc/db.php';

$errors = [];
if (!empty($_GET)) {
    if (!empty($_GET['quiz_id'])) {

        $quizQuery = $db->prepare('SELECT quizzes.* FROM quizzes WHERE quizzes.quiz_id=:quiz_id LIMIT 1;');
        $quizQuery->execute([
            ':quiz_id' => $_GET['quiz_id']
        ]);
        if ($quizQuery->rowCount() == 0) {
            $errors['quiz_id'] = 'Zvolený kvíz neexistuje!';
            $_GET['quiz_id'] = '';
        }
    } else {
        $errors['quiz_id'] = 'Musíte vybrat kvíz.';
    }
}
?>
<!DOCTYPE html>
<html lang="cs">

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
                        <h1>Přidat otázku a odpovědi</h1>
                        <form method="POST" action="php/edit-quiz.php">
                        <input type="hidden" id="quiz_id" name="quiz_id" value="<?= $_GET['quiz_id']; ?>">
                            <div class="item-box">
                                <label for="question">*Otázka</label>
                                <input type="text" id="question" name="question" required="">
                            </div>
                            <hr>
                            <div class="item-box">
                                <label for="answer1">*Odpověď1:</label>
                                <input type="text" id="answer1" name="answer1" required="">
                                <select name="answer1_correct" id="answer1_correct" required class="form-control">
                                    <option value="0">Špatně</option>
                                    <option value="1">Správně</option>
                                </select>
                            </div>
                            <hr>
                            <div class="item-box">
                                <label for="answer2">*Odpověď2:</label>
                                <input type="text" id="answer2" name="answer2" required="">
                                <select name="answer1_correct" id="answer1_correct" required class="form-control">
                                    <option value="0">Špatně</option>
                                    <option value="1">Správně</option>
                                </select>
                            </div>
                            <hr>
                            <div class="item-box">
                                <label for="answer3">Odpověď3:</label>
                                <input type="text" id="answer3" name="answer2">
                                <select name="answer1_correct" id="answer1_correct" class="form-control">
                                    <option value="0">Špatně</option>
                                    <option value="1">Správně</option>
                                </select>
                            </div>
                            <hr>
                            <div class="item-box">
                                <label for="answer1">Odpověď4:</label>
                                <input type="text" id="answer3" name="answer1">
                                <select name="answer1_correct" id="answer1_correct" class="form-control">
                                    <option value="0">Špatně</option>
                                    <option value="1">Správně</option>
                                </select>
                            </div>
                            <hr>
                            <button type="submit" id="submit">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                Upravit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>