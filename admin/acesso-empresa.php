<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['idGerente'])) {
    header("Location: ../login.php");
    exit();
}


include('../conexao.php');

try {
    // Obtém o códigoProjetoConvenio da tabela empresa
    $idEmpresa = $_SESSION['idGerente'];
    $consultaEmpresa = "SELECT codigoProjetoConvenio FROM empresa WHERE idEmpresa = :idEmpresa";
    $stmtEmpresa = $conexao->prepare($consultaEmpresa);
    $stmtEmpresa->bindParam(':idEmpresa', $idEmpresa);
    $stmtEmpresa->execute();

    if ($stmtEmpresa->rowCount() > 0) {
        $resultadoEmpresa = $stmtEmpresa->fetch(PDO::FETCH_ASSOC);
        $codigoProjetoConvenio = $resultadoEmpresa['codigoProjetoConvenio'];

        // Exibe o códigoProjetoConvenio
        echo "Código do Projeto de Convênio: $codigoProjetoConvenio";

        // Consulta a quantidade de participantes na tabela usuarios
        $consultaParticipantes = "SELECT COUNT(*) AS quantidade FROM usuarios WHERE idEmpresa = :codigoProjetoConvenio";
        $stmtParticipantes = $conexao->prepare($consultaParticipantes);
        $stmtParticipantes->bindParam(':codigoProjetoConvenio', $codigoProjetoConvenio);
        $stmtParticipantes->execute();

        if ($stmtParticipantes->rowCount() > 0) {
            $resultadoParticipantes = $stmtParticipantes->fetch(PDO::FETCH_ASSOC);
            $quantidadeParticipantes = $resultadoParticipantes['quantidade'];

            // Exibe a quantidade de participantes
            echo "<br>Quantidade de Participantes: $quantidadeParticipantes";

            // Consulta os participantes na tabela usuarios
            $consultaListaParticipantes = "SELECT nomeCompleto, cargoFuncao FROM usuarios WHERE idEmpresa = :codigoProjetoConvenio";
            $stmtListaParticipantes = $conexao->prepare($consultaListaParticipantes);
            $stmtListaParticipantes->bindParam(':codigoProjetoConvenio', $codigoProjetoConvenio);
            $stmtListaParticipantes->execute();

            if ($stmtListaParticipantes->rowCount() > 0) {
                echo "<br>Participantes:";
                while ($participante = $stmtListaParticipantes->fetch(PDO::FETCH_ASSOC)) {
                    echo "<br>{$participante['nomeCompleto']} - {$participante['cargoFuncao']}";
                }
            } else {
                echo "<br>Não há participantes registrados.";
            }
        } else {
            echo "<br>Erro ao obter a quantidade de participantes.";
        }
    } else {
        echo "Erro ao obter informações da empresa.";
    }
} catch (PDOException $e) {
    echo "Erro na consulta. Tente novamente.";
}
?>

<br>
<a href="sair.php">Ir para a página inicial</a>
