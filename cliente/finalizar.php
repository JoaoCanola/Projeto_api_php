<?php
session_start();
require '../db.php';

$carrinho = isset($_SESSION['carrinho']) ? $_SESSION['carrinho'] : [];

$ids = array_keys($carrinho);
$produtosNoCarrinho = [];
$total = 0;

if (!empty($ids)) {
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $sql = "SELECT * FROM produtos WHERE id IN ($placeholders)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($ids);
    $produtosNoCarrinho = $stmt->fetchAll();

    foreach ($produtosNoCarrinho as $produto) {
        $quantidade = $carrinho[$produto['id']]['quantidade']; 
        $total += $produto['preco'] * $quantidade;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    
    unset($_SESSION['carrinho']);
    
    echo "<script>alert('Compra finalizada com sucesso!'); window.location.href='produtos.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Finalizar Compra</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f4f4f4; }
        .container { max-width: 600px; margin: 40px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #333; margin-bottom: 20px; }
        .produto { border-bottom: 1px solid #ddd; padding: 10px 0; }
        .produto:last-child { border-bottom: none; }
        .produto h3 { margin: 0; color: #007bff; }
        .produto p { margin: 5px 0; color: #555; }
        .total { text-align: right; margin-top: 20px; font-size: 20px; font-weight: bold; }
        .botoes { text-align: center; margin-top: 30px; }
        .botoes button, .botoes a { margin: 5px; padding: 10px 20px; background-color: #28a745; color: white; text-decoration: none; border: none; border-radius: 8px; font-size: 16px; cursor: pointer; transition: 0.3s; }
        .botoes button:hover, .botoes a:hover { background-color: #218838; }
    </style>
</head>
<body>

<div class="container">
    <h2>Resumo da Compra 🧾</h2>

    <?php if (empty($produtosNoCarrinho)): ?>
        <p>Seu carrinho está vazio.</p>
    <?php else: ?>
        <?php foreach ($produtosNoCarrinho as $produto): ?>
            <div class="produto">
                <h3><?= htmlspecialchars($produto['nome']) ?></h3>
                <p>Preço: R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
                <p>Quantidade: <?= $carrinho[$produto['id']]['quantidade'] ?></p> <
            </div>
        <?php endforeach; ?>

        <div class="total">
            Total: R$ <?= number_format($total, 2, ',', '.') ?>
        </div>

        <form method="post" class="botoes">
            <button type="submit">Confirmar Compra</button>
            <a href="carrinho.php">Voltar ao Carrinho</a>
        </form>
    <?php endif;