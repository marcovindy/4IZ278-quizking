<?php

require_once 'inc/db.php';

$query = $db->prepare('SELECT * FROM categories;');
$query->execute();

$categories = $query->fetchAll(PDO::FETCH_ASSOC);
$numOfCat = 0;
?>




<!DOCTYPE html>
<html lang="en">

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

    <?php
    if (!empty($_SESSION)) {
        $user = $_SESSION['user_id'];
    } else {
        $user = -1;
    }
    if (!isset($_GET['categories'])) {
        $query = $db->query('SELECT quizzes.* FROM quizzes WHERE quizzes.quiz_user_id="' . $user . '" ORDER BY quizzes.quiz_created DESC');
        $quizzes = $query->fetchAll(PDO::FETCH_ASSOC);
    } elseif (isset($_GET['categories'])) {
        $query = 'SELECT
                           quizzes.* 
                           FROM quizzes JOIN categories ON quizzes.quiz_category_id=categories.category_id WHERE ';
        $names = $_GET['categories'];
        $temp = 0;
        for ($i = 0; $i < count($names) - 1; $i++) {
            $query .= 'categories.category_name="' . $names[$i] . '" OR ';
            $temp = $i + 1;
        }
        $query .= 'categories.category_name="' . $names[$temp++] . '" ';
        $query .= ' AND quizzes.quiz_user_id=' . $user;
        $query .= ' ORDER BY quizzes.quiz_created DESC;';
        $query = $db->query($query);
        $quizzes = $query->fetchAll(PDO::FETCH_ASSOC);
    }

    ?>

    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="card p-4">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <?php if (!isset($_GET['categories'])) : ?>
                            <h1>Vlastní Kvízy</h1>
                        <?php endif; ?>

                        <?php
                        if (isset($_GET['categories'])) {
                            $names = $_GET['categories'];
                            $text = "<h1>Kvízy - kategorie: ";
                            foreach ($names as $categoryName) {
                                $text .= $categoryName . "  ";
                            }
                            $text .= "</h1>";
                            if ($numOfCat == count($names)) {
                                $text = "<h1>Vlastní kvízy</h1>";
                            }
                            echo $text;
                        }
                        ?>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="filter-box">
                            <form class="d-flex" action="custom-quiz.php" method="get">
                                <fieldset>
                                    <legend>Filtrovat kategorie</legend>
                                    <div class="d-flex">
                                        <?php if (!empty($categories)) : ?>
                                            <?php foreach ($categories as $category) : array_map('htmlentities', $category); ?>
                                                <?php $numOfCat = count($categories); ?>
                                                <label class="pr-3">
                                                    <input type="checkbox" name="categories[]" value="<?php echo $category['category_name']; ?>" id="<?php echo $category['category_name']; ?>" />
                                                    <?php echo htmlspecialchars($category['category_name']); ?>
                                                </label>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <button class="btn-transit btn" type="submit">Filter</button>
                                    <button class="btn-transit2 btn" type="reset">Reset</button>
                                </fieldset>
                            </form>

                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col">
                        <?php if (!empty($quizzes)) : ?>
                            <?php foreach ($quizzes as $quiz) : array_map('htmlentities', $quiz); ?>
                                <?php $numOfCat = count($quizzes); ?>
                                <a href="quiz.php?quiz_id=<?= $quiz['quiz_id'] ?>">
                                    <div class="quiz p-3">
                                        <div class="row">
                                            <div class="col-4 d-flex flex-column justify-content-center">
                                                <span class="m-0">
                                                    <?= htmlspecialchars($quiz['quiz_title']); ?>
                                                </span>
                                            </div>
                                            <div class="col-4  d-flex  flex-column justify-content-center">
                                                <span class="m-0">
                                                    <?= htmlspecialchars($quiz['quiz_created']); ?>
                                                </span>
                                            </div>
                                            <div class="col-4 d-flex justify-content-center">
                                                <form class="pr-2" action="custom-edit.php" method="post">
                                                    <input type="hidden" id="quiz_id" name="quiz_id" value="<?= $quiz['quiz_id']; ?>">
                                                    <button class="btn-transit3 btn" type="submit">Upravit</button>
                                                </form>
                                                <form action="php/delete-quiz.php" method="post">
                                                    <input type="hidden" id="quiz_id" name="quiz_id" value="<?= $quiz['quiz_id']; ?>">
                                                    <button class="btn-transit2 btn" type="submit">Smazat</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <?php if (empty($quizzes)) : ?>
                            <?php if ($user != -1) : ?>
                                <h2>Zde bohužel nejsou žádné kvízy</h2>
                            <?php else : ?>
                                <h2>Pro vytvoření vlastního kvízu se prosím <a href="login.php">přihlašte</a></h2>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if (!empty($_SESSION)) : ?>
                    <div class="row pt-4">
                        <div class="m-auto col-lg-3 col-sm-12">
                            <a href="custom-create.php" class="btn btn-circle btn-transit w-100">
                                Vytvořit kvíz
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php require_once('inc/footer.php'); ?>
</body>

</html>