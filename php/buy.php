<?php

//načteme připojení k databázi
require_once '../inc/db.php';
session_start();
$errors = [];
if (!empty($_SESSION)) {
    if (!empty($_SESSION['user_id'])) {
        if (!empty($_GET)) {
            if (!empty($_GET['quiz_id'])) {

                $queryUser = 'SELECT
        users.*
        FROM users  WHERE users.user_id="' . $_SESSION['user_id'] . '" LIMIT 1;';
                $queryUser = $db->query($queryUser);
                $users = $queryUser->fetchAll(PDO::FETCH_ASSOC);

                $queryQuizzes = 'SELECT
        quizzes.*
        FROM quizzes  WHERE quizzes.quiz_id="' . $_GET['quiz_id'] . '"   LIMIT 1;';
                $queryQuizzes = $db->query($queryQuizzes);
                $quizzes = $queryQuizzes->fetchAll(PDO::FETCH_ASSOC);

                foreach ($users as $user) {
                    $userCoins = $user['user_coins'];
                }

                foreach ($quizzes as $quiz) {
                    $quizPrice = $quiz['quiz_price'];
                }

                if ($userCoins >= $quizPrice) {

                    $query = $db->prepare('INSERT INTO bought_quizzes (user_id, quiz_id) VALUES (:user_id, :quiz_id);');
                    $query->execute([
                        ':user_id' => $_SESSION['user_id'],
                        ':quiz_id' => $_GET['quiz_id']
                    ]);

                    $userCoins = $userCoins - $quizPrice;

                    $query = $db->prepare('UPDATE users SET user_coins="' . $userCoins . '" WHERE user_id=' . $_SESSION["user_id"] . ';');
                    $query->execute();
                } else {
                    $errors['quiz_price'] = 'Uzivatel nema coiny na tento kvíz.';
                }
            } else {
                $errors['quiz_id'] = 'Musíte vybrat kvíz.';
            }
        }
    } else {
        $errors['user_id'] = 'Uzivatel neni prihlasen!';
    }
}




if (empty($errors)) {
    echo 'Kviz uspesne koupen.';
}

foreach ($errors as $error) {
    echo $error;
}

header("refresh:2; url=../shop.php");
