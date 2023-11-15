<?php

$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "ias";

try {
    $conexao = new PDO("mysql:host=$host;dbname=$banco;charset=utf8", $usuario, $senha);
    // Configurar o PDO para lançar exceções em caso de erros
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados");
}

?>