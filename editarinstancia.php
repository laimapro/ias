
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

<form onsubmit="return exibirConteudoJson()"> <!-- Adicionando uma função JS ao formulário -->
    <?php
    $directory = 'instancias'; // Pasta onde estão os arquivos JSON

    // Verifique se a pasta existe
    if (is_dir($directory)) {
        // Abre o diretório
        if ($handle = opendir($directory)) {
            echo '<select id="arquivo" name="arquivo">';
            // Lê os arquivos
            while (($file = readdir($handle)) !== false) {
                if (pathinfo($file, PATHINFO_EXTENSION) == 'json') {
                    echo '<option value="' . $file . '">' . $file . '</option>';
                }
            }
            echo '</select>';
            closedir($handle);
        }
    } else {
        echo 'A pasta não existe.';
    }
    ?>

    <button type="submit">Editar</button> <br><br><!-- Botão de edição -->
</form>

<div id="conteudoJson"></div> <!-- Div para exibir o conteúdo do JSON -->
<button onclick="salvarDados()">Salvar</button>
<button onclick="window.location.href='index.php'" aria-label="Voltar" role="button" accesskey="v" title="Clique para voltar">Voltar</button>
<script>
function exibirConteudoJson() {
    event.preventDefault(); // Prevenir a submissão do formulário

    const selectedFile = document.getElementById('arquivo').value;

    if (selectedFile) {
        const filePath = 'instancias/' + selectedFile;

        const dropdown = document.getElementById('arquivo');
        const editarButton = document.querySelector('button[type="submit"]');
        dropdown.style.display = 'none';
        editarButton.style.display = 'none';

        // Fazer uma XMLHttpRequest para carregar o conteúdo do arquivo JSON
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const conteudoJson = JSON.parse(xhr.responseText);

                // Exibir o título, situação, pergunta e respostas com caixas de seleção
                const conteudoDiv = document.getElementById('conteudoJson');
                conteudoDiv.innerHTML = `
                    <label for="titulo">Título:</label>
                    <textarea id="titulo" name="titulo">${conteudoJson.title}</textarea><br>
                    <label for="situacao">Situação:</label>
                    <textarea id="situacao" name="situacao">${conteudoJson.situation}</textarea><br>
                    <label for="pergunta">Pergunta:</label>
                    <textarea id="pergunta" name="pergunta">${conteudoJson.questions[0].question}</textarea><br>
                    <label for="respostas">Respostas:</label>
                `;

                // Iterar sobre as respostas e criar elementos de textarea com caixas de seleção para cada uma
                conteudoJson.questions[0].answers.forEach((answer, index) => {
                    const isChecked = answer.isCorrect ? 'checked' : '';
                    conteudoDiv.innerHTML += `
                        <div>
                            Resposta: <textarea id="respostaTexto${index + 1}" name="respostaTexto${index + 1}">${answer.answer}</textarea>
                            Está correto? <input type="checkbox" id="resposta${index + 1}" name="resposta${index + 1}" ${isChecked}>
                            Comentário: <textarea id="comentario${index + 1}" name="comentario${index + 1}">${answer.comment}</textarea>
                        </div>
                    `;
                });
            }
        };
        xhr.open('GET', filePath, true);
        xhr.send();
    } else {
        alert('Selecione um arquivo JSON.');
    }

    return false;
}


function salvarDados() {
    const titulo = document.getElementById('titulo').value;
    const situacao = document.getElementById('situacao').value;
    const pergunta = document.getElementById('pergunta').value;

    const respostas = [];
    const respostaTextareas = document.querySelectorAll('textarea[id^="respostaTexto"]');
    const checkboxRespostas = document.querySelectorAll('input[type="checkbox"]');
    const comentarioTextareas = document.querySelectorAll('textarea[id^="comentario"]');

    respostaTextareas.forEach((textarea, index) => {
        const resposta = textarea.value;
        const isCorrect = checkboxRespostas[index].checked;
        const comentario = comentarioTextareas[index].value;

        respostas.push({ answer: resposta, isCorrect, comment: comentario });
    });

    const jsonData = {
        title: titulo,
        situation: situacao,
        questions: [{
            question: pergunta,
            answers: respostas
        }]
    };

    const jsonString = JSON.stringify(jsonData, null, 2);

    // Send the JSON data to the server to save as a file
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                alert('Arquivo salvo com sucesso!');
            } else {
                alert('Ocorreu um erro ao salvar o arquivo.');
            }
        }
    };
    xhr.open('POST', 'save_file.php');  // Adjust the PHP file name accordingly
    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
    xhr.send(jsonString);
}

</script>
<script src="includes/cores.js"></script>
</body>
</html>
