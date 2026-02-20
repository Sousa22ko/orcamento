<?php
//require("conecta.php");
require_once ("orcamento.inc");


$id_imagem = $_GET[‘id’];
$querySelecionaPorCodigo = "SELECT id,
imagem FROM tabela_imagens WHERE id = $id_imagem";
$resultado = mysqli_query($querySelecionaPorCodigo);
$imagem = mysqli_fetch_object($resultado);
Header( "Content-type: image/gif");
echo $imagem->imagem;

?>