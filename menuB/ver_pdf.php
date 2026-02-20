<?php
require_once("config.php");
$conn = new mysqli("localhost", "orcamento", "orcamento", "orcamento");
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $conn->prepare("SELECT tipo_imagem, imagem FROM tabela_imagens WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($tipo, $blob);

if ($stmt->fetch()) {
    header("Content-Type: " . $tipo);
    echo $blob;
} else {
    echo "PDF não encontrado.";
}

$stmt->close();
$conn->close();
?>
