<?php
include("includes/cores.html");
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instância de Aprimoramento Social</title>
    <style>
        /* Estilos básicos para o dropdown */
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }

    </style>
</head>
<body>
    <h1>Bem-vindo ao Instância de Aprimoramento Social!</h1>

    <p>Escolha uma opção abaixo para começar.</p>

    <div class="dropdown">
        <button>Selecione um Tema de Contraste</button>
        <div class="dropdown-content">
            <a href="#" data-theme="protanopia" class="protanopia">Protanopia</a>
            <a href="#" data-theme="deuteranopia" class="deuteranopia">Deuteranopia</a>
            <a href="#" data-theme="tritanopia" class="tritanopia">Tritanopia</a>
            <a href="#" data-theme="achromatopsia" class="achromatopsia">Acromatopsia</a>
            <a href="#" data-theme="protanomaly" class="protanomaly">Protanomalia</a>
            <a href="#" data-theme="deuteranomaly" class="deuteranomaly">Deuteranomalia</a>
            <a href="#" data-theme="tritanomaly" class="tritanomaly">Tritanomalia</a>
        </div>
    </div>

    <button onclick="window.location.href='criainstancia.php'" aria-label="Criar uma Instância de Aprimoramento Social" role="button" accesskey="c" title="Clique para criar uma instância de aprimoramento social">Criar uma Instância de Aprimoramento Social</button>
    <button onclick="window.location.href='criaviaupload.php'" aria-label="Criar Documento via upload" role="button" accesskey="u" title="Clique para fazer upload de um documento">Criar Documento via Upload</button>
    <button onclick="window.location.href='editarinstancia.php'" aria-label="Clique para editar uma instância de aprimoramento social" role="button" accesskey="d" title="Clique para editar uma instância de aprimoramento social">Editar Instância</button>
    <button onclick="askForNameAndRedirect();" aria-label="Responder uma Instância de Aprimoramento Social" role="button" accesskey="r" title="Clique para responder a uma instância de aprimoramento social">Responder uma Instância de Aprimoramento Social</button>
    <script>

        function askForNameAndRedirect() {
            var name = prompt("Por favor, digite o seu nome:");
            
            if (name) {
               // localStorage.setItem('nomeUsuario', name);
                window.location.href = 'responderinstancia.php?name=' + encodeURIComponent(name);
            }
        }
    
        // Função para atualizar o estilo da página
        function updateTheme(theme) {
            document.body.className = theme;
            localStorage.setItem('selectedTheme', theme);
        }

        var links = document.querySelectorAll('.dropdown-content a');
        links.forEach(function(link) {
            link.addEventListener('mouseover', function() {
                var theme = this.getAttribute('data-theme');
                updateTheme(theme);
            });
        });

        var temasalvo = localStorage.getItem('selectedTheme');
        if (temasalvo) {
            updateTheme(temasalvo);
        }
    </script>
    <script src="includes/cores.js"></script>
</body>
</html>
