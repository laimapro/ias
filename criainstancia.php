
<?php
include("includes/cores.html");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Instância de Aprimoramento Social</title>
</head>
<body>
  
  <h1>Criar Pergunta</h1>

  <form id="questionForm">
    <label for="instanceTitle">Título da Instância:</label>
    <input type="text" id="instanceTitle" required><br><br>

    <label for="situation">Situação Geradora:</label>
    <textarea rows="4" cols="50" id="situation" placeholder="Insira a situação geradora" required></textarea><br><br>

    <button type="button" onclick="addQuestion()">Adicionar Pergunta</button><br><br>
    <div id="questionsContainer">
      <!-- Aqui serão adicionadas as perguntas e opções -->
    </div>
    <button type="button" onclick="saveQuestions()">Salvar</button>
  </form>

<script>
  let questionCount = 0; // Contador de perguntas
  let situationText = ''; // Variável para armazenar a situação geradora

function addOption(container, questionNumber) {
  const optionsContainer = document.getElementById(container);

  const answerInput = document.createElement('input');
  answerInput.type = 'text';
  answerInput.id = `answer${questionNumber}_${optionsContainer.children.length}`;
  answerInput.placeholder = 'Resposta';
  answerInput.required = true;

  const isCorrectCheckbox = document.createElement('input');
  isCorrectCheckbox.type = 'checkbox';
  isCorrectCheckbox.id = `isCorrect${questionNumber}_${optionsContainer.children.length}`;
  isCorrectCheckbox.checked = false;


  const label = document.createElement('label');
  label.htmlFor = `answer${questionNumber}_${optionsContainer.children.length}`;
  label.innerText = 'Correta?';

  const commentInput = document.createElement('input');
   commentInput.type = "text";
   commentInput.id = `comment${questionNumber}_${optionsContainer.children.length}`;
   commentInput.placeholder = "Digite um comentario";
   commentInput.required = true;




  optionsContainer.appendChild(answerInput);
  optionsContainer.appendChild(label);
  optionsContainer.appendChild(isCorrectCheckbox);
  optionsContainer.appendChild(commentInput);
  optionsContainer.appendChild(document.createElement('br'));
}

function addQuestion() {
  questionCount++; // Incrementa o contador de perguntas

  const questionsContainer = document.getElementById('questionsContainer');

  const questionDiv = document.createElement('div');
  questionDiv.id = `question${questionCount}`;

  const questionTitle = document.createElement('h2');
  questionTitle.innerText = `Pergunta ${questionCount}:`;

  if (questionCount === 1) {
    const situationTitle = document.createElement('h3');
    questionDiv.appendChild(situationTitle);
    questionDiv.appendChild(document.createElement('br'));
    questionDiv.appendChild(document.createTextNode(situationText));
    questionDiv.appendChild(document.createElement('hr'));
  }

  const questionText = document.createElement('textarea');
  questionText.rows = 4;
  questionText.cols = 50;
  questionText.id = `questionText${questionCount}`;
  questionText.placeholder = 'Insira a pergunta';
  questionText.required = true;

  const optionsContainer = document.createElement('div');
  optionsContainer.id = `additionalOptions${questionCount}`;

  const addOptionButton = document.createElement('button');
  addOptionButton.type = 'button';
  addOptionButton.innerText = 'Adicionar Opção de Resposta';
  addOptionButton.addEventListener('click', () => addOption(`additionalOptions${questionCount}`, questionCount));

  questionDiv.appendChild(questionTitle);
  questionDiv.appendChild(document.createElement('br'));
  questionDiv.appendChild(document.createTextNode('Pergunta: '));
  questionDiv.appendChild(questionText);
  questionDiv.appendChild(document.createElement('br'));
  questionDiv.appendChild(document.createTextNode('Opções de Resposta: '));
  questionDiv.appendChild(optionsContainer);
  questionDiv.appendChild(addOptionButton);
  questionDiv.appendChild(document.createElement('hr'));

  questionsContainer.appendChild(questionDiv);
}

function saveQuestions() {
  const instanceTitle = document.getElementById('instanceTitle').value;
  situationText = document.getElementById('situation').value; // Atualiza a situação geradora

  const questions = [];

  for (let i = 1; i <= questionCount; i++) {
    const questionText = document.getElementById(`questionText${i}`).value;
    const answers = [];
    const optionsContainer = document.getElementById(`additionalOptions${i}`);
    const answerInputs = optionsContainer.querySelectorAll('input[type="text"]');
    
    
    answerInputs.forEach((input) => {
      const isCorrect = document.getElementById(`isCorrect${i}_${input.id.split('_')[1]}`).checked;
      const comentario = document.getElementById(`comment${i}_${input.id.split('_')[1]}`).value;
      answers.push({ answer: input.value, isCorrect, comment: comentario});
    });

    questions.push({
      question: questionText,
      answers
    });
  }

  const instanceData = {
    title: instanceTitle,
    situation: situationText,
    questions
  };

  const jsonData = JSON.stringify(instanceData, null, 2);

  // Enviar os dados JSON e o título para o PHP usando uma requisição AJAX
  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'save_questions.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
    if (xhr.status === 200) {
      alert('Documento salvo com sucesso.');
      window.location.href = 'index.php';  // Redirecionar para index.php após o sucesso
    } else {
      alert('Erro ao salvar o documento no servidor.');
    }
  };

  const formData = new FormData();
  formData.append('jsonData', jsonData);
  formData.append('title', instanceTitle);

  const params = new URLSearchParams();
  for (const pair of formData) {
    params.append(pair[0], pair[1]);
  }

  xhr.send(params.toString());
}

</script>
<script src="includes/cores.js"></script>
</body>
</html>
