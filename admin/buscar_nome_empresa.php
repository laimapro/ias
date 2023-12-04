<?php

// Verifica se o CNPJ foi fornecido
if (isset($_POST['cnpj'])) {
    // Obtém o CNPJ do formulário e remove caracteres não numéricos
    $cnpj = preg_replace('/\D/', '', $_POST['cnpj']);

    // Verifica se o CNPJ tem 14 dígitos
    if (strlen($cnpj) === 14) {
        // URL da API ReceitaWS
        $apiUrl = "https://www.receitaws.com.br/v1/cnpj/{$cnpj}";

        // Inicializa a sessão cURL
        $ch = curl_init($apiUrl);

        // Configura as opções cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Desabilita a verificação SSL (use isso com cautela)
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Executa a solicitação cURL e obtém a resposta
        $apiResponse = curl_exec($ch);

        // Verifica se a solicitação foi bem-sucedida
        if ($apiResponse !== false) {
            // Decodifica o JSON da resposta
            $apiData = json_decode($apiResponse, true);

            // Verifica se a API retornou informações sobre a empresa
            if (isset($apiData['nome'])) {
                $response = [
                    'nome' => $apiData['nome'],
                    'endereco' => isset($apiData['logradouro']) ? $apiData['logradouro'] . ", " . $apiData['numero'] . " - " . $apiData['bairro'] : "Endereço não disponível",
                    'cidade' => isset($apiData['municipio']) ? $apiData['municipio'] . " - " . $apiData['uf'] : "Cidade não disponível",
                    'cep' => isset($apiData['cep']) ? $apiData['cep'] : "CEP não disponível",
                ];
            
                echo json_encode($response);
            } else {
                echo json_encode(['error' => "Informações não encontradas"]);
            }
        } else {
            // Se a solicitação à API falhar, emite uma mensagem de erro
            echo "Erro ao acessar a API: " . curl_error($ch);
        }

        // Fecha a sessão cURL
        curl_close($ch);
    } else {
        // CNPJ inválido
        echo "CNPJ inválido";
    }
} else {
    // Se o CNPJ não foi fornecido, retorna uma mensagem indicando que o CNPJ é obrigatório
    echo "CNPJ é obrigatório";
}

?>
