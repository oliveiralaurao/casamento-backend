<?php
require_once '../../startup/connectBD.php';
session_start();

if (isset($_POST['usuario_id']) && isset($_POST['portfolio_id'])) {
    $usuario_id = intval($_POST['usuario_id']);
    $portfolio_id = intval($_POST['portfolio_id']);

    $stmt = $mysqli->prepare("INSERT INTO `favoritos`(`usuario_id_usuario`, `portfolio_id_portfolio`) VALUES (?, ?)");
    $stmt->bind_param("ii", $usuario_id, $portfolio_id);

    if ($stmt->execute()) {
        header("Location: " . $_SERVER['HTTP_REFERER'] . "");
        exit();
    } else {
        header("Location: " . $_SERVER['HTTP_REFERER'] . "");
        exit();
    }

    $stmt->close();
} else {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "");
    exit();
}
?>
