<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['idGerente'])) {
    header("Location: ../login.php");
    exit();
}

// Obtém o id do gerente da sessão
$idGerente = $_SESSION['idGerente'];

include('../conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cnpj = $_POST['cnpj'];
    $nomeEmpresa = $_POST['nomeEmpresa'];
    $enderecoEmpresa = $_POST['enderecoEmpresa'];
    $cidadeEmpresa = $_POST['cidadeEmpresa'];
    $cepEmpresa = $_POST['cepEmpresa'];
    $telefone = $_POST['telefone'];


        $sql = "UPDATE empresa 
                SET cnpj = :cnpj, 
                    nomeEmpresa = :nomeEmpresa, 
                    endereco = :enderecoEmpresa, 
                    cidade = :cidadeEmpresa, 
                    cep = :cepEmpresa, 
                    telefone = :telefone 
                WHERE fkGerente = :idGerente";

        // Prepara a consulta SQL
        $stmt = $conexao->prepare($sql);

        // Binda os parâmetros
        $stmt->bindParam(':cnpj', $cnpj);
        $stmt->bindParam(':nomeEmpresa', $nomeEmpresa);
        $stmt->bindParam(':enderecoEmpresa', $enderecoEmpresa);
        $stmt->bindParam(':cidadeEmpresa', $cidadeEmpresa);
        $stmt->bindParam(':cepEmpresa', $cepEmpresa);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':idGerente', $idGerente);

        // Executa a consulta SQL
        $stmt->execute();

        echo "Empresa cadastrada com sucesso!<br>";
        echo"<a href='acesso-gerente.php'>Voltar</a>";
}

?>
