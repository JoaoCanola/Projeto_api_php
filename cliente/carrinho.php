<?php
session_start();
require '../db.php';

if (!isset($_SESSION['carrinho']) || empty($_SESSION['carrinho'])) {
    echo "Seu carrinho está vazio.";
    exit;
}

$ids = array_keys($_SESSION['carrinho']);

$placeholders = implode(',', array_fill(0, count($ids), '?'));

$sql = "SELECT * FROM produtos WHERE id IN ($placeholders)";
$stmt = $pdo->prepare($sql);
$stmt->execute($ids);

$produtos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Carrinho de Compras</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f4f4f4; }
    .container { max-width: 1200px; margin: 30px auto; padding: 20px; background: white; border-radius: 12px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    h2 { text-align: center; color: #333; }
    ul { list-style-type: none; padding: 0; }
    li { margin: 10px 0; }
    .total { font-weight: bold; }
    .finalizar { text-align: center; margin-top: 20px; }
    .finalizar a { background: #28a745; padding: 10px 20px; border-radius: 8px; color: white; text-decoration: none; font-weight: bold; }
    .finalizar a:hover { background: #218838; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Seu Carrinho</h2>

    <ul>
      <?php 
      $total = 0;
      foreach ($produtos as $produto): 
          $quantidade = $_SESSION['carrinho'][$produto['id']]['quantidade']; 
          $subtotal = $produto['preco'] * $quantidade;
          $total += $subtotal;
      ?>
        <li>
          <strong><?php echo htmlspecialchars($produto['nome']); ?></strong><br>
          Preço: R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?><br>
          Quantidade: <?php echo $quantidade; ?><br>
          Subtotal: R$ <?php echo number_format($subtotal, 2, ',', '.'); ?>
        </li>
        <hr>
      <?php endforeach; ?>
    </ul>

    <h3 class="total">Total: R$ <?php echo number_format($total, 2, ',', '.'); ?></h3>

    <div class="finalizar">
      <a href="finalizar.php">Finalizar Compra</a> 
    </div>

    <div class="continuar">
      <a href="produtos.php">Continuar Comprando</a>
    </div>
  </div>
</body>
</html>