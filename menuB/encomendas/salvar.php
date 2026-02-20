<?php
// salvar.php

// Conexão com banco de dados MySQL
$host = 'localhost';
$user = 'root'; // usuário do WAMP (padrão)
$pass = '';     // senha (vazia por padrão no WAMP)
$dbname = 'condominio';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Coleta os dados do formulário
$nome = $_POST['nome'] ?? '';
$endereco = $_POST['endereco'] ?? '';
$casa = $_POST['casa'] ?? '';
$remetente = $_POST['remetente'] ?? '';
$codigo = $_POST['codigo'] ?? '';
$data = date('Y-m-d H:i:s');

// Prepara e executa a query
$stmt = $conn->prepare("INSERT INTO encomendas (nome_destinatario, endereco, numero_casa, remetente, codigo_rastreamento, data_entrada) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssisss", $nome, $endereco, $casa, $remetente, $codigo, $data);

if ($stmt->execute()) {
    echo "<div style='padding:10px; background:#d4edda; border:1px solid #c3e6cb;'>Encomenda salva com sucesso!</div>";
    echo "<a href='index.html'>Voltar</a>";
} else {
    echo "<div style='padding:10px; background:#f8d7da; border:1px solid #f5c6cb;'>Erro ao salvar: " . $stmt->error . "</div>";
}

$stmt->close();
$conn->close();
?>
