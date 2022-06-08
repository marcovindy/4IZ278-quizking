<?php
require_once 'inc/db.php';
require_once 'php/answers.php';
require_once 'php/question.php';

$errors = [];

if (empty($_GET)) { # Pokud není hodnota v přenesena, tak ukaž problém
  $errors['get'] = 'Tento kvíz není možné spustit. Kvíz není specifikován.';
}

$arrayA = array();  # Pole pro obejkty odpovědí
$arrayQ = array();  # Pole pro objekty otázek
$quiz_id = $_GET['quiz_id']; # Kvíz ID

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

if (empty($questionObject)) {
  $errors['QandA'] = 'Nejsou zde žádné otázky.';
}

if (!empty($errors)) {
  header("refresh:2; url=index.php");
}

$json = json_encode($arrayQ);
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
  <link rel="stylesheet" href="css/quiz.css">

  <!-- JS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>

</head>

<body>

  <?php require_once('inc/header.php'); ?>

  <?php require_once('inc/nav.php'); ?>
  <div class="page-wrapper">
    <div class="container-fluid d-flex justify-content-center ">
      <div class="container-quiz">

        <?php if (!empty($errors)) : ?>

          <div class="error-msg">
            <?php foreach ($errors as $error) : array_map('htmlentities', $errors); ?>

              <p> <?= $error ?> </p>
              <p>Budete automaticky přesměrování na domovskou stránku.</p>
              <a class="btn btn-transit2" href="index.php">Jít na hlavní stránku</a>
            <?php endforeach; ?>

          </div>

        <?php else : ?>

          <div id="question-container" class="hide">
            <div id="question">Bohužel žádná otázka tu není</div>
            <div id="answer-buttons" class="d-flex flex-wrap">
              <button class="btn btn-transit m-1">Není zde žádná otázka</button>
              <button class="btn btn-transit m-1">Není zde žádná otázka</button>
              <button class="btn btn-transit m-1">Není zde žádná otázka</button>
              <button class="btn btn-transit m-1">Není zde žádná otázka</button>
            </div>
          </div>
          <div class="controls">
            <button id="start-btn" class="start-btn btn btn-transit">Start</button>
            <button id="next-btn" class="next-btn btn btn-transit hide">Next</button>
          </div>
          <div class="points">
            <p id="points"></p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div id="alert" class="alert alert-primary m-3 d-none alert-msg" role="alert">
    This is a primary alert—check it out!
  </div>

  <script>
    const startButton = document.getElementById('start-btn')
    const nextButton = document.getElementById('next-btn')
    const questionContainerElement = document.getElementById('question-container')
    const questionElement = document.getElementById('question')
    const answerButtonsElement = document.getElementById('answer-buttons')
    const pointsDiv = document.getElementById('points')

    let arrayAnswers = [];
    let shuffledQuestions, currentQuestionIndex, points, q;

    startButton.addEventListener('click', startGame)
    nextButton.addEventListener('click', () => {
      currentQuestionIndex++
      setNextQuestion()

    })

    function startGame() {
      points = 0;
      q = 0;
      pointsDiv.innerHTML = ""
      startButton.classList.add('hide')
      shuffledQuestions = questions.sort(() => Math.random() - .5)
      currentQuestionIndex = 0
      questionContainerElement.classList.remove('hide')
      setNextQuestion()
    }

    function setNextQuestion() {
      resetState()
      showQuestion(shuffledQuestions[currentQuestionIndex])
    }

    function showQuestion(question) {
      questionElement.innerText = question.question
      let arrayAnswers = [];
      question.answers.forEach(answer => {
        arrayAnswers.push(1)
        const button = document.createElement('button')
        button.innerText = answer.answer
        button.classList.add('btn-transit')
        button.classList.add('btn')
        button.classList.add('m-1')
        if (answer.correct == 1) {
          button.dataset.correct = answer.correct
        }
        button.addEventListener('click', selectAnswer)
        answerButtonsElement.appendChild(button)
      })
      if (arrayAnswers.length == 0) {
        const node = document.createElement("div");
        const textnode = document.createTextNode("Zde není žádná odpověď, kvíz je potřeba opravit");
        node.appendChild(textnode);
        answerButtonsElement.appendChild(node);
      }
    }

    function resetState() {
      clearStatusClass(document.body)
      nextButton.classList.add('hide')
      while (answerButtonsElement.firstChild) {
        answerButtonsElement.removeChild(answerButtonsElement.firstChild)
      }
    }



    function selectAnswer(e) {
      const selectedButton = e.target

      const correct = selectedButton.dataset.correct
      setStatusClass(document.body, correct)
      if (selectedButton.dataset.correct) {
        points += 1
      }
      q += 1
      Array.from(answerButtonsElement.children).forEach(button => {
        setStatusClass(button, button.dataset.correct)
        button.disabled = true;
      })
      if (shuffledQuestions.length > currentQuestionIndex + 1) {
        nextButton.classList.remove('hide')
      } else {
        startButton.innerText = 'Restart'
        startButton.classList.remove('hide')
        pointsDiv.innerHTML = 'Body: ' + points + " / " + q
        points = 0
        q = 0
      }
    }

    function setStatusClass(element, correct) {
      clearStatusClass(element)
      if (correct) {
        element.classList.add('correct')
      } else {
        element.classList.add('wrong')
      }
    }

    function clearStatusClass(element) {
      element.classList.remove('correct')
      element.classList.remove('wrong')
    }

    const questions = <?= $json ?>;
  </script>

  <script>
    $(document).ready(function() {
      $(".controls").on('click', '#start-btn', function() {

        var id = <?= $quiz_id ?>;

        $.ajax({
          type: "POST",
          url: "php/get-exp.php",
          data: {
            id: id
          },
          cache: false,
          success: function(response) {
            if (response == 1) {
              $('#alert').removeClass('d-none');
              $('#alert').text("Uživatel nedostal žádné body zkušeností.");
              setTimeout(() => {
                $('#alert').addClass('d-none');
              }, 3000);
            } else if (response == 2) {

              $('#alert').removeClass('d-none');
              $('#alert').text("Dostal jsi expy!");
              setTimeout(() => {
                $('#alert').addClass('d-none');
              }, 3000);
            } else if (response == 3) {
              $('#alert').removeClass('d-none');
              $('#alert').text("Dostal jsi body zkušeností a coiny.");
              setTimeout(() => {
                $('#alert').addClass('d-none');
              }, 3000);
            } else {
              $('#alert').removeClass('d-none');
              $('#alert').text("Pro získání bodů zkušení se přihlaš.");
              setTimeout(() => {
                $('#alert').addClass('d-none');
              }, 3000);
            }
          },
          error: function(xhr, status, error) {
            console.error(xhr);
          }
        });


      });
    });
  </script>

  <?php require_once('inc/footer.php'); ?>

</body>

</html>