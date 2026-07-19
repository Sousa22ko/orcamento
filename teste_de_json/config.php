<?php
function conectar() {
    $conn = new mysqli("localhost", "orcamento", "orcamento", "orcamento");

    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

    return $conn;
}
?>