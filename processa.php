<?php

require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $tipo = 'usuario';

    $sql = "INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$nome, $email, $senha, $tipo])) {
        echo " Cadastro realizado com sucesso!";
    } else {
        echo " Erro ao cadastrar. Tente novamente.";
    }

} else {
    echo "Acesso inválido.";
}
