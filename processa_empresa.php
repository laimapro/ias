<?php
// Include your database connection file here
include('conexao.php');
session_start(); // Inicia ou retoma a sessão

// Recuperar os dados do formulário
$nomeProjeto = $_POST['nomeProjeto'];
$nomeEmpresa = $_POST['nomeEmpresa'];

// Gerar um código aleatório de 6 dígitos
$codigoEmpresa = rand(100000, 999999);

$cnpj = $_POST['cnpj'];
$gerenteProjeto = $_POST['gerenteProjeto'];
$coordenadorProjeto = $_POST['coordenadorProjeto'];
$email = $_POST['email'];
$senha = password_hash($_POST['senha'], PASSWORD_BCRYPT); // Criptografar a senha

try {
    // Preparar a consulta SQL usando parâmetros nomeados
    $sql = "INSERT INTO empresa (codigoProjetoConvenio, nomeProjetoConvenio, nomeEmpresa, cnpj, nomeGerente, nomeCoordenador, email, senha, dataCadastro) 
            VALUES (:codigoEmpresa, :nomeProjeto, :nomeEmpresa, :cnpj, :gerenteProjeto, :coordenadorProjeto, :email, :senha, NOW())";

    $stmt = $conexao->prepare($sql);

    // Vincular os parâmetros e executar a consulta
    $stmt->bindParam(':codigoEmpresa', $codigoEmpresa);
    $stmt->bindParam(':nomeProjeto', $nomeProjeto);
    $stmt->bindParam(':nomeEmpresa', $nomeEmpresa);
    $stmt->bindParam(':cnpj', $cnpj);
    $stmt->bindParam(':gerenteProjeto', $gerenteProjeto);
    $stmt->bindParam(':coordenadorProjeto', $coordenadorProjeto);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);

    $stmt->execute();

    // Redirecionar após o cadastro
    header("Location: admin/acesso-empresa.php");
} catch (PDOException $e) {
    die("Erro na execução da consulta: " . $e->getMessage());
} finally {
    // Fechar a conexão
    $conexao = null;
}
?>
