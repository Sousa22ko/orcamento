<?
require ("orcamento.inc");
require ("functions.inc");

$indice = ($_POST["id_despesa"]);


$mes = ($_POST["mes_inicio"]);
$ano = ($_POST["ano_inicio"]);
$despesa = ($_POST["despesa"]);
$parcela = ($_POST["parcela"]);
$data = ($_POST["data"]);
$vencimento = ($_POST["vencimento"]);
$pago = ($_POST["pago"]);
$valor = ($_POST["valor"]);
$valor_casa = ($_POST["valor_casa"]);
$pago = ($_POST["pago"]);
$id_descricao = ($_POST["id_descricao"]);
$texto = ($_POST["texto"]);
$categoria = ($_POST["categoria"]);
$valido = ($_POST["valido"]);


$query = "UPDATE despesa
      SET despesa='$despesa',
      data='$novadata',
      valor='$valor',
      valor_casa='$valor_casa',
      ocorrencia='$ocorrencia',
      parcela='$parcela',
      id_descricao='$id_descricao',
      vencimento='$novovencimento',
      pago='$novopago',
      obs='$texto',
      categoria='$categoria',
      valido='$valido'
      WHERE id_despesa=" . $indice;


print $query;

// executa a sql para a inclusão, usando a variavel $link localizado em fotografia.php
if (!mysqli_query($mysqli_connection, $query)) {
    mensagem("Não foi possível realizar a alteração");
} else {
    mensagem("A Alteração foi realizada com sucesso!!!");
}


?>