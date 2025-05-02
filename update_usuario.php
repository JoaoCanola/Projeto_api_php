<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "PUT") 
{
    $dados = json_decode(file_get_contents("php://input"), true);

    if (isset($dados['id'], $dados['nome'], $dados['email'])) {
        $id = $dados['id'];
        $nome = $dados['nome'];
        $email = $dados['email'];

        $sql = "UPDATE usuarios SET nome = ?, email = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$nome, $email, $id])) {
            echo json_encode(["mensagem" => "Usuário atualizado com sucesso!"]);
        } else {
            echo json_encode(["mensagem" => "Erro ao atualizar usuário."]);
        }
    } else {
        echo json_encode(["mensagem" => "Dados incompletos para atualização."]);
    }
} else {
    echo json_encode(["mensagem" => "Método não permitido."]);
}
?>
