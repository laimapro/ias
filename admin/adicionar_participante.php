<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];
    $codigo = $_POST['codigoProjetoConvenio'];


    try {

        $link = "https://associadosdainclusao.com.br/ias/chave.php";

        $assunto = 'Código acesso Participante';
        $mensagem = " Clique no link a seguir para cadastrar como Participante e use o codigo($codigo): $link";
        $headers = 'From: contato@laima.pro'; 

        mail($email, $assunto, $mensagem, $headers);

        echo "<p>Código enviado para o e-mail do participante.</p>";

    } catch (PDOException $e) {
        die("Erro: " . $e->getMessage());
    }

} else {
    echo "Erro: Requisição inválida.";
}
?>
