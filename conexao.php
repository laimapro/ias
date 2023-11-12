<?php

// Conectar ao banco de dados (substitua pelos seus próprios dados de conexão)
    $servername = "localhost";
    $username = "limafj_kawanias";
    $password = ".gA9eDoC1j45";
    $dbname = "limafj_ias";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica se a conexão foi bem sucedida
    if ($conn->connect_error) {
        die("Conexão ao banco de dados falhou");
    }

?>