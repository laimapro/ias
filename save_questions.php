<?php

include("conexao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST['jsonData']; // Dados do JSON
    $title = $_POST['title']; // Título da instância

    // Nome do arquivo a ser salvo (com o título da instância)
    $filename = "instancias/" . $title . ".json";

    // Salvar os dados no arquivo
    file_put_contents($filename, $data);

    $sql = "INSERT INTO instancias (nomeArquivo, arquivo, dataCriado) VALUES ('$title', '$filename', NOW())";

    // Executa a consulta de inserção
    if ($conn->query($sql) === TRUE) {
        
    } else {
        echo "Erro ao inserir o registro: " . $conn->error;
    }



    // Oferecer o arquivo para download
    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
    header('Content-Length: ' . filesize($filename));
    readfile($filename);
}
?>
