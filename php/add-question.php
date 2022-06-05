<?php

//načteme připojení k databázi
require_once 'inc/db.php';

$errors = [];
if (!empty($_POST)) {
    $quizId = $_POST['quiz_id'];
    $question = $_POST['question'];
    $answer1 = $_POST['answer1'];
    $answer2 = $_POST['answer2'];
    $answer3 = $_POST['answer3'];
    $answer4 = $_POST['answer4'];
    $answer1_correct = $_POST['answer1_correct'];
    $answer1_correct = $_POST['answer1_correct'];
    $answer1_correct = $_POST['answer1_correct'];
    $answer1_correct = $_POST['answer1_correct'];
}
