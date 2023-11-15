<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupere os dados do formulário
    $email = $_POST["email"];
    $codigo = $_POST["codigo"];

    // Enviar e-mail
    $assunto = "Código de Verificação";
    $mensagem = "Seu código de verificação é: $codigo";
    $headers = "From: contato@laima.pro"; // Substitua pelo seu endereço de e-mail

    if (mail($email, $assunto, $mensagem, $headers)) {
        echo "Email enviado com sucesso.";
    } else {
        echo "Erro ao enviar o e-mail. Verifique suas configurações de servidor.";
    }
} else {
    echo "Acesso inválido.";
}

?>
