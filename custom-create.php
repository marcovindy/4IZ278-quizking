<?php require_once 'inc/db.php' ?>

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
                        <h1>Vytvořit kvíz</h1>
                        <form method="POST" action="php/add-quiz.php">
                            <div class="item-box">
                                <label for="quiz_title">Název kvízu</label>
                                <input type="text" id="quiz_title" name="quiz_title" required="">
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
                                            echo '<option value="' . $category['category_id'] . '">' . htmlspecialchars($category['category_name']) . '</option>';
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
                                Vytvořit kvíz
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>