<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>
<body>
    <h2>Cadastro</h2>
    <form action="processa_cadastro.php" method="post" onsubmit="return validarFormulario();">
        <label for="nomeCompleto">Nome Completo:</label>
        <input type="text" id="nomeCompleto" name="nomeCompleto" required><br>

        <label for="nomeExibicao">Nome para exibição:</label>
        <input type="text" id="nomeExibicao" name="nomeExibicao" required><br>

        <!-- PRONOME TRATAMENTO DROPDOWN -->
        <label for="pronomeTratamento">Pronome de Tratamento:</label>
        <select id="pronomeTratamento" name="pronomeTratamento" required>
            <option value="1">Senhor</option>
            <option value="2">Senhora</option>
            <option value="3">Senhorita</option>
            <option value="4">Mestre</option>
            <option value="5">Doutor</option>
            <option value="6">Doutora</option>
            <option value="7">Chefe</option>
            <option value="8">Gerente</option>
            <option value="10">Encarregado</option>
            <option value="11">Diretor</option>
            <option value="12">Diretora</option>
            <option value="13">Presidente</option>
        </select><br>

       <!-- PRONOMES PESSOAIS DROPDOWN -->
        <label for="pronomeReferencia">Pronomes Referencia:</label>
        <select id="pronomesReferencia" name="pronomesReferencia" required>
            <option value="1">Ela</option>
            <option value="2">Ele</option>
            <option value="3">Elu</option>
            <!-- Adicione outras opções conforme necessário -->
        </select><br>


        <label for="dataNascimento">Data de nascimento:</label>
        <input type="date" id="dataNascimento" name="dataNascimento"><br>

        <!-- SEXO DROPDOWN -->
        <label for="sexo">Sexo:</label>
        <select id="sexo" name="sexo" required>
        <option value="1">Prefiro não informar</option>
        <option value="2">Assexual</option>
        <option value="3">Bissexual</option>
        <option value="4">Gay</option>
        <option value="5">Heterossexual</option>
        <option value="6">Lésbica</option>
        <option value="7">Pansexual</option>
        </select><br>

        <!-- GENERO DROPDOWN -->
        <label for="genero">Gênero:</label>
        <select id="genero" name="genero" required>
        <option value="1">Prefiro não informar</option>
        <option value="2">Homem Cis</option>
        <option value="3">Mulher Cis</option>
        <option value="4">Não-binário</option>
        <option value="5">Queer</option>
            <!-- Adicione outras opções conforme necessário -->
        </select><br>

        <!-- ESCOLARIDADE DROPDOWN -->
        <label for="escolaridade">Escolaridade:</label>
        <select id="escolaridade" name="escolaridade" required>
        <option value="1">Ensino Fundamental 1</option>
        <option value="2">Ensino Fundamental 2</option>
        <option value="3">Ensino Médio</option>
        <option value="4">Graduação</option>
        <option value="5">Especialização</option>
        <option value="6">Mestrado</option>
        <option value="7">Doutorado</option>
        </select><br>

        <label for="cargoFuncao">Cargo ou Função:</label>
        <input type="text" id="cargoFuncao" name="cargoFuncao" required><br>

        <!-- Ano de admissão - Apenas ano -->
        <label for="anoAdmissao">Ano de admissão:</label>
        <input type="number" id="anoAdmissao" name="anoAdmissao" min="1900" max="2100" required><br>

        <!-- Condição de deficiência DROPDOWN -->
        <label for="condicaoDeficiencia">Condição de Deficiência:</label>
        <select id="condicaoDeficiencia" name="condicaoDeficiencia" required>
        <option value="1">Prefiro não informar</option>
        <option value="2">Eu me identifico como uma pessoa com deficiência visual</option>
        <option value="3">Eu me identifico como uma pessoa com baixa visão</option>
        <option value="4">Eu me identifico como cego</option>
        <option value="5">Eu me identifico como uma pessoa com deficiência auditiva</option>
        <option value="6">Eu me identifico como surdo</option>
        <option value="7">Eu me identifico como uma pessoa com deficiência intelectual</option>
        <option value="8">Eu me identifico como uma pessoa com deficiência mental</option>
        <option value="9">Eu me identifico como uma pessoa com deficiência física</option>
        <option value="10">Eu me identifico como uma pessoa sem deficiência</option>
        </select><br>

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
        // Aqui você precisará fazer uma solicitação assíncrona para o servidor PHP
        // para enviar o e-mail. Pode usar AJAX para isso.
        // Exemplo com jQuery:
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

        // Aqui você enviaria o código para o email fornecido.
        enviarCodigoEmail(email, codigoGerado);

        console.log("Código de verificação: " + codigoGerado);
        var codigoInserido = prompt("Digite o código de verificação de 6 dígitos:");

        if (codigoInserido && codigoInserido === codigoGerado.toString()) {
            // Se o código estiver correto, permita o envio do formulário.
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
