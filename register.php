<?php
  //načteme připojení k databázi a inicializujeme session
  require_once 'inc/user.php';

  if (!empty($_SESSION['user_id'])){
    //uživatel už je přihlášený, nemá smysl, aby se registroval
    header('Location: index.php');
    exit();
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
    <?php require_once('inc/header-unlog.php'); ?>

    <?php require_once('inc/nav.php'); ?>



    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-8 col-sm-12">

                    <div class="form-box">
                        <h1>Registrace</h1>
                        <form method="POST" action="php/signup.php">
                            <div class="item-box">
                                <label for="user_name">Jméno</label>
                                <input type="text" id="user_name" name="user_name" required="">

                            </div>
                            <div class="item-box">
                                <label for="user_email">E-mail</label>
                                <input type="email" id="user_email" name="user_email" required="">
                            </div>
                            <div class="item-box">
                                <label for="user_pwd">Heslo</label>
                                <input type="password" id="user_pwd" name="user_pwd" required="">
                            </div>
                            <div class="item-box">
                                <label for="user_pwd_co">Potvrzení hesla</label>
                                <input type="password" id="user_pwd_co" name="user_pwd_co" required="">
                            </div>
                            <button type="submit" id="submit">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                Registrovat
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>