<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>
<body>
    <h2>Cadastro</h2>
    <form action="processa_cadastro.php" method="post">
        <label for="nomeCompleto">Nome Completo:</label>
        <input type="text" id="nomeCompleto" name="nomeCompleto" required><br>

        <label for="nomeExibicao">Nome para exibição:</label>
        <input type="text" id="nomeExibicao" name="nomeExibicao" required><br>

        <!-- PRONOME TRATAMENTO DROPDOWN -->
        <label for="pronomeTratamento">Pronome de Tratamento:</label>
        <select id="pronomeTratamento" name="pronomeTratamento" required>
            <option value="Sr.">Sr.</option>
            <option value="Sra.">Sra.</option>
            <!-- Adicione outras opções conforme necessário -->
        </select><br>

        <label for="dataNascimento">Data de nascimento:</label>
        <input type="date" id="dataNascimento" name="dataNascimento"><br>

        <!-- SEXO DROPDOWN -->
        <label for="sexo">Sexo:</label>
        <select id="sexo" name="sexo" required>
            <option value="masculino">Masculino</option>
            <option value="feminino">Feminino</option>
            <!-- Adicione outras opções conforme necessário -->
        </select><br>

        <!-- GENERO DROPDOWN -->
        <label for="genero">Gênero:</label>
        <select id="genero" name="genero" required>
            <option value="homem">Homem</option>
            <option value="mulher">Mulher</option>
            <!-- Adicione outras opções conforme necessário -->
        </select><br>

        <!-- ESCOLARIDADE DROPDOWN -->
        <label for="escolaridade">Escolaridade:</label>
        <select id="escolaridade" name="escolaridade" required>
            <option value="fundamental">Fundamental</option>
            <option value="medio">Médio</option>
            <option value="superior">Superior</option>
            <!-- Adicione outras opções conforme necessário -->
        </select><br>

        <label for="cargoFuncao">Cargo ou Função:</label>
        <input type="text" id="cargoFuncao" name="cargoFuncao" required><br>

        <!-- Ano de admissão - Apenas ano -->
        <label for="anoAdmissao">Ano de admissão:</label>
        <input type="number" id="anoAdmissao" name="anoAdmissao" min="1900" max="2100" required><br>

        <!-- Condição de deficiência DROPDOWN -->
        <label for="condicaoDeficiencia">Condição de Deficiência:</label>
        <select id="condicaoDeficiencia" name="condicaoDeficiencia" required>
            <option value="deficienciaFisica">Pessoa com Deficiência Física</option>
            <option value="deficienciaVisual">Pessoa com Deficiência Visual</option>
            <option value="deficienciaAuditiva">Pessoa com Deficiência Auditiva</option>
            <!-- Adicione outras opções conforme necessário -->
        </select><br>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br>

        <input type="submit" value="Cadastrar">
    </form>
</body>
</html>
