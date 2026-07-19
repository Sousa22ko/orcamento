<?php
require_once "config.php";
require_once "functions.inc";

$conn = conectar();

$idSelecionado = $_GET['id'] ?? '';

$sql = "SELECT id_descricao, descricao_abreviada FROM descricao ORDER BY descricao_abreviada";
$result = $conn->query($sql);

echo "<select id='edit_descricao' class='form-control'>";

while ($row = $result->fetch_assoc()) {

    $selected = ($row['id_descricao'] == $idSelecionado) ? "selected" : "";

    echo "<option value='{$row['id_descricao']}' $selected>
            {$row['descricao_abreviada']}
          </option>";
}

echo "</select>";

$conn->close();
?>