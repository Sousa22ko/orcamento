<?php
// Informações de conexão com o banco de dados
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

// Consulta com DISTINCT para obter apenas valores únicos
$sql = "SELECT DISTINCT despesa FROM despesa";
$result = $conn->query($sql);

// Verifica se há resultados
if ($result->num_rows > 0) {
    // Começa o menu <select>
    echo "oi";
    echo "<label for='despesa-select'>Selecione uma Despesa (sem duplicatas):</label>";
    echo "<select id='despesa-select' name='despesa'>";
    echo "<option value=''>Selecione uma despesa</option>";

    // Preenche o menu <select> com as despesas únicas
    while($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['despesa'] . "'>" . $row['despesa'] . "</option>";
    }

    echo "</select>";
} else {
    // Caso não haja despesas encontradas
    echo "Nenhuma despesa encontrada.";
}

// Fecha a conexão com o banco de dados
$conn->close();
?>