<?php

require 'vendor/autoload.php';  
require 'conexao.php'; 

use PhpOffice\PhpWord\IOFactory;



if (isset($_FILES['arquivoDocx'])) {
    // Diretório onde os arquivos DOCX serão salvos
    $uploadDir = 'uploads/';

    // Nome do arquivo temporário no servidor
    $tempFile = $_FILES['arquivoDocx']['tmp_name'];

    // Nome do arquivo original enviado pelo usuário
    $originalFileName = $_FILES['arquivoDocx']['name'];

    // Verifica se o arquivo é um arquivo DOCX
    $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
    if (strtolower($fileExtension) == 'docx') {
        // Gere um nome único para o arquivo
        $newFileName = uniqid('docx_') . '.docx';

        // Move o arquivo temporário para o diretório de upload
        move_uploaded_file($tempFile, $uploadDir . $newFileName);

        // Caminho para o arquivo DOCX carregado
        $arquivoDocx = $uploadDir . $newFileName;



$phpWord = IOFactory::load($arquivoDocx);

// Initialize an array to store the text
$textoArray = array();

// Iterate through the document and get the text
foreach ($phpWord->getSections() as $section) {
    foreach ($section->getElements() as $element) {
        if (method_exists($element, 'getElements')) {
            foreach ($element->getElements() as $e) {
                if (method_exists($e, 'getText')) {
                    $textoArray[] = $e->getText();
                }
            }
        } elseif (method_exists($element, 'getText')) {
            $textoArray[] = $element->getText();
        }
    }
}

// Initialize variables to store question details
$title = "";
$situation = "";
$questionText = "";
$answers = array();

// Initialize an array to store questions
$questionsArray = array();

foreach ($textoArray as $line) {
    if (strpos($line, "Título") !== false) {
        // If a new title is found, save the previous question details (if any)
        if (!empty($title)) {
            // Construct the question details
            $questionDetails = array(
                "question" => $questionText,
                "answers" => $answers
            );

            // Add the question details to the questions array
            $questionsArray[] = $questionDetails;

            // Construct the output array for the previous title
            $outputArray = array(
                "title" => $title,
                "situation" => $situation,
                "questions" => $questionsArray
            );

            // Convert the associative array to JSON
            $textoJSON = json_encode($outputArray);

            // Format the title to remove any invalid characters for a filename
            $cleanedTitle = preg_replace('/[^a-zA-Z0-9]/', '_', $title);

            // Path to the JSON file for the previous title in the "instancias" folder
            $arquivoJSON = 'instancias/' . $cleanedTitle . '.json';


            $sql = "INSERT INTO instancias (nomeArquivo, arquivo, dataCriado) VALUES ('$cleanedTitle', '$arquivoJSON', NOW())";
            if ($conn->query($sql) === TRUE) {
               
            } else {
                echo "Erro ao salvar no banco de dados: " . $conn->error;
            }
        



            // Save the JSON to the file
            file_put_contents($arquivoJSON, $textoJSON);

            // Clear the previous question details and answers for the new title
            $questionText = "";
            $answers = array();

            // Clear the questions array for the new title
            $questionsArray = array();

            // Update the title for the new question
            $title = trim(explode("Título:", $line)[1]);
        } else {
            // Update the title for the first question
            $title = trim(explode("Título:", $line)[1]);
        }
    } elseif (strpos($line, "Situação Geradora:") !== false) {
        $situation = trim(explode("Situação Geradora:", $line)[1]);
    } elseif (strpos($line, "Pergunta Geradora:") !== false) {
        $questionText = trim(explode("Pergunta Geradora:", $line)[1]);
    } elseif (strpos($line, "Resposta:") !== false) {
        $answerParts = explode("Comentário:", $line);
        $answerText = trim(explode("Resposta:", $answerParts[0])[1]);
        
        
        $comment = isset($answerParts[1]) ? trim($answerParts[1]) : "";
        
        $isCorrect = strpos($answerText, "(C)") !== false;
        $answerText = str_replace("(C)", "", $answerText);
        $answers[] = array(
            "answer" => trim($answerText),
            "isCorrect" => $isCorrect,
            "comment" => $comment
        );
    }
    elseif (strpos($line, "Comentário:") !== false) {
        $comment = trim(explode("Comentário:", $line)[1]);
        $last_index = count($answers) - 1;
        if (isset($answers[$last_index])) {
            $answers[$last_index]['comment'] = $comment;
        }
    }
    
}

$questionDetails = array(
    "question" => $questionText,
    "answers" => $answers
);

// Add the question details to the questions array for the last title
$questionsArray[] = $questionDetails;

// Construct the output array for the last title
$outputArray = array(
    "title" => $title,
    "situation" => $situation,
    "questions" => $questionsArray
);

// Convert the associative array to JSON for the last title
$textoJSON = json_encode($outputArray);

// Format the title to remove any invalid characters for a filename for the last title
$cleanedTitle = preg_replace('/[^a-zA-Z0-9]/', '_', $title);

// Path to the JSON file for the last title in the "instancias" folder
$arquivoJSON = 'instancias/' . $cleanedTitle . '.json';

// Save the JSON to the file for the last title
file_put_contents($arquivoJSON, $textoJSON);

echo 'Text extracted from the document and saved in JSON format for each title.';

} else {
    echo 'Por favor, faça o upload de um arquivo DOCX válido.';
}
}

?>


<!DOCTYPE html>
<html>
<head>
    <title>Processar Arquivo DOCX</title>
</head>
<body>
    <h1>Escolha um arquivo DOCX para processar</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="arquivoDocx" accept=".docx">
        <input type="submit" value="Processar Arquivo">
    </form>
</body>
</html>