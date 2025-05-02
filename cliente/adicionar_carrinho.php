<?php
session_start();
require '../db.php';

$id = $_POST['id'] ?? $_GET['id'] ?? null;

if (empty($id)) {
    echo "ID do produto não informado.";
    exit;
}

$sql = "SELECT * FROM produtos WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$produto = $stmt->fetch();

if (!$produto) {
    echo "Produto não encontrado.";
    exit;
}

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

if (isset($_SESSION['carrinho'][$produto['id']])) {
    $_SESSION['carrinho'][$produto['id']]['quantidade']++;
} else {
    $_SESSION['carrinho'][$produto['id']] = [
        'produto' => $produto,
        'quantidade' => 1
    ];
}

header("Location: carrinho.php");
exit;
?>