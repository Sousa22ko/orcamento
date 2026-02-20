<?php
// Conecta-se com o MySQL
$host="localhost";
$user="orcamento";
$senha="orcamento";
$dbname="orcamento";

// Cria uma nova conexão
$mysqli_connection = new mysqli($host, $user, $senha, $dbname);

// Verifica se a conexão foi bem-sucedida
if ($mysqli_connection->connect_error) {
    die('Conexão falhou: ' . $mysqli_connection->connect_error);}

echo 'Conexão bem-sucedidaaaaa!'; 
?>
