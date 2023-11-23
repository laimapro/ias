<?php
include('conexao.php');
session_start(); // Inicia ou retoma a sessão

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    try {
        $consultaUsuarios = "SELECT idUsuario, senha FROM usuarios WHERE email = :email";
        $stmtUsuarios = $conexao->prepare($consultaUsuarios);
        $stmtUsuarios->bindParam(':email', $email);
        $stmtUsuarios->execute();

        if ($stmtUsuarios->rowCount() > 0) {
            $resultadoUsuarios = $stmtUsuarios->fetch(PDO::FETCH_ASSOC);

            if (password_verify($senha, $resultadoUsuarios['senha'])) {
                $_SESSION['idUsuario'] = $resultadoUsuarios['idUsuario'];
                header("Location: home.php");
            } else {
                echo "Credenciais inválidas. Tente novamente.";
            }
        } else {
            $consultaEmpresa = "SELECT idEmpresa, senha FROM empresa WHERE email = :email";
            $stmtEmpresa = $conexao->prepare($consultaEmpresa);
            $stmtEmpresa->bindParam(':email', $email);
            $stmtEmpresa->execute();

            if ($stmtEmpresa->rowCount() > 0) {
                $resultadoEmpresa = $stmtEmpresa->fetch(PDO::FETCH_ASSOC);

                if (password_verify($senha, $resultadoEmpresa['senha'])) {
                    $_SESSION['idEmpresa'] = $resultadoEmpresa['idEmpresa'];
                    header("Location: admin/acesso-empresa.php");
                } else {
                    echo "Credenciais inválidas. Tente novamente.";
                }
            } else {
                echo "Credenciais inválidas. Tente novamente.";
            }
        }
    } catch (PDOException $e) {
        echo "Erro na autenticação. Tente novamente.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="login.php" method="post">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br>

        <input type="submit" value="Entrar">
    </form>
</body>
</html>
