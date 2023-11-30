<?php
include('../conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter os dados do formulário
    $nomeProjeto = $_POST['nomeProjeto'];
    $codigoProjetoConvenio = $_POST['codigoProjetoConvenio'];

    try {
        // Preparar a consulta SQL para inserção, incluindo dataCadastro
        $query = "INSERT INTO empresa (nomeProjetoConvenio, codigoProjetoConvenio, dataCadastro) VALUES (:nomeProjeto, :codigoProjetoConvenio, NOW())";
        $stmt = $conexao->prepare($query);

        // Bind dos parâmetros
        $stmt->bindParam(':nomeProjeto', $nomeProjeto);
        $stmt->bindParam(':codigoProjetoConvenio', $codigoProjetoConvenio);

        // Executar a consulta
        $stmt->execute();

        
        header("Location: dashboard.php");
        exit();
    } catch (PDOException $e) {
        // Tratar erros, por exemplo, exibir uma mensagem de erro
        die("Erro: " . $e->getMessage());
    }
} else {
    // Se não for uma requisição POST, redirecionar para a página principal ou realizar outra ação desejada
    header("Location: index.php");
    exit();
}
?>
