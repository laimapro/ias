<?php
include('../conexao.php');

    $codigoProjetoSelecionado = $_POST['projetos'];
    $email = isset($_POST['email']) ? $_POST['email'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {

        // Constrói o link com o código gerado
        $link = "https://associadosdainclusao.com.br/ias/admin/cadastro_coordenador.php?codigo=$codigoProjetoSelecionado";

        // Envia o código gerado por e-mail
        $assunto = 'Cadastro Coordenador';
        $mensagem = " Clique no link a seguir para cadastrar como Coordenador: $link";
        $headers = 'From: contato@laima.pro'; // Substitua pelo seu endereço de e-mail

        mail($email, $assunto, $mensagem, $headers);

        // Exibe mensagem de sucesso
        echo "<p>Coordenador cadastrado com sucesso. Código enviado para o e-mail.</p>";

    } catch (PDOException $e) {
        die("Erro: " . $e->getMessage());
    }
} else {
    // Redireciona se a requisição não for do tipo POST
    header("Location: index.php");
    exit();
}


?>
