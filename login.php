<?php
include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    try {
        // Consulta SQL para obter o hash da senha correspondente ao email fornecido
        $consulta = "SELECT idUsuario, senha FROM usuarios WHERE email = :email";
        $stmt = $conexao->prepare($consulta);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Verifica se o email existe no banco de dados
        if ($stmt->rowCount() > 0) {
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verifica se a senha fornecida corresponde ao hash armazenado no banco de dados
            if (password_verify($senha, $resultado['senha'])) {
                echo "Login bem-sucedido!";

                // Aqui você pode redirecionar o usuário para a página de perfil, por exemplo
                // header("Location: perfil.php?id=" . $resultado['id']);
                // exit();
            } else {
                // Mensagem genérica em caso de senha incorreta
                echo "Credenciais inválidas. Tente novamente.";
            }
        } else {
            // Mensagem genérica em caso de email não encontrado
            echo "Credenciais inválidas. Tente novamente.";
        }
    } catch (PDOException $e) {
        // Mensagem genérica em caso de erro na consulta
        echo "Credenciais inválidas. Tente novamente.";
    }
}

// Se a requisição não foi um POST ou se algo deu errado, o usuário pode visualizar o formulário de login
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
