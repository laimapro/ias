<?php
include('../conexao.php');
session_start();

if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];

    // Consulta na tabela empresa para verificar se o códigoProjetoConvenio existe
    $consulta_empresa = "SELECT * FROM empresa WHERE codigoProjetoConvenio = :codigo";
    $stmt = $conexao->prepare($consulta_empresa);
    $stmt->bindParam(':codigo', $codigo);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $projeto = $stmt->fetch(PDO::FETCH_ASSOC);
        $nomeProjeto = $projeto['nomeProjetoConvenio']; 

            echo '<h1>Cadastro Coordenador - Projeto: ' . $nomeProjeto . '</h1>';
            echo '<form action="processa_coordenador.php?codigo=' . urlencode($codigo) . '" method="post">';
            echo '  <label for="nome">Nome Completo:</label>';
            echo '  <input type="text" name="nome" id="nome" required><br>';

            echo '  <label for="nomeSocial">Nome Social:</label>';
            echo '  <input type="text" name="nomeSocial" id="nomeSocial"><br>';

            echo '  <label for="pronome">Pronome de Tratamento:</label>';
            echo '  <select name="pronome" id="pronome" required>';
            echo '    <option value="1">Senhor</option>';
            echo '    <option value="2">Senhora</option>';
            echo '    <option value="3">Senhorita</option>';
            echo '    <option value="4">Mestre</option>';
            echo '    <option value="5">Doutor</option>';
            echo '    <option value="6">Doutora</option>';
            echo '    <option value="7">Coordenador</option>';
            echo '    <option value="8">Coordenadora</option>'; 
            echo '  </select><br>';

            echo '  <label for="pronomeRef">Pronome de Referência:</label>';
            echo '  <select name="pronomeRef" id="pronomeRef" required>';
            echo '    <option value="2">Ele</option>';
            echo '    <option value="1">Ela</option>';
            echo '    <option value="3">Elu</option>';
            echo '  </select><br>';

            echo '  <label for="area">Área de Atuação:</label>';
            echo '  <input type="text" name="area" id="area" required><br>';

            echo '  <label for="email">Email:</label>';
            echo '  <input type="email" name="email" id="email" required><br>';

            echo '  <label for="senha">Senha:</label>';
            echo '  <input type="password" name="senha" id="senha" required><br>';

            echo '  <input type="submit" value="Enviar">';
            echo '</form>';
        } else {
            echo "<p>Código não encontrado</p>";
        }
    } else {
        echo "<p>Código não informado.</p>";
    }
?>
    