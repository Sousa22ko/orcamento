<?php
require_once "config.php";
require_once "functions.inc";

$conn = conectar();

$idSelecionado = $_GET['id'] ?? '';

$sql = "SELECT categoria, nome_categoria FROM categoria ORDER BY nome_categoria";
$result = $conn->query($sql);

echo "<select id='edit_categoria' class='form-control'>";

while ($row = $result->fetch_assoc()) {

    $selected = ($row['categoria'] == $idSelecionado) ? "selected" : "";

    echo "<option value='{$row['categoria']}' $selected>
            {$row['nome_categoria']}
          </option>";
}

echo "</select>";

$conn->close();
?>