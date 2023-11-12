<?php

include("conexao.php");
// Recebe os dados enviados via POST
$data = file_get_contents("php://input");

// Converte a string JSON recebida em um objeto PHP
$responseInfo = json_decode($data);

if ($responseInfo && isset($responseInfo->title)) {
    // Remove caracteres especiais e espaços no título para criar um nome de arquivo seguro
    $cleanedTitle = preg_replace('/[^a-zA-Z0-9]+/', '_', $responseInfo->title);

    // Obtém a hora atual no formato HHMMSS
    $currentHour = date('His');

    // Define o caminho completo e o nome do arquivo onde os dados serão salvos com a hora
    $filePath = 'respostas/';
    $filename = $filePath . 'resposta_instancia_' . $cleanedTitle . '_' . $currentHour . '.json';

    // Salva os dados no arquivo JSON
    $saved = file_put_contents($filename, json_encode($responseInfo));

    if ($saved !== false) {
         // Prepara a consulta SQL para inserir na tabela
         $sql = "INSERT INTO avaliado (nomeArquivo, arquivo, dataCriado) VALUES ('$cleanedTitle', '$filename', NOW())";

         if ($conn->query($sql) === TRUE) {
             echo "Dados inseridos no banco de dados com sucesso.";
         } else {
             echo "Erro ao inserir dados no banco de dados: " . $conn->error;
         }
 
         // Fecha a conexão
         $conn->close();
    } else {
        echo 'Erro ao salvar os dados.';
    }
} else {
    echo 'Erro: Dados inválidos recebidos.';
}
?>
