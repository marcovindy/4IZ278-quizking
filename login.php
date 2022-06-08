<?php


require_once 'inc/user.php';

if (!empty($_SESSION['user_id'])) {
    //uživatel už je přihlášený, nemá smysl, aby se přihlašoval znovu
    header('Location: index.php');
    exit();
}

$errors = false;

if (!empty($_POST)) {
    $userQuery = $db->prepare('SELECT * FROM users WHERE user_email=:user_email LIMIT 1;');
    $userQuery->execute([
        ':user_email' => trim($_POST['user_email'])
    ]);
    if ($user = $userQuery->fetch(PDO::FETCH_ASSOC)) {


        if ($_POST['user_pwd'] == $user['user_pwd']) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['user_name'];
            $_SESSION['user_email'] = $user['user_email'];
            $_SESSION['user_exp'] = $user['user_exp'];
            $_SESSION['user_coins'] = $user['user_coins'];
            header('Location: php/signin.php');
            exit();
        } else {
            $errors['pwd'] = "Heslo není správně.";
        }
    } else {
        $errors['email'] = "Uživatel s tímto emailem neexistuje.";
    }
    if (!empty($errors)) {

    }
}


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
    <?php require_once('inc/header-unlog.php'); ?>
    <?php require_once('inc/nav.php'); ?>

    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-8 col-sm-12">


                    <div class="form-box">
                        <h1>Přihlášení</h1>
                        <form method="POST">

                            <div class="item-box">
                                <label for="user_email">E-mail</label>
                                <input type="email" name="user_email" id="user_email" name="user_email" required="">
                            </div>
                            <div class="item-box">
                                <label for="user_pwd">Heslo</label>
                                <input type="password" name="user_pwd" id="user_pwd" name="user_pwd" required="">
                            </div>
                            <?php if (!empty($errors)) : ?>
                            <div class="fs-3">
                            <?php foreach ($errors as $error) : array_map('htmlentities', $errors); ?>
                                <p><?= $error; ?></p>
                            <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                            <button type="submit" id="submit"> Přihlásit se
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </button>
                        </form>
                    


                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <?php require_once('inc/footer.php'); ?>
</body>