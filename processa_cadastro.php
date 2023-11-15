<?php
include('conexao.php');

// Recuperar os dados do formulário
$nomeCompleto = $_POST['nomeCompleto'];
$nomeExibicao = $_POST['nomeExibicao'];
$pronomeTratamento = $_POST['pronomeTratamento'];
$pronomesReferencia = $_POST['pronomesReferencia'];
$dataNascimento = $_POST['dataNascimento'];
$sexo = $_POST['sexo'];
$genero = $_POST['genero'];
$escolaridade = $_POST['escolaridade'];
$cargoFuncao = $_POST['cargoFuncao'];
$anoAdmissao = $_POST['anoAdmissao'];
$condicaoDeficiencia = $_POST['condicaoDeficiencia'];
$email = $_POST['email'];
$senha = password_hash($_POST['senha'], PASSWORD_BCRYPT); // Criptografar a senha

try {
    // Preparar a consulta SQL usando parâmetros nomeados
    $sql = "INSERT INTO usuarios (nomeCompleto, nomeExibicao, fkPronomeTratamento, fkPronomeReferencia, dataNascimento, fkSexo, fkGenero, fkEscolaridade, cargoFuncao, anoAdmissao, fkDeficiencia, email, senha, datacadastrado) 
            VALUES (:nomeCompleto, :nomeExibicao, :pronomeTratamento, :pronomesReferencia, :dataNascimento, :sexo, :genero, :escolaridade, :cargoFuncao, :anoAdmissao, :condicaoDeficiencia, :email, :senha, NOW())";
    
    $stmt = $conexao->prepare($sql);

    // Vincular os parâmetros e executar a consulta
    $stmt->bindParam(':nomeCompleto', $nomeCompleto);
    $stmt->bindParam(':nomeExibicao', $nomeExibicao);
    $stmt->bindParam(':pronomeTratamento', $pronomeTratamento);
    $stmt->bindParam(':pronomesReferencia', $pronomesReferencia);
    $stmt->bindParam(':dataNascimento', $dataNascimento);
    $stmt->bindParam(':sexo', $sexo);
    $stmt->bindParam(':genero', $genero);
    $stmt->bindParam(':escolaridade', $escolaridade);
    $stmt->bindParam(':cargoFuncao', $cargoFuncao);
    $stmt->bindParam(':anoAdmissao', $anoAdmissao);
    $stmt->bindParam(':condicaoDeficiencia', $condicaoDeficiencia);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);

    $stmt->execute();

    echo "Cadastro realizado com sucesso!";
} catch (PDOException $e) {
    die("Erro na execução da consulta: " . $e->getMessage());
} finally {
    // Fechar a conexão
    $conexao = null;
}
?>
