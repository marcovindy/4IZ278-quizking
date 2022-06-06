<?php
$result = "";
if ( !empty( $_POST ) ) {
    $xml = simplexml_load_file( "quizking.8u.cz" );
    if ( !empty( $xml->channel ) ) {
        foreach ($xml->channel as $channel) {
            if (!empty( $channel->item )) {
                foreach ($channel->item as $item){
                    $result .= '<a href="'. $item->link .'">' . htmlspecialchars($item->title). '</a><br/>';
                }
            }
        }
    }

}

$to = "vanm32@vse.cz";

if ( !empty( $_POST['subject'] )) {
    $subjectText = $_POST['subject'];
} else {
    $subjectText = "Neznámý předmět";
}
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

if ( mail($to, $subject, $msg, $headers) ) {
    echo "<div>Zpráva se povedla odeslat.</div>";
} else {
    echo "<div>Zpráva se nepovedla odeslat.</div>";
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
                        <h1>Přihlášení</h1>
                        <form method="POST">

                            <div class="item-box">
                                <label for="subject">Předmět</label>
                                <input type="text" name="subject" id="subject" name="subject" required="">
                            </div>
                            <div class="item-box">
                                <label for="text">Zpráva</label>
                                <input type="text" name="text" id="text" name="text" required="">
                            </div>
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
</body>
