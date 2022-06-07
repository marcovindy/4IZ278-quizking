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
    } else if (!empty($_GET['quiz_id'])) {
        $_POST['quiz_id'] = $_GET['quiz_id'];
    } else {
        $errors['quiz_id'] = 'Není zvolený klíč!';
    }
} else if (!empty($_GET)) {
    if (!empty($_GET['quiz_id'])) {
        $_POST['quiz_id'] = $_GET['quiz_id'];
    }
}


$queryQuiz = 'SELECT
                       quizzes.*
                       FROM quizzes  WHERE quizzes.quiz_id="' . $_POST['quiz_id'] . '" LIMIT 1;';
$queryQuiz = $db->query($queryQuiz);
$quizzes = $queryQuiz->fetchAll(PDO::FETCH_ASSOC);


foreach ($quizzes as $quiz) {
    $quizTitle = $quiz['quiz_title'];
    $quizCategory = $quiz['quiz_category_id'];
}

$queryCat = 'SELECT categories.* FROM categories WHERE categories.category_id="'.$quizCategory.'" ;';
$queryCat = $db->query($queryCat);
$categoriesOfQuiz = $queryCat->fetchAll(PDO::FETCH_ASSOC);
foreach ($categoriesOfQuiz as $categoryOfQuiz) {
    $categorySelected = $categoryOfQuiz['category_name'];
}


$query = 'SELECT
                       questions.*
                       FROM questions  WHERE questions.question_quiz_id="' . $_POST['quiz_id'] . '" ;';
$query = $db->query($query);
$questions = $query->fetchAll(PDO::FETCH_ASSOC);

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
                        <h1>Upravit kvíz</h1>
                        <form method="POST" action="php/edit-quiz.php">
                            <input type="text" id="quiz_id" name="quiz_id" value="<?= $_POST['quiz_id'] ?>" hidden>
                            <div class="item-box">
                                <label for="quiz_title">Název kvízu</label>
                                <input type="text" id="quiz_title" name="quiz_title" value="<?= htmlspecialchars($quizTitle) ?>" required>
                            </div>
                            <div class="item-box">
                                <label for="category">Kategorie:</label>
                                <select name="category" id="category" required class="form-control <?php echo (!empty($errors['category']) ? 'is-invalid' : ''); ?>">
                                    <option value="">--Vyberte--</option>
                                    <?php
                                    $categoryQuery = $db->prepare('SELECT * FROM categories ORDER BY category_name;');
                                    $categoryQuery->execute();
                                    $categories = $categoryQuery->fetchAll(PDO::FETCH_ASSOC);
                                    if (!empty($categories)) {
                                        foreach ($categories as $category) {
                                            if ($categorySelected == $category['category_name']){
                                                echo '<option selected value="' . $category['category_id'] . '">' . htmlspecialchars($category['category_name']) . '</option>';
                                            }else {
                                                echo '<option value="' . $category['category_id'] . '">' . htmlspecialchars($category['category_name']) . '</option>';
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <button type="submit" id="submit">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                Upravit
                            </button>
                        </form>
                        <h2 class="mt-4">Otázky</h2>
                        <div class="d-flex justify-content-center">

                            <a class="btn btn-transit mb-4" href="custom-question-create.php?quiz_id=<?= $_POST['quiz_id']; ?>">Vytvořit novou otázku</a>
                        </div>
                        <?php if (!empty($questions)) : ?>
                            <?php foreach ($questions as $q) : array_map('htmlentities', $q); ?>
                                <hr>
                                <div class="row">
                                    <a href="php/delete-question.php?question_id=<?= $q['question_id'] ?>&quiz_id=<?= $_POST['quiz_id']?>" class="btn btn-transit2">Smazat Otázku</a>
                                    <a href="custom-answer-create.php?question_id=<?= $q['question_id'] ?>&quiz_id=<?= $_POST['quiz_id'] ?>" class="btn btn-transit">Přidat odpověď</a>
                                    <p>Otázka: <?= htmlspecialchars($q['question_question']); ?></p>
                                </div>

                                <?php if (!empty($questions)) : ?>
                                    <?php
                                    $query = 'SELECT
                                        answers.* 
                                        FROM answers JOIN questions ON answers.question_id=questions.question_id WHERE answers.question_id="' . $q['question_id'] . '" ;';
                                    $query = $db->query($query);
                                    $answers = $query->fetchAll(PDO::FETCH_ASSOC);
                                    ?>
                                    <?php foreach ($answers as $a) : array_map('htmlentities', $a); ?>
                                        <div class="row">
                                            <div class="col-3">
                                                <a href="php/delete-answer.php?answer_id=<?= $a['answer_id'] ?>&quiz_id=<?= $_POST['quiz_id'] ?>"  class="btn btn-transit2">Smazat</a>
                                            </div>
                                            <div class="col-9">
                                                <p>Odpověď: <?= htmlspecialchars($a['answer_answer']); ?>

                                                    <?php if ($a['answer_correct'] == 1) : ?>
                                                        + Správně
                                                    <?php else : ?>
                                                        - Špatně
                                                    <?php endif; ?>
                                                </p>
                                            </div>


                                        </div>

                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once('inc/footer.php'); ?>
</body>

</html>