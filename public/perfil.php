<?php
require_once('../startup/connectBD.php');

session_start();

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['id_usuario'];
$sql = "SELECT nome_usuario, sobrenome_usuario, email_usuario, tel_usuario, rede_social_usuario, hobbie_usuario, desc_usuario, foto_usuario FROM usuario WHERE id_usuario = ?";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// Consulta para os vestidos favoritos
$sql_vestidos = "
    SELECT p.id_portfolio, p.nome_portfolio, p.image
    FROM favoritos f
    JOIN portfolio p ON f.portfolio_id_portfolio = p.id_portfolio
    WHERE f.usuario_id_usuario = ?";
$stmt_vestidos = mysqli_prepare($mysqli, $sql_vestidos);
mysqli_stmt_bind_param($stmt_vestidos, 'i', $user_id);
mysqli_stmt_execute($stmt_vestidos);
$result_vestidos = mysqli_stmt_get_result($stmt_vestidos);

$vestidos_favoritos = [];
while ($row = mysqli_fetch_assoc($result_vestidos)) {
    $vestidos_favoritos[] = $row;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body id="perfil">
    <script src="js/topo.js"></script>
    
    <main id="mainperfil">
        <section id="principalperfil">
            <div id="nomePerfil">
                <!-- Exibe a foto de perfil -->
                <div id="fotoPerfil">
                    <?php if ($user['foto_usuario']): ?>
                        <img src="uploads/<?php echo htmlspecialchars($user['foto_usuario']); ?>" id="ftperfil" alt="Foto de Perfil" width="100%">
                    <?php else: ?>
                        <img src="images/perfil.png" id="ftperfil" alt="Foto de Perfil Padrão" width="100%">
                    <?php endif; ?>
                </div>

                <!-- Exibe o nome completo do usuário -->
                <div id="namePerfil">
                    <?php echo htmlspecialchars($user['nome_usuario']) . ' ' . htmlspecialchars($user['sobrenome_usuario']); ?>
                   <a href=""> <span class="material-symbols-outlined">edit</span></a>
                </div>
            </div>

            <div class="favs">
                <?php if (!empty($vestidos_favoritos)): ?>
                    <?php foreach ($vestidos_favoritos as $vestido): ?>
                        <div class="img-fav">
                            <div class="box-fav">
                                <img src="../backBack/upload/<?php echo htmlspecialchars($vestido['image']); ?>" alt="<?php echo htmlspecialchars($vestido['nome_portfolio']); ?>">
                                <div class="buttons-fav">
                                    <button class="btn-fav">DETALHES</button>
                                    <button class="btn-fav">REMOVER</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Nenhum vestido salvo como favorito.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="js/footer.js"></script>
</body>
</html>
