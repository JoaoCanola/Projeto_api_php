<?php
session_start();
require '../db.php';

$sql = "SELECT * FROM produtos";
$stmt = $pdo->query($sql);
$produtos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Produtos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f4f4f4; }
        .container { max-width: 1200px; margin: 30px auto; padding: 20px; background: white; border-radius: 12px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #333; }
        .produtos { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: 20px; }
        .produto { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 8px rgba(0,0,0,0.1); text-align: center; }
        .produto h3 { margin: 0; color: #007bff; }
        .produto p { color: #555; }
        .botoes { margin-top: 15px; }
        .botoes a, .botoes form button { display: inline-block; margin: 5px; padding: 8px 16px; border: none; border-radius: 8px; background: #007bff; color: white; text-decoration: none; font-size: 14px; transition: 0.3s; }
        .botoes a:hover, .botoes form button:hover { background: #0056b3; }
        .carrinho { text-align: right; margin-bottom: 20px; }
        .carrinho a { background: #28a745; padding: 10px 20px; border-radius: 8px; color: white; text-decoration: none; font-weight: bold; }
        .carrinho a:hover { background: #218838; }
    </style>
</head>
<body>

<div class="container">
    <div class="carrinho">
        <a href="carrinho.php">🛒 Ver Carrinho</a>
    </div>

    <h2>Produtos da Loja</h2>

    <div class="produtos">
        <?php foreach ($produtos as $produto): ?>
            <div class="produto">
                <h3><?= htmlspecialchars($produto['nome']) ?></h3>
                <p>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>

                <div class="botoes">
                    <a href="detalhes.php?id=<?= $produto['id'] ?>">Ver Mais</a>

                    <form action="adicionar_carrinho.php" method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $produto['id'] ?>"> <!-- Correção aqui -->
                        <button type="submit">Adicionar ao Carrinho</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>