<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>
<body>
    <h2>Cadastro</h2>
    <form action="processa_empresa.php" method="post" onsubmit="return validarFormulario();">
        <label for="nomeProjeto">Nome do Projeto:</label>
        <input type="text" id="nomeProjeto" name="nomeProjeto" required><br>

        <label for="nomeEmpresa">Nome da Empresa:</label>
        <input type="text" id="nomeEmpresa" name="nomeEmpresa" required><br>


        <label for="cnpj">Cnpj:</label>
        <input type="text" id="cnpj" name="cnpj" required><br>

        <label for="gerenteProjeto">Gerente do Projeto:</label>
        <input type="text" id="gerenteProjeto" name="gerenteProjeto" required><br>
        
        <label for="coordenadorProjeto">Coordenador do Projeto:</label>
        <input type="text" id="coordenadorProjeto" name="coordenadorProjeto" required><br>


        
       
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}" title="A senha deve conter no mínimo 8 caracteres, pelo menos uma letra maiúscula, uma minúscula, um número e um caractere especial." required><br>

        <input type="submit" value="Cadastrar">
    </form>

    <script>
    function validarSenha() {
        var senha = document.getElementById("senha").value;
        var pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}$/;

        if (!pattern.test(senha)) {
            alert("A senha deve atender aos critérios de força.");
            return false;
        }
        return true;
    }

    function enviarCodigoEmail(email, codigo) {
        $.ajax({
            type: "POST",
            url: "enviar_codigo.php", // Substitua pelo caminho real do seu arquivo PHP
            data: { email: email, codigo: codigo },
            success: function(response) {
                alert(response);
            },
            error: function() {
                alert("Erro ao enviar o código de verificação.");
            }
        });
    }

    function solicitarCodigo() {
        var codigoGerado = Math.floor(100000 + Math.random() * 900000);
        var email = document.getElementById("email").value;

        enviarCodigoEmail(email, codigoGerado);

        console.log("Código de verificação: " + codigoGerado);
        var codigoInserido = prompt("Digite o código de verificação de 6 dígitos:");

        if (codigoInserido && codigoInserido === codigoGerado.toString()) {
            return validarSenha();
        } else {
            alert("Código de verificação incorreto. Tente novamente.");
            return false;
        }
    }

    function validarFormulario() {
        return solicitarCodigo();
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>



</body>
</html>
