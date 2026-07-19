<?php

$id = $_GET['id'];

require_once "config.php";
require_once "functions.inc";

$conn = conectar();

$sql = "SELECT     
    despesa.*,
    descricao.descricao_abreviada,
    categoria.nome_categoria,
    anexo.caminho

FROM despesa

JOIN descricao 
    ON despesa.id_descricao = descricao.id_descricao

JOIN categoria 
    ON despesa.categoria = categoria.categoria

LEFT JOIN anexo 
    ON anexo.id_despesa = despesa.id_despesa

WHERE despesa.id_despesa = ?

ORDER BY anexo.id_anexo DESC
LIMIT 1
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

$row = $result->fetch_assoc();

echo json_encode([
    "sucesso" => true,
    "dados" => $row
]);

$stmt->close();
$conn->close();

?>