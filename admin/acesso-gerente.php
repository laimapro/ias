<?php
session_start();

if (!isset($_SESSION['idGerente'])) {
    header("Location: ../login.php");
    exit();
}



include('../conexao.php');

$idGerente = $_SESSION['idGerente'];

$sql = "SELECT * FROM empresa WHERE fkGerente = :idGerente";

$stmt = $conexao->prepare($sql);

$stmt->bindParam(':idGerente', $idGerente, PDO::PARAM_INT);

$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

function exibirFormularioCadastro($cnpj) {
    echo "<form method='post' action='update-gerente-empresa.php'>";
    echo "CNPJ: <input type='text' name='cnpj' id='cnpj' onblur='preencherNomeEmpresa()' value='$cnpj'><br>";
    echo "Nome da Empresa: <span id='nomeEmpresa'></span><br>";
    echo "Endereço: <span id='endereco'></span><br>";
    echo "Cidade: <span id='cidade'></span><br>";
    echo "CEP: <span id='cep'></span><br>";
    echo "Telefone: <input type='text' name='telefone' required><br>";
    echo "<input type='hidden' name='nomeEmpresa' id='hiddenNomeEmpresa'>";
    echo "<input type='hidden' name='enderecoEmpresa' id='hiddenEnderecoEmpresa'>";
    echo "<input type='hidden' name='cidadeEmpresa' id='hiddenCidadeEmpresa'>";
    echo "<input type='hidden' name='cepEmpresa' id='hiddenCepEmpresa'>";
    echo "<input type='submit' value='Cadastrar Empresa'>";
    echo "</form>";
}



function exibirInformacoesEmpresa($empresa) {
    echo "Nome do Projeto ou Convênio: " . $empresa['nomeProjetoConvenio'] . "<br>";
    echo "Código do Projeto ou Convênio: " . $empresa['codigoProjetoConvenio'] . "<br>";
    
    echo "<hr>";
}


function exibirUsuariosPorEmpresa($idEmpresa) {
    global $conexao;

    $sql = "SELECT * FROM usuarios WHERE idEmpresa = :idEmpresa";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
    $stmt->execute();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($usuarios) > 0) {
        echo "<h1>Participantes da empresa</h1>";
        echo "<table border='1'>";
        echo "<tr><th>Nome</th><th>Função</th></tr>";

        foreach ($usuarios as $usuario) {
            echo "<tr>";
            echo "<td>" . $usuario['nomeCompleto'] . "</td>";
            echo "<td>" . $usuario['cargoFuncao'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "<br>";
        // Dentro da função exibirInformacoesEmpresa
        ?>

        <form action="adicionar_participante.php" method="post">
            <label for="email">Digite o email do participante</label>
            <input type="email" name="email" id="email">
            <input type="text" name="codigoProjetoConvenio" value="<?php echo $idEmpresa; ?>">
            <input type="submit" value="Mandar código">
        </form>

        <?php
    } else {
        echo "Nenhum usuário associado a esta empresa.";
    }
}


if (count($result) > 0) {
    foreach ($result as $row) {
        if (empty($row['nomeEmpresa'])) {
            exibirFormularioCadastro($row['cnpj']);
        } else {
            exibirInformacoesEmpresa($row);
            exibirUsuariosPorEmpresa($row['codigoProjetoConvenio']);
        }
    }
} else {
    echo "Nenhuma empresa associada ao gerente.";
}


?>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
  function preencherNomeEmpresa() {
    var cnpj = $('#cnpj').val();

    $.ajax({
        url: 'buscar_nome_empresa.php',
        type: 'POST',
        data: { cnpj: cnpj },
        dataType: 'json',
        success: function(response) {
            $('#nomeEmpresa').text(response.nome);
            $('#endereco').text(response.endereco);
            $('#cidade').text(response.cidade);
            $('#cep').text(response.cep);

            $('#hiddenNomeEmpresa').val(response.nome);
            $('#hiddenEnderecoEmpresa').val(response.endereco);
            $('#hiddenCidadeEmpresa').val(response.cidade);
            $('#hiddenCepEmpresa').val(response.cep);
        },
        error: function() {
        }
    });
}


</script>
