<?php

require_once '../inc/db.php';
require_once 'answers.php';
require_once 'question.php';

$quiz_id = $_GET['quiz_id'];

$arrayA = array();
$arrayQ = array();

$query = $db->query('SELECT questions.* FROM questions WHERE questions.question_quiz_id="'.$quiz_id.'" ');

$query2 = $db->query('SELECT answers.* FROM answers JOIN questions ON questions.question_quiz_id=answers.question_id WHERE questions.question_quiz_id="'.$quiz_id.'" ');


while($row = $query->fetch()) {
    while($row2 = $query2->fetch()) {
        $idA = $row2['answer_id'];
        $a = $row2['answer_answer'];
        $correct = $row2['answer_correct'];
        $answerObject = new Answer($idA, $a, $correct);
        $arrayA[] = $answerObject;
    }
    $id = $row['question_id'];
    $q = $row['question_question'];
    $answer = $row['question_id'];
    $objStudent = new Question($id, $q, $arrayA);
    $arrayA = array();
    $arrayQ[] = $objStudent;
}

$arr = array('question' => 1, 'b' => 2);




$myJSON = json_encode($arr);
var_dump($myJSON);
echo($myJSON);

   