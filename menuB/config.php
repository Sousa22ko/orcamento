<?php

function conectar(){    
// 📌 1. Configuração do banco de dados
$host = "localhost";
$usuario = "orcamento";
$senha = "orcamento";
$banco = "orcamento";

// 📌 2. Criando a conexão com MySQLi
$conn = new mysqli($host, $usuario, $senha, $banco);

// 📌 3. Verificando erros na conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
// Retorna o valor da $conn com a autenticação da conexao
return $conn;
}

?>