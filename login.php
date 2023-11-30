<?php
include('conexao.php');
session_start(); // Inicia ou retoma a sessão

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    try {
        // Check in usuarios table
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
            // Check in coordenador table
            $consultaCoordenador = "SELECT idCoordenador, emailCoordenador, senhaCoordenador FROM coordenador WHERE emailCoordenador = :email";
            $stmtCoordenador = $conexao->prepare($consultaCoordenador);
            $stmtCoordenador->bindParam(':email', $email);
            $stmtCoordenador->execute();

            if ($stmtCoordenador->rowCount() > 0) {
                $resultadoCoordenador = $stmtCoordenador->fetch(PDO::FETCH_ASSOC);

                if (password_verify($senha, $resultadoCoordenador['senhaCoordenador'])) {
                    $_SESSION['idCoordenador'] = $resultadoCoordenador['idCoordenador'];
                    header("Location: admin/acesso-coordenador.php");
                } else {
                    echo "Credenciais inválidas. Tente novamente.";
                }
            } else {
                // Check in gerente table
                $consultaGerente = "SELECT idGerente, emailGerente, senhaGerente FROM gerente WHERE emailGerente = :email";
                $stmtGerente = $conexao->prepare($consultaGerente);
                $stmtGerente->bindParam(':email', $email);
                $stmtGerente->execute();

                if ($stmtGerente->rowCount() > 0) {
                    $resultadoGerente = $stmtGerente->fetch(PDO::FETCH_ASSOC);

                    if (password_verify($senha, $resultadoGerente['senhaGerente'])) {
                        $_SESSION['idGerente'] = $resultadoGerente['idGerente'];
                        header("Location: admin/acesso-gerente.php");
                    } else {
                        echo "Credenciais inválidas. Tente novamente.";
                    }
                } else {
                    echo "Credenciais inválidas. Tente novamente.";
                }
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
