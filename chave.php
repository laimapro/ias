<?php
// Inclua o arquivo de conexão
require_once 'conexao.php';

// Variável para armazenar o nome do projeto
$nomeProjeto = '';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém a chave do projeto ou convênio do formulário
    $chaveProjeto = isset($_POST['chaveProjeto']) ? $_POST['chaveProjeto'] : '';

    // Verifica se a chave não está vazia
    if (!empty($chaveProjeto)) {
        try {
            // Prepara a consulta SQL
            $sql = "SELECT * FROM empresa WHERE codigoProjetoConvenio = :chaveProjeto";

            // Prepara e executa a declaração usando PDO
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':chaveProjeto', $chaveProjeto, PDO::PARAM_STR);
            $stmt->execute();

            // Verifica se há alguma linha correspondente
            if ($stmt->rowCount() > 0) {
                // Obtém o nome do projeto
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $nomeProjeto = $row['nomeProjetoConvenio'];

                // Mostra o alerta
                echo "<script>
                        alert('Esta ação lhe cadastrará no projeto $nomeProjeto.');
                        window.location.href = 'cadastro.php?chave=$chaveProjeto';
                      </script>";
            } else {
                echo "Número não encontrado";
            }
        } catch (PDOException $e) {
            echo "Erro na execução da consulta: " . $e->getMessage();
        }
    } else {
        echo "Por favor, preencha a chave do projeto ou convênio.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação de Projeto ou Convênio</title>
</head>
<body>
    <h1>Chave do Projeto ou convênio</h1>
    <form method="post">
        <label for="chaveProjeto">Digite a chave do projeto ou convênio:</label>
        <input type="text" id="chaveProjeto" name="chaveProjeto" required>
        <button type="submit">Verificar</button>
    </form>
</body>
</html>
