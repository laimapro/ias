<?php
include('../conexao.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = isset($_GET['codigo']) ? filter_input(INPUT_GET, 'codigo', FILTER_SANITIZE_NUMBER_INT) : null;
    $nome = isset($_POST['nome']) ? filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING) : '';
    $nomeSocial = isset($_POST['nomeSocial']) ? filter_input(INPUT_POST, 'nomeSocial', FILTER_SANITIZE_STRING) : '';
    $pronome = isset($_POST['pronome']) ? filter_input(INPUT_POST, 'pronome', FILTER_SANITIZE_NUMBER_INT) : '';
    $pronomeRef = isset($_POST['pronomeRef']) ? filter_input(INPUT_POST, 'pronomeRef', FILTER_SANITIZE_NUMBER_INT) : '';
    $area = isset($_POST['area']) ? filter_input(INPUT_POST, 'area', FILTER_SANITIZE_STRING) : '';
    $email = isset($_POST['email']) ? filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL) : '';
    $senha = isset($_POST['senha']) ? $_POST['senha'] : '';


    $senhaHash = password_hash($senha, PASSWORD_BCRYPT);

    $sql = "INSERT INTO gerente (nomeGerente, nomesocial, fkPronomeTratamento , fkPronomeReferencia, areaAtuacao, emailGerente, senhaGerente, dataCadastro) 
            VALUES (:nome, :nomeSocial, :pronome, :pronomeRef, :area, :email, :senhaHash, NOW())";
    
    $stmt = $conexao->prepare($sql);

    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':nomeSocial', $nomeSocial);
    $stmt->bindParam(':pronome', $pronome);
    $stmt->bindParam(':pronomeRef', $pronomeRef);
    $stmt->bindParam(':area', $area);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senhaHash', $senhaHash);

    if ($stmt->execute()) {
        // Obter o ID do coordenador inserido
        $idGerente = $conexao->lastInsertId();

        // Atualiza a tabela empresa
        $updateSql = "UPDATE empresa SET fkGerente = :idGerente WHERE codigoProjetoConvenio = :codigo";
        $updateStmt = $conexao->prepare($updateSql);
        $updateStmt->bindParam(':idGerente', $idGerente);
        $updateStmt->bindParam(':codigo', $codigo);

        if($updateStmt->execute()){
            echo "Gerente cadastrado e empresa atualizada com sucesso!";
        } else {
            echo "Gerente cadastrado, mas erro ao atualizar a empresa.";
        }
    } else {
        echo "Erro ao cadastrar Gerente.";
    }
} else {
    // Se o formulário não foi enviado, redireciona de volta para o formulário
    header('Location: cadastro_gerente.php');
}
?>
