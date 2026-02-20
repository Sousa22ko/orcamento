<?php
require_once("config.php");
$conn = new mysqli("localhost", "orcamento", "orcamento", "orcamento");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
//$id = $_GET['id']; // id da imagem
$id = '11';
$stmt = $conn->prepare("SELECT tipo_imagem, imagem FROM tabela_imagens WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($tipo, $blob);
$stmt->fetch();
header("Content-Type: " . $tipo);
echo $blob;
file_put_contents("teste_saida.pdf", $blob);
$stmt->close();
$conn->close();
?>
