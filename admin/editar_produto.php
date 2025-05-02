<?php
require '../db.php';

if (!isset($_GET['id'])) {
    die("ID do produto não informado.");
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];

    $sql = "UPDATE produtos SET nome = ?, descricao = ?, preco = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$nome, $descricao, $preco, $id])) {
        echo "<p> Produto atualizado com sucesso!</p>";
        echo "<a href='listar_produtos.php'>Voltar à lista</a>";
        exit;
    } else {
        echo "<p> Erro ao atualizar o produto.</p>";
    }
}

$sql = "SELECT * FROM produtos WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$produto = $stmt->fetch();

if (!$produto) {
    die("Produto não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
</head>
<body>
    <h2>Editar Produto</h2>
    <form method="POST">
        <label for="nome">Nome:</label><br>
        <input type="text" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" required><br><br>

        <label for="descricao">Descrição:</label><br>
        <textarea name="descricao" required><?= htmlspecialchars($produto['descricao']) ?></textarea><br><br>

        <label for="preco">Preço:</label><br>
        <input type="number" name="preco" step="0.01" value="<?= $produto['preco'] ?>" required><br><br>

        <button type="submit">Salvar Alterações</button>
    </form>

    <br>
    <a href="dashboard.html" >Voltar ao Painel</a>
</body>
</html>
