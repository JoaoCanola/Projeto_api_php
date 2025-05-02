<?php
session_start();
require '../db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID do produto não informado.";
    exit;
}

$id = $_GET['id'];

// Buscar o produto no banco
$sql = "SELECT * FROM produtos WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$produto = $stmt->fetch();

if (!$produto) {
    echo "Produto não encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Detalhes do Produto</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      background-color: #f4f4f4;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }
    .container {
      background-color: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      max-width: 500px;
      width: 90%;
    }
    h2 {
      margin-top: 0;
      color: #007bff;
    }
    p {
      color: #555;
      line-height: 1.5;
    }
    strong {
      display: block;
      margin-top: 20px;
      font-size: 18px;
      color: #000;
    }
    .botoes {
      margin-top: 20px;
      display: flex;
      justify-content: space-between;
    }
    a, button {
      text-decoration: none;
      background-color: #007bff;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: 0.3s;
    }
    a:hover, button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2><?= htmlspecialchars($produto['nome']) ?></h2>
    <p><?= nl2br(htmlspecialchars($produto['descricao'])) ?></p>
    <strong>Preço: R$ <?= number_format($produto['preco'], 2, ',', '.') ?></strong>

    <div class="botoes">
      <form action="adicionar_carrinho.php" method="POST">
        <input type="hidden" name="id" value="<?= $produto['id'] ?>"> <!-- Correção aqui -->
        <button type="submit">Adicionar ao Carrinho 🛒</button>
      </form>

      <a href="produtos.php">Voltar</a>
    </div>
  </div>
</body>
</html>