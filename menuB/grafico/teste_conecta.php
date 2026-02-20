<?php
require_once("orcamento.inc");
require_once("functions.inc");


       $cor="#f9f5e6";
      $a=0;
      $contador=1;
      $subtotal=0;
      $subtotal_casa=0;
      $subtotal_casa1=0;
      $subtotal_casa2=0;
      $total=0;
      $somatorio=0;
      $aindanaopago=0;
      $naopago=0;
      $rec=0;


      $id_descricao="1";

    $mysqli_connection = mysqli_connect($host,$user,$senha,$dbname);

  if ($mysqli_connection===false)
     { print "nao concectado";}
   else
     {print "concectado";}

 $query="SELECT $banco.descricao.*
        FROM    $banco.descricao
        WHERE   $banco.descricao.id_descricao=$id_descricao";

 print $query;

 $result = mysqli_query($mysqli_connection, $query);


if (mysqli_num_rows($result))
{

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))      // executa enquanto houver resultados
    {


       print ("<tr>

      <td
      valign='middle'
      align='left'
      width='25%'
      BGCOLOR=". $cor ."
      height='20'
      style='padding-left:4px'>
      <span style='font-family: Arial;
      font-size:14px; color:#000000;'>
      ".$row["descricao"]."</font></td>");

      }



}
?>












