<?php
$result = "";
if (!empty($_POST)) {
    $to = "vanm32@vse.cz";
    if (!empty($_POST['subject'])) {
        $subjectText = $_POST['subject'];
        if (!empty($_POST['text'])) {

            $subject = '=?UTF-8?B?' . base64_encode($subjectText) . '?=';
            $text = $_POST['text'];
            $msg = base64_encode($text);
            $headers  = "From: Marek Vaníček <test@mareksite.com>\r\n";
            $headers .= "Cc: Další člověk <mail@mail.com>\r\n";
            $headers .= "X-Sender: MarekSite <mail@mareksite.com>\r\n";
            $headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
            $headers .= "X-Priority: 1\r\n";
            $headers .= "Return-Path: test@mareksite.com\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";
            $headers .= 'Content-Type: text/plain; charset=utf-8' . "\r\n";
            $headers .= 'Content-Transfer-Encoding: base64';

            if (mail($to, $subject, $msg, $headers)) {
                $result = "<div class='fs-1'>Zpráva se povedla odeslat.</div>";
            } else {
                $result = "<div class='fs-1'>Zpráva se nepovedla odeslat.</div>";
            }
        } else {
            $result = "<div class='fs-1'>Musíte něco napsat do zprávy.</div>";
        }
    } else {
        $result = "<div class='fs-1'>Nevyplněný předmět.</div>";
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
    <?php require_once('inc/header.php'); ?>
    <?php require_once('inc/nav.php'); ?>

    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-8 col-sm-12">


                    <div class="form-box">
                        <h1>Nahlásit problém</h1>

                        <form method="POST">

                            <div class="item-box">
                                <label for="subject">Předmět</label>
                                <input type="text" name="subject" id="subject" name="subject" required="">
                            </div>
                            <div class="item-box">
                                <label for="text">Zpráva</label>
                                <input type="text" name="text" id="text" name="text" required="">
                            </div>
                            <?php
                            if ($result != "") {
                                echo "<div>" . $result . "</div>";
                            }
                            ?>
                            <button type="submit" id="submit"> Odeslat report
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

</html>