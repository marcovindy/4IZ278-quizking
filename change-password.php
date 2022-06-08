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

    <?php require_once('inc/db.php'); ?>


    <?php
    $result = "";
    if (!empty($_POST)) {
        $query = $db->query('SELECT * FROM users WHERE user_id="' . $_SESSION['user_id'] . '" LIMIT 1');
        $users = $query->fetchAll(PDO::FETCH_ASSOC);

        $oldPwd = $_POST['user_pwd_old'];
        $newPwd = $_POST['user_pwd_new'];
        $co = $_POST['user_pwd_new_co'];
        $userId = $_SESSION['user_id'];
        foreach ($users as $user) {
            $user['user_pwd'] = $user['user_pwd'];
        }
        $pattern = '/^(?=.*[0-9])(?=.*[A-Z]).{8,20}$/';
        if ((preg_match($pattern, $newPwd))) {
            if ($user['user_pwd'] != $oldPwd) {
                $result = "Zadal jsi špatně staré heslo";
            } else {
                if ($newPwd != $oldPwd) {
                    if ($newPwd != $co) {
                        $result = "Hesla nejsou stejná";
                    } else {
                        $query = $db->prepare('UPDATE users SET user_pwd="' . $newPwd . '" WHERE user_id="' . $userId . '"');
                        if ($query->execute()) {
                            $result = "Heslo se povedlo změnit";
                        }
                    }
                } else {
                    $result = "Nové heslo nemůže být stejné, jako staré";
                }
            }
        } else {
            $result = 'Heslo musí mít minimálně 1 číslici z minimálních 8 znaků.';
        }
    }
    ?>


    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-8 col-sm-12">

                    <div class="form-box">
                        <h2>Změna hesla</h2>
                        <form method="post">
                            <div class="item-box">
                                <label for="user_pwd_old">Staré heslo</label>
                                <input type="password" id="user_pwd_old" name="user_pwd_old" required="">

                            </div>
                            <div class="item-box">
                                <label for="user_pwd_new">Nové heslo</label>
                                <input type="password" id="user_pwd_new" name="user_pwd_new" required="">
                            </div>
                            <div class="item-box">
                                <label for="user_pwd_new_co">Potvrzení nového hesla</label>
                                <input type="password" id="user_pwd_new_co" name="user_pwd_new_co" required="">
                            </div>

                            <?php
                            if ($result != "") {
                                echo "<div class='fs-3'>" . $result . "<div>";
                            }
                            ?>

                            <button type="submit" id="submit">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                Změnit heslo
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