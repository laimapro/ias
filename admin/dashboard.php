<?php
// Caminho para a pasta
$caminho_pasta = '../respostas/';

// Obtém a lista de arquivos na pasta
$arquivos = scandir($caminho_pasta);

// Array para armazenar os dados de cada nome de arquivo
$dados_por_nome = array();

// Itera sobre a lista de arquivos
foreach ($arquivos as $arquivo) {
    // Verifica se é um arquivo regular (não é . ou ..)
    if (is_file($caminho_pasta . $arquivo)) {
        // Lê o conteúdo do arquivo
        $conteudo = file_get_contents($caminho_pasta . $arquivo);

        // Decodifica o conteúdo JSON
        $dados = json_decode($conteudo, true);

        // Remove as partes específicas do nome do arquivo
        $nome_sem_prefixo_sufixo = preg_replace('/^(resposta_instancia_)(.*)(_\\d+\\.json)$/', '$2', $arquivo);

        // Adiciona os dados ao array de cada nome
        if (isset($dados['rating'])) {
            if (!isset($dados_por_nome[$nome_sem_prefixo_sufixo])) {
                $dados_por_nome[$nome_sem_prefixo_sufixo] = array(
                    'dados' => array(),
                    'quantidade' => 0,
                    'info' => array_slice($dados, 0, 4) // Armazena os primeiros 4 elementos (título, situação, pergunta, resposta)
                );
            }

            $dados_por_nome[$nome_sem_prefixo_sufixo]['dados'][] = $dados;
            $dados_por_nome[$nome_sem_prefixo_sufixo]['quantidade']++;
        }
    }
}

// Itera sobre o array de dados para exibir os resultados
foreach ($dados_por_nome as $nome => $dados) {
    $quantidade = $dados['quantidade'];
    $info = $dados['info'];

    echo "<div class='nome' data-nome='$nome'>Nome: $nome - Quantidade: $quantidade</div>";
    echo "<div class='info' data-nome='$nome' style='display:none;'>";
    echo "Título: " . $info['title'] . "<br>";
    echo "Situação: " . $info['situation'] . "<br>";
    echo "Pergunta: " . $info['question'] . "<br>";
    echo "Resposta: " . $info['selectedAnswer'] . "<br>";

    $soma = array_sum(array_column($dados['dados'], 'rating'));
    $media = $quantidade > 0 ? $soma / $quantidade : 0;
    echo "<div class='media' data-nome='$nome' style='display:none;'>Média: $media</div>";

    
    // Exibe as notas individuais
    foreach ($dados['dados'] as $index => $arquivoDados) {
        echo "Nota: ". $arquivoDados['rating'] . "<br>";
    }

    echo "</div>";
}
?>

<script>
    // Adiciona um evento de clique aos elementos com a classe 'nome'
    document.querySelectorAll('.nome').forEach(function (element) {
        element.addEventListener('click', function () {
            // Obtém o nome associado a este elemento
            var nome = element.getAttribute('data-nome');

            // Oculta todas as informações
            document.querySelectorAll('.info, .media').forEach(function (infoElement) {
                infoElement.style.display = 'none';
            });

            // Exibe as informações associadas ao nome clicado
            document.querySelectorAll('.info[data-nome="' + nome + '"]').forEach(function (infoElementToShow) {
                infoElementToShow.style.display = 'block';
            });

            // Exibe a média associada ao nome clicado
            var mediaElementToShow = document.querySelector('.media[data-nome="' + nome + '"]');
            if (mediaElementToShow) {
                mediaElementToShow.style.display = 'block';
            }
        });
    });
</script>
