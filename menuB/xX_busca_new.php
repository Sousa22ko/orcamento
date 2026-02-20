
<?
/*******************************************************************************
 Exemplo do artigo "PESQUISA COM ACENTOS DENTRO DO MYSQL"
 -------------------------------------------------------------------------------
 Formul�rio de Busca
 *******************************************************************************/
/////////////////////////////////////
require("orcamento.inc");
require("functions.inc");
////////////////////////////////////////////////////////
$desp=($_POST["textoProcurado"]);
$val=($_POST["valor"]);

print $val;


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



//Conectando no Banco de Dados
@mysqli_connect($host,$user,$senha)
	or die("N�o pude conectar: " . mysql_error());

//Selecionando o Banco de Dados
@mysqli_select_db($mysqli_connection,$dbname_aux)
	or die("N�o pude selecionar o BD: " . mysql_error());


//Montando a REGEXP
///  $str=stringParaBusca($textoProcurado);

//print $str;

/*

     // estabelece a primeira query ///////////
  $sql="SELECT $dbname.despesa.*,$dbname_aux.descricao.* 
        FROM $dbname.despesa,$dbname_aux.descricao
        WHERE $dbname.despesa.valido='S'
        AND   $dbname.despesa.id_descricao=$dbname_aux.descricao.id_descricao
        AND   ($dbname.despesa.despesa REGEXP \"" . $str . "\"
        OR     $dbname.despesa.valor REGEXP \"" . $str . "\"
        OR     $dbname.despesa.ocorrencia REGEXP \"" . $str . "\")
        ORDER BY $dbname.despesa.ocorrencia,$dbname.despesa.data  ASC";
 */
// print $sql;


 
 $query = "SELECT $dbname.despesa.*
 FROM $dbname.despesa
 WHERE $dbname.despesa.despesa LIKE '%$desp%'
 and $dbname.despesa.valor LIKE '$val%'
 and $dbname.despesa.valido='S'";

// print $query;


$result = mysqli_query($mysqli_connection, $query);

 /*
$vira_despesa='';
$vira_ocorrencia='';


print "<TABLE cellSpacing=0 cellPadding=0 width='100%' border=1><TBODY>";

if (mysqli_num_rows($result))
  { 
    $row = mysqli_num_rows($result);

    while ($row = mysqli_fetch_array($result, MYSQL_ASSOC))
    {
    /*
          if ($vira_despesa!=$row['despesa'])
             {
               print "  <TR>
                        <TD background='' bgColor=#c0c0c0 colSpan=5>
                        <P align=center><FONT face=System color=#7f7f7f>".$row['despesa'];
               print "  </FONT>
                        </P>
                        </TD>
                        </TR>";
               $vira_despesa=$row['despesa'];
              }
              


           if ($vira_ocorrencia!=$row['ocorrencia'])
             {
               print "  <TR>
                        <TD background='' bgColor=#e6e6e6 colSpan=6>
                        <P align=center><FONT face=System color=#7f7f7f>".$row['ocorrencia'];
               print "  </FONT>
                        </P>
                        </TD>
                        </TR>";
               $vira_ocorrencia=$row['ocorrencia'];
              }


             /////////////////// CORPO DO RELATORIO/////////////////////
              print "<TR>
                     <TD background='' bgColor=#f4f4f4>
                     <FONT face=System color=#7f7f7f>".$row['despesa'];
                     
                 // inicia o desmembramento da data do vencimento//
                $valor_dia=substr($row['data'],8,2);
                $valor_mes=substr($row['data'],5,2);
                $valor_ano=substr($row['data'],0,4);
                // fim//
                $data= $valor_dia."/".$valor_mes."/".$valor_ano;
              print "</FONT>
                     </TD>
                     <TD background='' bgColor=#f4f4f4>
                     <FONT face=System  color=#7f7f7f>".$data;
                     
                     
              print "</FONT>
                     </TD>
                     <TD background='' bgColor=#f4f4f4>
                     <FONT face=System color=#7f7f7f>".$row['valor'];
                     
                     
              print "</FONT>
                     </TD>
                     <TD background='' bgColor=#f4f4f4>
                     <FONT face=System  color=#7f7f7f>".$row['descricao_abreviada'];
                     
                     
                     
               // inicia o desmembramento da data do vencimento//
                $valor_dia=substr($row['vencimento'],8,2);
                $valor_mes=substr($row['vencimento'],5,2);
                $valor_ano=substr($row['vencimento'],0,4);
                // fim//
                $vencimento= $valor_dia."/".$valor_mes."/".$valor_ano;
                     
              print "</FONT>
                     </TD>
                     <TD background='' bgColor=#f4f4f4>
                     <FONT face=System color=#7f7f7f>".$vencimento;
                     
                     
                // inicia o desmembramento da data do vencimento//
                $valor_dia=substr($row['pago'],8,2);
                $valor_mes=substr($row['pago'],5,2);
                $valor_ano=substr($row['pago'],0,4);
                // fim//
                $pago= $valor_dia."/".$valor_mes."/".$valor_ano;
              print "</FONT>
                     </TD>
                    <TD background='' bgColor=#f4f4f4>
                    <FONT face=System color=#7f7f7f>".$pago;
              print "</FONT>
                     </TD>
                     </TR>";


             ///////////////// FIM DO CORPO DO RELATORIO ////////////
    }
  }

print "</tbody></table>";
*/
//////////

//////////////////////////////////
 print "<TABLE cellSpacing=0 cellPadding=0 width='100%' border=1><TBODY> <p><p><br>";
 
 while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))      // executa enquanto houver resultados
    {


      if ($row["id_descricao"]!=$contador)  // procede a virada de subtotais
        {
        $cartao["$contador"]=$subtotal;
          if (impar($contador)){$cor="#c0c0c0";}else{$cor="#f9f5e6";} // troca cor de fundo
          if ($subtotal!=0){linha_branco();}  //verifica se subtotal e 0 e encerra com linha azul
        $contador=$contador+1;
        $subtotal=0;                          // zera o subtotal
        }
       
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
      ".$row["despesa"]."</font></td>

      <td
      valign='middle'
      align='right'
      width='6%'
      BGCOLOR=". $cor ."
      height='20'
      style='padding-left:4px'>
      <span style='font-family: Arial;
      font-size:14px; color:#000000;'>
      ". $row["valor"]."</font></td>

       <td
      valign='middle'
      align='right'
      width='5%'
      BGCOLOR=". $cor ."
      height='20'
      style='padding-left:4px'>
      <span style='font-family: Arial;
      font-size:14px; color:#000000;'>
      ". $row["valor_casa"]."</font></td>



      <td
      valign='middle'
      align='center'
      width='5%'
      BGCOLOR=". $cor ."
      height='20'
      style='padding-left:4px'>
      <span style='font-family: Arial;
      font-size:14px; color:#000000;'>
      ". date("d/m/Y", (strtotime ($row["data"])))."</font></td>

      <td
      valign='middle'
      align='center'
      width='5%'
      BGCOLOR=". $cor ."
      height='20'
      style='padding-left:4px'><strong>
     <font color =". status2($row["parcela"]).">
      ".$row["parcela"]."
      </strong></font></td>

");


      $subtotal=$subtotal+$row["valor"];    // atribui valor a subtotal
      $total=$total+$row["valor"];      // atribui valor a total geral acumulando

      if ($row["id_descricao"]<=3)   // acumula o valor dos cartoes de credito na variavel $despesas_cartao
        {
         $despesas_cartao["$contador"]=$subtotal;
        }



      $data1 = date("Y/m/d", (strtotime ($row["vencimento"])));
      $corr='';
      //alerta($row["vencimento"])
      print("
      <td
      valign='middle'
      align='right'
      width='10%'
      BGCOLOR=". $cor ."
      height='20'
      style='padding-left:4px'>
      <span style='font-family: Arial;
      font-size:14px; color=".Diferenca($data1)."'><strong>
      ". date("d/m/Y", (strtotime ($row["vencimento"])))."    ".$corr."</strong></font></td>
      ");

     // esta fun��o verifica a condi��o da data de pagamento:se for igual a 2001-01-01,
     // que � a data estipulada na inclusao da despesa, como flag que ainda n�o foi paga.
     //caso n�o tenha sido paga apresenta a informa��o nao 'paga!', caso tenha sido
     // apresenta a data do pagamento
     $aindanaopago=status($row["pago"],$cor,$row["valor"]);

                  if ($aindanaopago<>0)  // atribui a variavel naopago, o valor total que ainda n�o foi pago neste mes
                     {$naopago=($naopago+$row["valor"]); }

      }

 print "</tbody></table>";

 ?>



