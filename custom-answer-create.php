<?php

//načteme připojení k databázi
require_once 'inc/db.php';

$errors = [];
if (!empty($_GET)) {
    if (!empty($_GET['question_id'])) {

        $quizQuery = $db->prepare('SELECT quizzes.* FROM quizzes WHERE quizzes.quiz_id=:quiz_id LIMIT 1;');
        $quizQuery->execute([
            ':quiz_id' => $_GET['quiz_id']
        ]);
        if ($quizQuery->rowCount() == 0) {
            $errors['quiz_id'] = 'Zvolená otázka neexistuje!';
            $_GET['quiz_id'] = '';
        }
    } else {
        $errors['quiz_id'] = 'Musíte vybrat otázku.';
    }
}
?>
<!DOCTYPE html>
<html lang="cs">

<head>
<meta charset="UTF-8">
    <meta name="description" content="Tohle je kvizova aplikace vytvorena pro VSE">
    <meta name="keywords" content="quiz, kviz, super, moc, husty, tagy">
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
                        <h1>Přidat odpověď</h1>
                        <form method="POST" action="php/add-answer.php">
                        <input type="hidden" id="question_id" name="question_id" value="<?= $_GET['question_id']; ?>">
                        <input type="hidden" id="quiz_id" name="quiz_id" value="<?= $_GET['quiz_id']; ?>">
                           
                            <div class="item-box">
                                <label for="answer">*Odpověď:</label>
                                <input type="text" id="answer" name="answer" required="">
                                <select name="answer_correct" id="answer_correct" required class="form-control">
                                    <option value="0">Špatně</option>
                                    <option value="1">Správně</option>
                                </select>
                            </div>
                           
                            <button type="submit" id="submit">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                Vytvořit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once('inc/footer.php'); ?>
</body>

</html>