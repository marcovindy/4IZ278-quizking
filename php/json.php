    <?php
    require_once '../inc/db.php';
    require_once 'answers.php';
    require_once 'question.php';

    if (!empty($_GET)) {

        $quiz_id = $_GET['quiz_id'];

        $arrayA = array();
        $arrayQ = array();

        $query = $db->query('SELECT questions.* FROM questions WHERE questions.question_quiz_id="' . $quiz_id . '" ');
    
       
        while ($row = $query->fetch()) {
            $query2 = $db->query('SELECT answers.* FROM answers JOIN questions ON questions.question_id=answers.question_id WHERE answers.question_id="' . $row['question_id'] . '"; ');

            while ($row2 = $query2->fetch()) {
                $idA = $row2['answer_id'];
                $a = $row2['answer_answer'];
                $correct = $row2['answer_correct'];
                $answerObject = new Answer($idA, $a, $correct);
                $arrayA[] = $answerObject;
            }
            $id = $row['question_id'];
            $q = $row['question_question'];
            $answer = $row['question_id'];
            $questionObject = new Question($id, $q, $arrayA);
            $arrayA = array();
            $arrayQ[] = $questionObject;
        }

        
        
        if ($questionObject != null) {
            $json = json_encode($arrayQ);
            var_dump($json);
            if (file_put_contents("../json/data.json", $json)) {
                echo "JSON vytvořen...";
            } else {
                echo "Nepovedlo se vytvořit JSON...";
            }
            header("location: ../quiz.php");
        } else {
            file_put_contents("../json/data.json", "null");
            header("location: ../quiz.php");
        }
    } else {
        header("location: ../index.php");
    }
