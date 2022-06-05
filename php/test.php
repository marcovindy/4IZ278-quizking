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


    <?php
    require_once '../inc/db.php';
    require_once 'answers.php';
    require_once 'question.php';

    $quiz_id = $_GET['quiz_id'];

    $arrayA = array();
    $arrayQ = array();

    $query = $db->query('SELECT questions.* FROM questions WHERE questions.question_quiz_id="' . $quiz_id . '" ');

    $query2 = $db->query('SELECT answers.* FROM answers JOIN questions ON questions.question_quiz_id=answers.question_id WHERE questions.question_quiz_id="' . $quiz_id . '" ');


    while ($row = $query->fetch()) {
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
        $objStudent = new Question($id, $q, $arrayA);
        $arrayA = array();
        $arrayQ[] = $objStudent;
    }

    // var_dump($arrayQ);
    // $arr = array('question' => 1, 'b' => 2);
    // var_dump($arr);



    $myJSON = json_encode($objStudent);
    // var_dump($myJSON);
    echo ($myJSON);

    ?>

    <div id="test">

    </div>
    <div id="test1">

</div>

    <script>
var jsonobj ='<?= $myJSON ?>';
  
// Here we convert JSON to object
var obj = JSON.parse(jsonobj);
  
document.getElementById("test").innerHTML = 
                     obj.question;
document.getElementById("test1").innerHTML =jsonobj;
</script>
</body>

</html>