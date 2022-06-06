<?php

$json = file_get_contents("json/data.json");

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
  <link rel="stylesheet" href="css/quiz.css">

  <!-- JS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>

</head>

<body>
  <?php require_once('inc/header.php'); ?>

  <?php require_once('inc/nav.php'); ?>
  <div class="page-wrapper">
    <div class="container-fluid d-flex justify-content-center">
      <div class="container-quiz">
        <div id="question-container" class="hide">
          <div id="question">Bohužel žádná otázka tu není</div>
          <div id="answer-buttons" class="d-flex flex-wrap">
            <button class="btn btn-transit m-1">Answer 1</button>
            <button class="btn btn-transit m-1">Answer 2</button>
            <button class="btn btn-transit m-1">Answer 3</button>
            <button class="btn btn-transit m-1">Answer 4</button>
          </div>
        </div>
        <div class="controls">
          <button id="start-btn" class="start-btn btn btn-transit">Start</button>
          <button id="next-btn" class="next-btn btn btn-transit hide">Next</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    const startButton = document.getElementById('start-btn')
    const nextButton = document.getElementById('next-btn')
    const questionContainerElement = document.getElementById('question-container')
    const questionElement = document.getElementById('question')
    const answerButtonsElement = document.getElementById('answer-buttons')

    let shuffledQuestions, currentQuestionIndex

    startButton.addEventListener('click', startGame)
    nextButton.addEventListener('click', () => {
      currentQuestionIndex++
      setNextQuestion()
    })

    function startGame() {
      
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
      question.answers.forEach(answer => {
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
      Array.from(answerButtonsElement.children).forEach(button => {
        setStatusClass(button, button.dataset.correct)
      })
      if (shuffledQuestions.length > currentQuestionIndex + 1) {
        nextButton.classList.remove('hide')
      } else {
        startButton.innerText = 'Restart'
        startButton.classList.remove('hide')
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
    <?php require_once('inc/footer.php'); ?>
</body>

</html>