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

    <?php require_once('inc/db.php'); ?>

    <?php
    $query = $db->query('SELECT users.* FROM users WHERE users.user_id="' . $_SESSION['user_id'] . '"');
    $users = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach ($users as $user) {
        $coins = $user['user_coins'];
        $exps = $user['user_exp'];
    }
    ?>

    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12">

                    <div class="card bg-transit">
                        <div class="card-header">
                            <h6>Informace</h6>
                        </div>
                        <div class="card-body text-center">
                            <div class="img-box m-auto">
                                <img src="img/placeholder.png" width="200px" class="rounded-circle" width="150">
                            </div>

                            <h4 class="card-title m-t-10"><?= $_SESSION['user_name'] ?></h4>
                            <h6 class="card-subtitle">Zkušenosti <?= htmlspecialchars($exps); ?></h6>
                            <div class="row text-center justify-content-md-center">
                                <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-people"></i>

                                    </a></div>
                                <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-picture"></i>

                                    </a></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <span class="text-muted ">E-mail:</span>
                            <h6><?= $_SESSION['user_email'] ?></h6>
                            <a href="facebook.com" class="btn btn-circle btn-blue fb"><i class="fab fa-facebook-f"></i></a>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card bg-transit h-100">
                        <div class="card-header">
                            <h6>Počet mincí</h6>
                        </div>
                        <div class="card-body d-flex justify-content-center ">
                            <p class="d-block m-auto fs-1"><?= htmlspecialchars($coins); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card bg-transit h-100">
                        <div class="card-header">
                            <h6>Žebříček</h6>
                        </div>

                        <?php
                        $query = $db->query('SELECT users.* FROM users ORDER BY users.user_exp DESC');
                        $users = $query->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($users as $user) {
                            echo '<div class="row text-center justify-content-center">';
                            echo '<div class="col"><p>jmeno: ' . htmlspecialchars($user['user_name']) . '</p></div>';
                            echo '<div class="col"><p>exp: ' . htmlspecialchars($user['user_exp']) . '</p></div>';
                            echo '</div>';
                        }
                        ?>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once('inc/footer.php'); ?>
</body>

</html>