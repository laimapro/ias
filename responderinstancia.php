
<?php
include("includes/cores.html");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instância de Aprimoramento Social</title>
    <style>
        .hidden {
            display: none;
        }
        .correct {
            color: green;
        }
        .incorrect {
            color: red;
        }
    </style>
</head>
<body>

<?php
$pasta_instancias = 'instancias/';

if (is_dir($pasta_instancias)) {
    $arquivos = scandir($pasta_instancias);
    $arquivos = array_diff($arquivos, array('..', '.'));

    echo '<div id="dropdown">';
    echo '<select name="arquivo" id="arquivo">';
    echo '<option value="" selected>Selecione uma instância</option>';
    foreach ($arquivos as $arquivo) {
        if (pathinfo($arquivo, PATHINFO_EXTENSION) === 'json') {
            echo '<option value="' . $arquivo . '">' . $arquivo . '</option>';
        }
    }
    echo '</select>';
    echo '</div>';
} else {
    echo 'A pasta de instâncias não existe ou não é um diretório.';
}
?>

<button id="lerJson" onclick="lerJson()">Visualizar instância</button>

<script>
var data;

function lerJson() {
    var selectedFile = document.getElementById('arquivo').value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                data = JSON.parse(xhr.responseText);
                displayData(data);
                hideDropdownAndButton();
            } else {
                console.error('Erro ao carregar o arquivo JSON.');
            }
        }
    };
    xhr.open('GET', 'instancias/' + selectedFile, true);
    xhr.send();
}

function displayData(data) {
    var output = '<h2>' + data.title + '</h2>';
    output += '<p>' + data.situation + '</p>';
    output += '<ul>';
    for (var i = 0; i < data.questions.length; i++) {
        output += '<li>';
        output += '<h3>' + data.questions[i].question + '</h3>';

        var shuffledAnswers = shuffleArray(data.questions[i].answers);

        output += '<ul>';
        for (var j = 0; j < shuffledAnswers.length; j++) {
            var answer = shuffledAnswers[j];
            if (answer.answer !== answer.comment) {
                var classToApply = answer.isCorrect ? 'correct' : 'incorrect';
                output += '<li class="checkboxLi">';
                output += '<label>';
                output += '<input type="checkbox" name="answer_' + i + '" value="' + j + '" onclick="displayComment(' + i + ', ' + j + ', this)" class="' + classToApply + '"> <span class="checkboxText">' + answer.answer + '</span>';
                output += '</label>';
                output += '</li>';
            }
        }
        output += '</ul>';
        output += '</li>';
    }
    output += '</ul>';

    document.getElementById('output').innerHTML = output;
}

function shuffleArray(array) {
    var currentIndex = array.length, temporaryValue, randomIndex;

    while (0 !== currentIndex) {
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex -= 1;

        temporaryValue = array[currentIndex];
        array[currentIndex] = array[randomIndex];
        array[randomIndex] = temporaryValue;
    }

    return array;
}

function hideDropdownAndButton() {
    document.getElementById('dropdown').style.display = 'none';
    document.getElementById('lerJson').style.display = 'none';
}

function displayComment(questionIndex, answerIndex, checkbox) {
    var checkboxes = document.getElementsByClassName('checkboxLi');
    var checkboxTexts = document.getElementsByClassName('checkboxText');
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].classList.add('hidden');
        checkboxTexts[i].classList.add('hidden');
    }
    checkbox.parentElement.parentElement.classList.remove('hidden');
    checkbox.parentElement.querySelector('.checkboxText').classList.remove('hidden');
    var comment = data.questions[questionIndex].answers[answerIndex].comment;
    var feedback = data.questions[questionIndex].answers[answerIndex].isCorrect ? 'Correto!' : 'Errado!';
    document.getElementById('feedback').innerHTML = feedback;
    document.getElementById('commentText').innerHTML = comment;
    if (!data.questions[questionIndex].answers[answerIndex].isCorrect) {
        document.getElementById('ratingSection').style.display = 'none';
        document.getElementById('tryAgain').style.display = 'block';
    } else {
        document.getElementById('tryAgain').style.display = 'none';
        document.getElementById('ratingSection').style.display = 'block';
    }
}

function saveRating() {
    var rating = document.getElementById('rating').value;
    console.log('Avaliação salva: ' + rating);
    // Aqui você salvaria a avaliação no servidor.
    novaInstancia();  // Chame a função para mostrar o botão "Responder Nova Instância"
}


function refreshPage() {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    var checkboxTexts = document.getElementsByClassName('checkboxText');

    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = false;  // Desmarca o checkbox
        checkboxes[i].parentNode.parentNode.classList.remove('hidden');
        checkboxTexts[i].classList.remove('hidden');
    }

    document.getElementById('feedback').innerHTML = '';
    document.getElementById('commentText').innerHTML = '';
    document.getElementById('tryAgain').style.display = 'none';
    document.getElementById('ratingSection').style.display = 'hidden';
}

function getSelectedInstanceInfo() {
    var selectedFile = document.getElementById('arquivo').value;
    var selectedQuestion = document.querySelector('input[type="checkbox"]:checked');
    var selectedRating = document.getElementById('rating').value;

    if (data && selectedFile && selectedQuestion && selectedRating) {
        var instanceInfo = {
            title: data.title,
            situation: data.situation,
            question: data.questions[selectedQuestion.name.split("_")[1]].question,
            selectedAnswer: data.questions[selectedQuestion.name.split("_")[1]].answers[selectedQuestion.value].answer,
            rating: selectedRating
        };

        return instanceInfo;
    } else {
        console.error('Não foi possível coletar informações completas.');
        return null;
    }
}



function novaInstancia() {
    document.getElementById('novaInstancia').style.display = '';

}

function enviadados() {
    var instanceInfo = getSelectedInstanceInfo();

    if (instanceInfo) {
        // Crie um objeto JSON com as informações coletadas
        var responseInfo = {
            title: instanceInfo.title,
            situation: instanceInfo.situation,
            question: instanceInfo.question,
            selectedAnswer: instanceInfo.selectedAnswer,
            rating: instanceInfo.rating
        };

        // Converta o objeto JSON em uma string JSON
        var jsonString = JSON.stringify(responseInfo);

        // Use AJAX para enviar os dados JSON para o servidor
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    console.log('Dados salvos com sucesso.');
                    window.alert('Instância salva!');
                    window.location.reload(true); // Recarrega a página apenas após o sucesso
                } else {
                    console.error('Erro ao salvar os dados.');
                }
            }
        };
        xhr.open('POST', 'salvar_resposta.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.send(jsonString);
    }
}



</script>

<div id="output"></div>

<div id="comment">
    <p id="feedback"></p>
    <p id="commentText"></p>
    <button id="tryAgain" onclick="refreshPage()" style="display: none;">Tentar Novamente</button>
    <div id="ratingSection" style="display: none;">
        <p>Avalie a adequação dessa resposta. 1 indica menor adequação e 10 indica maior adequação da resposta.</p>
        <select id="rating" onchange="saveRating()">
            <option value="" selected>Dê Sua Nota</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
        </select>
    </div>
    <button id="novaInstancia" onclick="enviadados()" style="display: none;">Responder Nova Instância</button>

</div>
<script src="includes/cores.js"></script>
</body>
</html>
