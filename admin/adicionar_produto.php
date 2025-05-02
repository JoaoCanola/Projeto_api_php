<?php
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];

    $sql = "INSERT INTO produtos (nome, descricao, preco) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$nome, $descricao, $preco])) {
        echo "<p> Produto cadastrado com sucesso!</p>";
        echo "<a href='listar_produtos.php'>Ver lista de produtos</a>";
    } else {
        echo "<p> Erro ao cadastrar o produto.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Produto</title>
</head>
<body>
    <h2>Adicionar Novo Produto</h2>
    <form method="POST" action="">
        <label for="nome">Nome:</label><br>
        <input type="text" name="nome" required><br><br>

        <label for="descricao">Descrição:</label><br>
        <textarea name="descricao" required></textarea><br><br>

        <label for="preco">Preço:</label><br>
        <input type="number" name="preco" step="0.01" required><br><br>

        <button type="submit">Cadastrar Produto</button>
    </form>

    <br>
    <a href="dashboard.html">Voltar ao Painel</a>
</body>
</html>
