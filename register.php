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

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js">></script>

    
</head>
<body>
    <div class="container-fluid p-0 d-flex main-container">
        <?php require_once('inc/nav.php'); ?>
        <div class="login-box">
        <h2>Registrace</h2>
            <form>
                <div class="user-box">
                <input type="text" id="user_name" name="user_name" required="">
                <label>Přihlašovací jméno</label>
                </div>
                <div class="user-box">
                <input type="email" id="user_email" name="user_email" required="">
                <label>E-mail</label>
                </div>
                <div class="user-box">
                <input type="password" id="user_pwd" name="user_pwd" required="">
                <label>Heslo</label>
                </div>
                <div class="user-box">
                <input type="password" id="user_pwd_co" name="user_pwd_co" required="">
                <label>Potvrzení hesla</label>
                </div>
                <a href="#">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                Registrovat
                </a>
            </form>
            </div>
        </div>
        <script src="js/bootstrap.min.js"></script>
</body>

