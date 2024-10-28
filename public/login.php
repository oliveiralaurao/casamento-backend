<?php
require_once('../startup/connectBD.php');
include('../backBack/cadastro/usuario.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Para depuração, mostre todos os dados do POST
    var_dump($_POST); // Adicione esta linha para verificar o que está sendo enviado

    if (isset($_POST['nome'], $_POST['sobrenome'], $_POST['email'], $_POST['telefone'], $_POST['senha'], $_POST['senha_repetida'])) {
        $rede_social = isset($_POST['rede_social']) ? $_POST['rede_social'] : '';
        $hobbie = isset($_POST['hobbie']) ? $_POST['hobbie'] : '';
        $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
        $foto = isset($_POST['foto']) ? $_POST['foto'] : '';
    
        cadastra($mysqli, $_POST['nome'], $_POST['sobrenome'], $_POST['email'], $_POST['telefone'], $_POST['senha'], $_POST['senha_repetida'], $rede_social, $hobbie, $descricao, $foto);
    }
    
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css?version=1.0.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css?family=Open+Sans:300,600');
        
        html * {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        *, *:after, *:before {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        html, body {
            height: 100%;
            width: 100%;
            font-family: 'Open Sans', sans-serif;
            font-size: 24px;
            font-weight: 300;
            background: ivory;
            overflow: hidden;
        }
        #apao, #mensagem-erro, #emailError{
            font-size: 12px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body class="login-cadastro">
    <div class="login-container">
        <div class="flip-card-3D-wrapper">
            <div id="flip-card">
                <div class="flip-card-front">
                    <div class="contem">
                    <div class="login-image">
                        <img src="images/ftlogin.jpg" id="login-image" alt="Casamento">
                    </div>
                    <div class="login-form">
                        <h2 id="h2-login">Login</h2>
                        <form action="../backBack/verificaLogin.php" id="enviar" method="post">
                            <label for="email-login" id="label-loginn">Email:</label>
                            <input type="email" id="email-login" class="input-login" name="email-login" required>
                            
                            <label for="input-login" id="label-login">Senha:</label>
                            <input type="password" id="input-login" class="input-login" name="input-login" required>
                            <div id="apao"></div>
                            
                            <button type="submit" id="button-login">Entrar</button>
                        </form>
                        <p id="flip-card-btn-turn-to-back">Não tem conta? Cadastre-se</p>
                    </div>
                </div>
                </div>
                <div class="flip-card-back">
    <div id="contem">
        <div class="cadastro-container">
            <div class="cadastro-form">
                <h2 id="cadastraaaaaa">Cadastro</h2>
                <form id="cadastroForm" method="post">
                    <!-- Step 1 -->
                    <div id="step1">
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" required>
                        
                        <label for="sobrenome">Sobrenome:</label>
                        <input type="text" id="sobrenome" name="sobrenome" required>
                
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                        <div id="emailError" style="display:none; color:red;"></div>
                        
                        <button type="button" onclick="nextStep()" id="segueee">Continuar</button>
                    </div>
                        <a href="javascript:void(0)" class="back-button" id="backButton" style="display: none;" onclick="prevStep()">
                                            <i class="fas fa-arrow-left"></i> Voltar
                                        </a>
                    <div id="step2" style="display: none;">
                        <label for="telefone">Telefone:</label>
                        <input type="tel" id="telefone" name="telefone" required>
                        
                        <label for="senha">Senha:</label>
                        <input type="password" id="senha" name="senha" required>
                        
                        <label for="senha_repetida">Repetir senha:</label>
                        <input type="password" id="senha_repetida" name="senha_repetida" required>
                        
                        <div id="mensagem-erro" style="display:none; color:red;"></div> <!-- Mensagem de erro aqui -->
                        <div id="apaos"></div>

                        <button type="submit">Cadastrar</button>
                    </div>

                </form>
                
                <p id="flip-card-btn-turn-to-front">Já tem login?</p>
            </div>
            <div class="cadastro-image">
                <img src="images/ftcadastro.jpg" alt="Casamento">
            </div>
        </div>
    </div>
</div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function(event) {
    function validarSenha() {
        const senha1 = document.getElementById("senha").value;
        const senha2 = document.getElementById("senha_repetida").value;
        const mensagemErro = document.getElementById("mensagem-erro");

        if (senha1 !== senha2) {
            mensagemErro.style.display = "block";
            mensagemErro.innerHTML = "As senhas não coincidem. Por favor, tente novamente.";
            return false; 
        }

        mensagemErro.style.display = "none";
        return true; 
    }

    document.getElementById('cadastroForm').addEventListener('submit', function(event) {
        if (!validarSenha()) {
            event.preventDefault(); 
        }
    });

    document.getElementById('email').addEventListener('blur', function() {
        var email = this.value;
        var emailError = document.getElementById('emailError');
        var submitBtn = document.getElementById('segueee');

        if (email) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../verificaEmail.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.exists) {
                        emailError.style.display = 'block';
                        emailError.innerText = 'Este e-mail já está em uso.';
                        submitBtn.disabled = true;
                    } else {
                        emailError.style.display = 'none';
                        submitBtn.disabled = false;
                    }
                }
            };
            xhr.send('email=' + encodeURIComponent(email));
        } else {
            emailError.style.display = 'none';
            submitBtn.disabled = false; 
        }
    });
});


         function getQueryStringParameter(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        const errorMessage = getQueryStringParameter('error');

        if (errorMessage) {
            const apaoDiv = document.getElementById('apao');
            apaoDiv.textContent = decodeURIComponent(errorMessage);  
            apaoDiv.style.color = "red"; 
        }
        if (errorMessage) {
            const apaosDiv = document.getElementById('apaos');
            apaosDiv.textContent = decodeURIComponent(errorMessage);  
            apaosDiv.style.color = "red"; 
        }
        function nextStep() {
            document.getElementById('step1').style.display = 'none';
            document.getElementById('cadastraaaaaa').style.display = 'none';
            document.getElementById('step2').style.display = 'flex'; // Exibe o segundo formulário
            document.getElementById('backButton').style.display = 'flex'; // Mostra o botão "Voltar"
        }

        function prevStep() {
            document.getElementById('step2').style.display = 'none';
            document.getElementById('cadastraaaaaa').style.display = 'block';
            document.getElementById('step1').style.display = 'flex'; // Exibe o primeiro formulário novamente
            document.getElementById('backButton').style.display = 'none'; // Esconde o botão "Voltar"
        }

        document.addEventListener('DOMContentLoaded', function(event) {
            document.getElementById('flip-card-btn-turn-to-back').style.visibility = 'visible';
            document.getElementById('flip-card-btn-turn-to-front').style.visibility = 'visible';

            document.getElementById('flip-card-btn-turn-to-back').onclick = function() {
                document.getElementById('flip-card').classList.toggle('do-flip');
            };

            document.getElementById('flip-card-btn-turn-to-front').onclick = function() {
                document.getElementById('flip-card').classList.toggle('do-flip');
            };
        });
    </script>
</body>
</html>
