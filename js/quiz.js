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
    button.classList.add('btn')
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

const questions2 = [
  {
    "question": 'What is 2 + 2?',
    "answers": [
      { "text": '4', correct: true },
      { "text": '22', correct: false }
    ]
  },
  {
    question: 'Who is the best YouTuber?',
    answers: [
      { "text": 'Web Dev Simplified', correct: true },
      { "text": 'Traversy Media', correct: true },
      { "text": 'Dev Ed', correct: true },
      { "text": 'Fun Fun Function', correct: true }
    ]
  },
  {
    question: 'Is web development fun?',
    answers: [
      { "text": 'Kinda', correct: false },
      { "text": 'YES!!!', correct: true },
      { "text": 'Um no', correct: false },
      { "text": 'IDK', correct: false }
    ]
  },
  {
    question: 'What is 4 * 2?',
    answers: [
      { "text": '6', correct: false },
      { "text": '8', correct: true }
    ]
  }
]

const questions = [
  {
    "id":"1",
    "question":"Kde se používá metoda nejmenších čtverců?",
    "answers":[
      {"id":"1","answer":"Při posouzení vhodnosti modelu u regresních funkcí","correct":"0"}
      ,{"id":"2","answer":"Při určování parametrů regresních funkcí","correct":"1"},{"id":"3","answer":"Při posouzení rozdílnosti rozptylů v ANOVA testu","correct":"0"}]}
]