<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "DELETE") 
{
    $dados = json_decode(file_get_contents("php://input"), true);

    if (isset($dados['id'])) 
    {
        $id = $dados['id'];

        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$id])) 
        {
            echo json_encode(["mensagem" => "Usuário deletado com sucesso!"]);
        } else 
        {
            echo json_encode(["mensagem" => "Erro ao deletar usuário."]);
        }
    } else 
    {
        echo json_encode(["mensagem" => "ID não fornecido."]);
    }
} else 
{
    echo json_encode(["mensagem" => "Método não permitido."]);
}
?>
