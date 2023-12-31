<?php
include('../conexao.php');

try {
    $query = "SELECT * FROM empresa";
    $stmt = $conexao->query($query);

    echo "<h2>Empresas Cadastradas</h2>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Nome da Empresa</th>
            <th>Nome do Projeto</th>
            <th>Codigo Projeto</th>
            <th>Nome do Coordenador</th>
            <th>Nome do Gerente</th>
          </tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>{$row['nomeEmpresa']}</td>
                <td>{$row['nomeProjetoConvenio']}</td>
                <td>{$row['codigoProjetoConvenio']}</td>
                <td>{$row['fkCoordenador']}</td>
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
    <title>ADMIN</title>
</head>
<body>

    <h2>Adicionar Projeto</h2>

    <form action="cadastra_projeto.php" method="post">

        <label for="nomeProjeto">Nome do projeto:</label>
        <input type="text" id="nomeProjeto" name="nomeProjeto" require>

        <input type="text" id="codigoProjetoConvenio" name="codigoProjetoConvenio" value="<?php echo rand(1000, 9999); ?>">

        <input type="submit" value="Adicionar Projeto">
    </form>

    


<h2>Adicionar Coordenador</h2>
<form action="cadastrar_coordenador.php" method="post">
    <label for="projetos">Escolha um Projeto:</label>
    <select name="projetos" id="projetos">
        <?php
        $stmt = $conexao->query('SELECT * FROM empresa');

        while ($row = $stmt->fetch()) {
            echo '<option value="' . $row['codigoProjetoConvenio'] . '">' . $row['nomeProjetoConvenio'] . '</option>';
        }
        ?>
    </select>

    <br>

    <!-- Adicionar campo de input de e-mail -->
    <label for="email">Digite o seu e-mail:</label>
    <input type="email" name="email" id="email" required>

    <br>

    <input type="submit" value="Selecionar">
</form>



    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $emailCoordenador = $_POST['emailCoordenador'];
        $codigoGerado = $_POST['codigoGerado'];

        echo "<p>E-mail do coordenador adicionado: $emailCoordenador</p>";
    }
    ?>

</body>
</html>

