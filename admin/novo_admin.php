<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'admin') {
    header("Location:../login.html");
    exit;
}

require '../db.php';

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome  = trim($_POST['nome']  ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if ($nome && $email && $senha) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $tipo = 'admin';

        $sql  = "INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $ok   = $stmt->execute([$nome, $email, $senha_hash, $tipo]);

        if ($ok) {
            $mensagem = "
                <p style='color:green; text-align:center;'>
                  ✅ Administrador cadastrado com sucesso!
                </p>
            ";
        } else {
            $errorInfo = $stmt->errorInfo();
            $mensagem = "
                <p style='color:red; text-align:center;'>
                  ❌ Erro ao cadastrar: {$errorInfo[2]}
                </p>
            ";
        }
    } else {
        $mensagem = "
            <p style='color:red; text-align:center;'>
              ❗ Preencha todos os campos.
            </p>
        ";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Novo Administrador</title>
  <style>
    body 
    { background:#f4f4f4; display:flex; align-items:center; justify-content:center; height:100vh; margin:0; }
    .container 
    { background:#fff; padding:30px; border-radius:12px; box-shadow:0 0 10px rgba(0,0,0,0.1); width:100%; max-width:400px; }
    h2 
    { text-align:center; margin-bottom:20px; color:#333; }
    label 
    { display:block; margin-bottom:5px; font-weight:600; color:#555; }
    input 
    { width:100%; padding:10px; margin-bottom:15px; border:1px solid #ccc; border-radius:8px; font-size:16px; }
    button 
    { width:100%; padding:10px; background:#007bff; border:none; color:#fff; font-size:16px; border-radius:8px; cursor:pointer; transition:.3s; }
    button:hover
     { background:#0056b3; }
    .msg 
    { margin-top:15px; font-size:14px; text-align:center; }
    .back 
    { margin-top:10px; text-align:center; }
    .back a 
    { text-decoration:none; color:#007bff; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Cadastrar Administrador</h2>
    <form method="POST">
      <label for="nome">Nome:</label>
      <input type="text" name="nome" required>

      <label for="email">E-mail:</label>
      <input type="email" name="email" required>

      <label for="senha">Senha:</label>
      <input type="password" name="senha" required>

      <button type="submit">Cadastrar</button>
    </form>
    <div class="msg"><?= $mensagem ?></div>
    <div class="back"><a href="dashboard.html">← Voltar ao Dashboard</a></div>
  </div>
</body>
</html>
