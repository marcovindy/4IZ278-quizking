<?php
# response 0 = Uživatel není přihlášen
# response 1 = Nepovedlo se přičíst nic
# response 2 = Povedlo se přičíst jen expy
# response 3 = Povedlo se přičíst i expy i coiny

require_once '../inc/db.php';
session_start();

$verified = 0;
$newCoins = 1;
$newExps = 10;
$response = 0;

if (!empty($_SESSION)) {
    if (!empty($_SESSION['user_id'])) {
        if (!empty($_POST)) {
            $quizId = $_POST['id'];
            $userId = $_SESSION['user_id'];
            $response = 1;

            $query = $db->query('SELECT quizzes.* FROM quizzes WHERE quizzes.quiz_id="' . $quizId . '"');
            while ($row = $query->fetch()) {
                if ($row['quiz_verified'] != 0) {
                    $verified = 1;
                }
            }

            $query = $db->query('SELECT users.* FROM users WHERE users.user_id="' . $userId . '"  LIMIT 1');
            while ($row = $query->fetch()) {
                $newCoins += $row['user_coins'];
                $newExps += $row['user_exp'];
            }

            $query = $db->prepare('UPDATE users SET user_exp="' . $newExps . '" WHERE user_id="' . $userId . '"');
            if ($query->execute()){
                $response = 2;
            } else {
                $response = 1;
            }

            if ($verified == 1) {
                $query = $db->prepare('UPDATE users SET user_coins="' . $newCoins . '" WHERE user_id="' . $userId . '"');
                if ($query->execute()) {
                    $response = 3;
                } else {
                    $response = 1;
                }
            }

            $db = null;
        } else {
            $response = 1;
        }
      
    }
}

echo $response;
