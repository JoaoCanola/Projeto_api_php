<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);

    $usuario = $stmt->fetch();

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        session_start();
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['tipo'] = $usuario['tipo']; 

        if ($usuario['tipo'] == 'admin') {
            header("Location: admin/dashboard.html"); 
        } else {
            header("Location: cliente/produtos.php"); 
        }
        
        exit();
    } else {
        echo "E-mail ou senha inválidos!";
    }
} else {
    echo "Acesso inválido.";
}
?>
