<?php

require_once('../startup/connectBD.php');
include('../backBack/cadastro/presente.php');

session_start();

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
} else {
    $id_user = $_SESSION['id_usuario'];

    // Corrigindo a query SQL para incluir o ID do usuário
    $sql_presente = "SELECT `id_presente`, `nome_presente`, `link_presente` FROM `lista_de_presentes` WHERE `usuario_id_usuario` = '$id_user';";
    $result_presente = $mysqli->query($sql_presente);

    $dados_presente = [];

    if ($result_presente && $result_presente->num_rows > 0) {
        while ($paleta = $result_presente->fetch_assoc()) {
            $dados_presente[] = $paleta;
        }
    } else {
        echo "Nenhum presente encontrado.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Presentes</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body id="body-meuspresentes">
    <script src="js/topo.js"></script>
    <section class="presentes-container">
        <div class="presentes-content">
            <div id="div-imagem">
                <div id="div-marrom"></div>
                <img src="images/buque4.jpg" alt="Presente com flores" class="presentes-imagem">
            </div>
            <div class="presentes-texto">
                <h2 id="h2-meuspresentes">Lista de presentes</h2>
                <p id="p-meuspresentes">O presente é muito importante, você deve escolher e pensar cuidadosamente. Aqui é o seu espaço para fazer uma lista dos melhores presentes que gostaria de ganhar das pessoas que você ama!</p>
            </div>
        </div>

        <div class="presentes-form">
            <div id="div-h3-presentes"><h3 id="h3-meuspresentes">Adicione aqui seus presentes</h3></div>
            <div class="input-container">
                <form id="form-meuspresentes" action="" method="POST">
                    <input type="text" name="adicionar-presente" placeholder="Adicionar presente" id="adicionar-presente">
                    <input type="text" name="adicionar-link" placeholder="Adicionar link" id="adicionar-link" class="adicionar-presente">
                    <button id="btn-add" type="submit">+</button>
                </form>
            </div>
            
            <div class="lista-presentes">
                <ul id="lista-presentes-ul">
                    <?php if (!empty($dados_presente)): ?>
                        <?php foreach ($dados_presente as $presente): ?>
                            <li>
                                <strong><?php echo htmlspecialchars($presente['nome_presente']); ?></strong>
                                <a href="<?php echo htmlspecialchars($presente['link_presente']); ?>" target="_blank">Ver Presente</a>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>Nenhum presente encontrado.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </section>
    <script src="js/footer.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
