<?php

require_once 'inc/db.php';

$query = $db->prepare('SELECT * FROM categories;');
$query->execute();

$categories = $query->fetchAll(PDO::FETCH_ASSOC);
$numOfCat = 0;

$ok = true;

if (!isset($_GET['categories'])) {
    $query = $db->query("SELECT quizzes.* FROM quizzes WHERE quizzes.quiz_price>0 ORDER BY quizzes.quiz_created DESC");
    $quizzes = $query->fetchAll(PDO::FETCH_ASSOC);
} elseif (isset($_GET['categories'])) {
    $query = 'SELECT
                           quizzes.* 
                           FROM quizzes JOIN categories ON quizzes.quiz_category_id=categories.category_id WHERE quizzes.quiz_price>0 AND ( ';
    $names = $_GET['categories'];
    $temp = 0;
    for ($i = 0; $i < count($names) - 1; $i++) {
        $query .= 'categories.category_name="' . $names[$i] . '" OR ';
        $temp = $i + 1;
    }
    $query .= 'categories.category_name="' . $names[$temp++] . '" )';
    $query .= ' ORDER BY quizzes.quiz_created DESC;';
    $query = $db->query($query);
    $quizzes = $query->fetchAll(PDO::FETCH_ASSOC);
}

$queryBQ = $db->query('SELECT bought_quizzes.* FROM bought_quizzes;');
$BQ = $queryBQ->fetchAll(PDO::FETCH_ASSOC);


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
    ?>

    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="card p-4">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <?php if (!isset($_GET['categories'])) : ?>
                            <h1>Obchod s kvízy</h1>
                        <?php endif; ?>

                        <?php
                        if (isset($_GET['categories'])) {
                            $names = $_GET['categories'];
                            $text = "<h1>Obchod s kvízy - kategorie: ";
                            foreach ($names as $categoryName) {
                                $text .= $categoryName . "  ";
                            }
                            $text .= "</h1>";
                            if ($numOfCat == count($names)) {
                                $text = "<h1>Obchod s kvízy</h1>";
                            }
                            echo $text;
                        }
                        ?>

                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="filter-box">
                            <form class="d-flex" action="shop.php" method="get">
                            <fieldset>
                                    <legend>Filtrovat kategorie</legend>
                                    <div class="d-flex">
                                        <?php if (!empty($categories)) : ?>
                                            <?php foreach ($categories as $category) : array_map('htmlentities', $category); ?>
                                            <?php $checked = "" ?>
                                                <?php $numOfCat = count($categories); ?>
                                                <?php if (!empty($_GET)) : ?>
                                                    <?php 
                                                        foreach ($_GET['categories'] as $catFromGet ) {
                                                            if ($catFromGet == $category['category_name']){
                                                                $checked = "checked";
                                                            }
                                                        }
                                                        ?>
                                                <?php endif; ?>
                                                <label class="pr-3">
                                                    <input type="checkbox" name="categories[]" <?= $checked ?> value="<?php echo $category['category_name']; ?>" id="<?php echo $category['category_name']; ?>" />
                                                    <?= htmlspecialchars($category['category_name']); ?>
                                                </label>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <button class="btn-transit btn" type="submit">Filter</button>
                                    <a href="shop.php" class="btn-transit2 btn" type="reset">Reset</a>
                                </fieldset>
                            </form>

                        </div>
                    </div>
                </div>
                <?php if ($user != -1) : ?>
                    <div class="row">
                        <div class="col">
                            <?php if (!empty($quizzes)) : ?>

                                <?php foreach ($quizzes as $quiz) : array_map('htmlentities', $quiz); ?>
                                    <?php $numOfCat = count($quizzes); ?>

                                    <?php
                                    if (!empty($BQ)) {
                                        foreach ($BQ as $bq) {
                                            if (($bq['user_id'] == $_SESSION['user_id']) && ($bq['quiz_id'] == $quiz['quiz_id'])) {
                                                $ok = false;
                                            }
                                        }
                                    }
                                    ?>
                                    <?php if ($ok) : ?>
                                        <div class="quiz p-3">
                                            <div class="row">
                                                <div class="col-4">
                                                    <span class="m-0">
                                                        <?= htmlspecialchars($quiz['quiz_title']); ?>
                                                    </span>
                                                </div>
                                                <div class="col-4">
                                                    <span class="m-0">
                                                        <?= htmlspecialchars($quiz['quiz_created']); ?>
                                                    </span>
                                                </div>
                                                <div class="col-4 d-flex justify-content-center">
                                                    <a href="php/buy.php?quiz_id=<?= $quiz['quiz_id'] ?>" id="shop-btn" class="btn btn-transit" class="m-0">
                                                        <?= htmlspecialchars($quiz['quiz_price']); ?> Mincí
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                            <?php endif; ?>
                            <?php if (empty($quizzes)) : ?>
                                <h2>Zde bohužel nejsou žádné kvízy</h2>

                            <?php endif; ?>


                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($user == -1) : ?>
                    <div class="row justify-content-center">
                        <div class="col">
                            <h2>Pro nákup kvízu se prosím <a href="login.php">přihlašte</a></h2>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php require_once('inc/footer.php'); ?>

</body>