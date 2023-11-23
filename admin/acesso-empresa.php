<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['idEmpresa'])) {
    header("Location: ../login.php");
    exit();
}

include('../conexao.php');

try {
    // Obtém o códigoProjetoConvenio da tabela empresa
    $idEmpresa = $_SESSION['idEmpresa'];
    $consultaEmpresa = "SELECT codigoProjetoConvenio FROM empresa WHERE idEmpresa = :idEmpresa";
    $stmtEmpresa = $conexao->prepare($consultaEmpresa);
    $stmtEmpresa->bindParam(':idEmpresa', $idEmpresa);
    $stmtEmpresa->execute();

    if ($stmtEmpresa->rowCount() > 0) {
        $resultadoEmpresa = $stmtEmpresa->fetch(PDO::FETCH_ASSOC);
        $codigoProjetoConvenio = $resultadoEmpresa['codigoProjetoConvenio'];

        // Exibe o códigoProjetoConvenio
        echo "Código do Projeto de Convênio: $codigoProjetoConvenio";
    } else {
        echo "Erro ao obter informações da empresa.";
    }
} catch (PDOException $e) {
    echo "Erro na consulta. Tente novamente.";
}
?>
<a href="sair.php">Ir para a página inicial</a>