<?php
require '../db.php';

$sql = "SELECT * FROM produtos";
$stmt = $pdo->query($sql);
$produtos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Produtos</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        a {
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 5px;
            color: white;
        }

        .editar {
            background-color: #28a745;
        }

        .deletar {
            background-color: #dc3545;
        }

        .topo {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <h2>Lista de Produtos</h2>

    <div class="topo">
        <a href="dashboard.html">⬅ Voltar ao Painel</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produtos as $produto): ?>
                <tr>
                    <td><?= htmlspecialchars($produto['nome']) ?></td>
                    <td><?= htmlspecialchars($produto['descricao']) ?></td>
                    <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                    <td>
                        <a href="editar_produto.php?id=<?= $produto['id'] ?>" class="editar">Editar</a>
                        <a href="deletar_produto.php?id=<?= $produto['id'] ?>" class="deletar" onclick="return confirm('Tem certeza que deseja deletar este produto?');">Deletar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
