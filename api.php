<?php
header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') 
{
    http_response_code(405); 
    echo json_encode(["erro" => "Método não permitido. Use POST."]);
    exit;
}

require 'db.php';

$dados = json_decode(file_get_contents("php://input"), true);

if (!isset($dados['nome']) || !isset($dados['email'])) 
{
    http_response_code(400); 
    echo json_encode(["erro" => "Campos obrigatórios não foram enviados."]);
    exit;
}

$nome = $dados['nome'];
$email = $dados['email'];

$sql = "INSERT INTO usuarios (nome, email) VALUES (?, ?)";
$stmt = $pdo->prepare($sql);

if ($stmt->execute([$nome, $email])) {
    echo json_encode(["mensagem" => "Usuário cadastrado com sucesso!"]);
} else {
    http_response_code(500); 
    echo json_encode(["erro" => "Erro ao cadastrar usuário."]);
}
?>
