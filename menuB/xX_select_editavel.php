<?php
$host = "localhost"; // Servidor do MySQL
$dbname = "orcamento"; // Nome do banco de dados
$username = "root"; // Usuário do MySQL
$password = ""; // Senha do MySQL

// Cria a conexão com o banco de dados
$conn = new mysqli($host, $username, $password, $dbname);

// Verifica se a conexão falhou
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Verifica se o parâmetro de busca foi enviado
if (isset($_GET['searchTerm'])) {
    $searchTerm = $_GET['searchTerm'];

    // Prepara a consulta SQL para buscar despesas que correspondam ao termo digitado
    $stmt = $conn->prepare("SELECT id_despesa, despesa FROM despesa WHERE despesa LIKE ?");
    $likeTerm = "%$searchTerm%";
    $stmt->bind_param("s", $likeTerm);
    $stmt->execute();

    // Obtém os resultados da consulta
    $result = $stmt->get_result();
    $despesas = [];

    // Formata os resultados em um array
    while ($row = $result->fetch_assoc()) {
        $despesas[] = [
            "id_despesa" => $row['id_despesa'],
            "despesa" => $row['despesa']
        ];
    }

    // Retorna os resultados como JSON
    echo json_encode($despesas);
}

$conn->close();
?>

