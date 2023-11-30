<?php
include('../conexao.php');

    $codigoProjetoSelecionado = $_POST['projetos'];
    $email = isset($_POST['email']) ? $_POST['email'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {

        $link = "https://associadosdainclusao.com.br/ias/admin/cadastro_gerente.php?codigo=$codigoProjetoSelecionado";

        $assunto = 'Cadastro Gerente';
        $mensagem = " Clique no link a seguir para cadastrar como Gerente: $link";
        $headers = 'From: contato@laima.pro'; 

        mail($email, $assunto, $mensagem, $headers);

        echo "<p>Coordenador cadastrado com sucesso. Código enviado para o e-mail.</p>";

    } catch (PDOException $e) {
        die("Erro: " . $e->getMessage());
    }
} else {
    header("Location: index.php");
    exit();
}


?>
