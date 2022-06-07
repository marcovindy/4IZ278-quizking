<?php


$verified = 0;
$newCoins = 1;
$newExps = 10;


$query = $db->query('SELECT quizzes.* FROM quizzes WHERE quizzes.quiz_id="' . $quiz_id . '"');
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



if ($verified == 1) {
    $query = $db->prepare('UPDATE users SET user_coins="' . $newCoins . '" WHERE user_id="' . $userId . '"');
    $query->execute();
}

$query = $db->prepare('UPDATE users SET user_exp="' . $newExps . '" WHERE user_id="' . $userId . '"');
$query->execute();

