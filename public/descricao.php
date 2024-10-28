<?php
require_once '../startup/connectBD.php';
session_start();

if (isset($_GET['id']) && isset($_GET['nome'])) {

    $id = intval($_GET['id']);
    $id_user = $_SESSION['id_usuario'];

    
    $tipo = $_GET['nome'];

    if ($tipo == 'vestido') {
        $sql = "SELECT * FROM fotos WHERE id_portfolio = $id;";
    } elseif ($tipo == 'temas') {
        $sql = "SELECT * FROM fototema WHERE id_portfolio = $id;";
    } elseif ($tipo == 'paleta') {
        $sql = "SELECT `id_portfolio`, `nome_portfolio`, `desc_portfolio`, `image`, `nome_categoria` FROM `innerportfolio` WHERE innerportfolio.nome_categoria = 'Paletas de Cores' AND id_portfolio = $id;";
    } elseif ($tipo == 'buques') {
        $sql = "SELECT `id_portfolio`, `nome_portfolio`, `desc_portfolio`, `image`, `nome_categoria` FROM `innerportfolio` WHERE innerportfolio.nome_categoria = 'Buquês' AND id_portfolio = $id;";
    
}else {
        $mensagem = 'Tipo de pesquisa desconhecido.';
        $vestido = null;
    }

    if (isset($sql)) {
        $result = $mysqli->query($sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $vestido = mysqli_fetch_array($result);
        } else {
            $mensagem = 'Registro não encontrado.';
            $vestido = null;
        }
    }
} else {
    $mensagem = 'ID ou tipo de pesquisa não foi passado.';
    $vestido = null;
}

if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'favorito_adicionado') {
        echo '<div class="alert alert-success">Adicionado aos favoritos com sucesso!</div>';
    } elseif ($_GET['msg'] == 'erro_adicionar_favorito') {
        echo '<div class="alert alert-danger">Ocorreu um erro ao adicionar aos favoritos.</div>';
    } elseif ($_GET['msg'] == 'parametros_invalidos') {
        echo '<div class="alert alert-warning">Parâmetros inválidos.</div>';
    }
}

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descrição do Vestido</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="body-descricao-vestido">
<script src="js/topo.js"></script>
<button onclick="history.back()" class="btn-voltar"><i class="bi bi-arrow-left"></i></button>



    <div class="container-descricao">
        <?php if ($vestido): ?>
            <div class="imagem-vestido">
                <img src="../backBack/upload/<?php echo $vestido['image']; ?>" alt="<?php echo $vestido['nome_portfolio']; ?>">
            </div>
            <div class="texto-descricao">
                <h2 class="titulo-descricao"><?php echo $vestido['nome_portfolio']; ?></h2>
                <p class="paragrafo-descricao"><?php echo $vestido['desc_portfolio']; ?></p>
            </div>
        <?php else: ?>
            <p><?php echo $mensagem; ?></p>
        <?php endif; ?>
    </div>

    <div class="favoritos-icon">
    <form id="favorito-form" action="../backBack/cadastro/favorito.php" method="POST" style="display: inline;">
        <input type="hidden" name="usuario_id" value="<?php echo $id_user; ?>"> <!-- Certifique-se de ter o ID do usuário na variável $id_user -->
        <input type="hidden" name="portfolio_id" value="<?php echo $vestido['id_portfolio']; ?>"> <!-- ID do portfólio -->
        <button type="submit" class="btn-favorito" title="Adicionar aos Favoritos">
            <span class="material-symbols-outlined">favorite</span>
        </button>
    </form>
</div>

    <script src="js/footer.js"></script>
</body>
</html>
