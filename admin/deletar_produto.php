<?php
require '../db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM produtos WHERE id = ?";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$id])) {
        header("Location: listar_produtos.php");
        exit;
    } else {
        echo " Erro ao deletar o produto.";
    }
} else {
    echo "ID do produto não informado.";
}
