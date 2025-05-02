<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require 'db.php';

$sql = "SELECT * FROM usuarios"; 
$stmt = $pdo->prepare($sql);
$stmt->execute();

$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);


if ($usuarios) 
{
    echo json_encode($usuarios); 
} else 
{
    http_response_code(404);  
    echo json_encode(["mensagem" => "Nenhum usuário encontrado."]);
}
?>
