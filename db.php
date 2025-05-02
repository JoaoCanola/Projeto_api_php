<?php

$host = "localhost";       
$user = "root";           
$pass = "";                
$dbname = "cadastro_db";  


try 
{
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
} catch (PDOException $e) 
{
   
    die("Erro na conexão: " . $e->getMessage());
}
?>
