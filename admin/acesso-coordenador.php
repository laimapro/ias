<?php
include('../conexao.php');
session_start(); 

if (!isset($_SESSION['idCoordenador'])) {
    header("Location: ../login.php");
    exit();
}


$idCoordenador = $_SESSION['idCoordenador'];

try {
    $query = "SELECT * FROM empresa WHERE fkCoordenador = $idCoordenador";
    $stmt = $conexao->query($query);

    echo "<h2>Empresas Cadastradas</h2>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Nome da Empresa</th>
            <th>Nome do Projeto</th>
            <th>Nome do Gerente</th>
          </tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>{$row['nomeEmpresa']}</td>
                <td>{$row['nomeProjetoConvenio']}</td>
                <td>{$row['fkGerente']}</td>
              </tr>";
    }

    echo "</table>";

} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IAS  - COORDENADOR</title>
</head>
<body>
    <h2>Adicionar Gerente</h2>
    
<form action="cadastrar_gerente.php" method="post">
    <label for="projetos">Escolha um Projeto:</label>
    <select name="projetos" id="projetos">
        <?php
        $stmt = $conexao->query("SELECT * FROM empresa WHERE fkCoordenador = $idCoordenador");

        while ($row = $stmt->fetch()) {
            echo '<option value="' . $row['codigoProjetoConvenio'] . '">' . $row['nomeProjetoConvenio'] . '</option>';
        }
        ?>
    </select>

    <br>

    <label for="email">Digite o seu e-mail:</label>
    <input type="email" name="email" id="email" required>

    <br>

    <input type="submit" value="Selecionar">
</form>
</body>
</html>

