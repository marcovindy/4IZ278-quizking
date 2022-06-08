<?php
require_once '../inc/db.php';
$check = 0;
$check2 = 0;
$answersExists = 0;
$checkArr = [];
$result = "<ul>Pro zveřejnění kvízu je třeba mít v kvízu:
<li>Alespoň jednu otázku</li>
<li>Aby každá otázka měla alespoň jednu správnou odpověď</li>
</ul>";
if (!empty($_GET)) {
    if (!empty($_GET['quiz_id'])) {
        $quizId = $_GET['quiz_id'];
        $query = $db->query('SELECT * FROM questions WHERE question_quiz_id="' . $quizId . '"');
        $questions = $query->fetchAll(PDO::FETCH_ASSOC);


        if (!empty($questions)) {
            $check = 1;
            foreach ($questions as $question) {
                if ($check == 1) {
                    $check = 0;
                    $questionId = $question['question_id'];
                    $query2 = $db->query('SELECT * FROM answers WHERE question_id="' . $questionId . '"');
                    $answers = $query2->fetchAll(PDO::FETCH_ASSOC);
                    if (!empty($answers)) {
                        $answersExists = 1;
                        foreach ($answers as $answer){
                            if ($answer['answer_correct'] == 1 && $check2 != 1){
                                $checkArr[] = 1;
                                $check2 = 1;
                            }
                        
                        }
                        $check2 = 0;
                        $check = 1;
                    } else {
                        $check2 = 0;
                        $checkArr[] = 0;
                    }
                }
            }
            if (count($checkArr) == count($questions) && $answersExists == 1) {
                $query = $db->prepare('UPDATE quizzes SET quiz_correct=1 WHERE quiz_id='.$_GET["quiz_id"].';');
                $query->execute();
                $result = "Kvíz byl zveřejněn! Dobrá práce.";
            } else {
                if (!empty($_GET['quiz_id'])){
                    $query = $db->prepare('UPDATE quizzes SET quiz_correct=0 WHERE quiz_id='.$_GET["quiz_id"].';');
                    $query->execute();
                }
            }
        }
    }
    header("refresh:2; url=../custom-edit.php?quiz_id=".$quizId);
}else{
    header("refresh:2; url=../custom-quiz.php");
}
echo $result ;



