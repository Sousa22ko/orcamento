<?php

require_once ("config.php");


  ////////////////////////////////////////////////////////
  function impar($valor)   //par_ou_impar
  { return ($valor % 2);  }
  ////////////////////////////////////////////////////////



  ////////////////////////////////////////////////////////           (atualizada em 17/04/25)
  function obtem_dados_aux ($tablename,$coluna,$ordem)
        {
      // Função que conecta ao banco, já definida em seu config.php
      $conn = conectar();

      if($conn->connect_error){
        echo "n�o conectou aux! Erro: " . $conn->connect_error;}

        $query="select * from $tablename order by $coluna $ordem";
        $result = mysqli_query($conn, $query);        
        return $result;
        }
    ////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////// apagar///
// print $tablename.$coluna.$ordem;    
// banco de dados auxiliar //
//$host="localhost";
///$user_aux = "orcamento";
//$password_aux = "orcamento";
//$dbname_aux = "orcamento";
//$link_aux = new MySQLi($host, $user_aux, $password_aux, $dbname_aux);




///////////////////////////////////////////////////////           (atualizada em 19/04/25)
function valor_data(){
$today = getdate();
$hoje = (date("d/m/Y", mktime (0,0,0,$today['mon'],$today['mday'],$today['year'])));
$ano = substr($hoje,8,4);
$mes = substr($hoje,3,2);
$dia = substr($hoje,0,2);
$valor_data=$dia.'/'.$mes.'/20'.$ano;
return $valor_data;
}

///////////////////////////////////////////////////////           (atualizada em 19/04/25)
function proximo_mes(){
$proximoMes = date('m/Y', strtotime('+1 month')); // Obtém o próximo mês e ano
return $proximoMes;
}

///////////////////////////////////////////////////////           (atualizada em 19/04/25)
function este_mes(){
  $esteMes = date('m/Y', strtotime('+0 month')); // Obtém este mês e ano
return $esteMes;
}

////////////////////////////////////////////////////////  (atualizada em 19/04/25)
//converte a data do formulario de entrada dd/mm/aaaa em aaaa-mm-dd para gravar no bd
function dateFormat1 ($data)
{
return (substr($data,6,4).'-'.substr($data,3,2).'-'.substr($data,0,2));  
}
//////////////////////////////////////////////////////// 



///////////////////////////////////////////////////////  (atualizada em 19/04/25)
function mostrar_alerta($mensagem, $tipo = 'info') {
    // $tipo pode ser: 'success', 'danger', 'warning', 'info'
    echo "
    <div class='container bg-beige'>
        <div class='alert alert-$tipo alert-custom' role='alert'>
            <strong>$mensagem</strong>
        </div>
    </div>
    ";
}
/////////////////////////////////////////////////////////////////////////////



  
  
  
   ////////////////////////////////////////////////////////
   //converte a data do formulario de entrada dd/mm/aaaa em aaaa/mm/dd para gravar no bd
   function dateFormat ($data)
   {
   return (substr($data,6,4).substr($data,3,2).substr($data,0,2));
   }
  ////////////////////////////////////////////////////////
  




  
    ////////////////////////////////////////////////////////
   //converte a data do formulario de entrada dd/mm/aaaa em aaaa/mm/dd para gravar no bd
   function dateFormat2 ($data)
   {
   return (substr($data,4,4).substr($data,2,2).substr($data,0,2));
   }
  ////////////////////////////////////////////////////////
                                                                                          // 27032025
       ////////////////////////////////////////////////////////
   //converte a data do formulario de entrada dd/mm/aaaa em aaaa/mm/dd para gravar no bd
   function dateFormat3 ($data)
   {
   return (substr($data,0,2).substr($data,5,2));
   }
  ////////////////////////////////////////////////////////


  ////////////////////////////////////////////////////////
   function mensagem($texto)
  { print("

  <P>&nbsp;</P><P>&nbsp;</P><P>&nbsp;</P><P>&nbsp;</P><P>
   <TABLE style='WIDTH: 303px; HEIGHT: 65px' borderColor=#7d9ec0 cellSpacing=10
    cellPadding=10 width=303 align=center borderColorLight=#7b7bc0 background='' border=4>
    <TBODY>
    <TR>
      <TD>
      <P align=center>
      <FONT face=System color=#0d74f2>
      <p align=center><b>". $texto ."</b></p>
      <p align=center><input type=button Value=Incluir_mais ONClick=javascript:history.go(-1)> </p>
      </FONT></P>
      </TD>
      
      
      <TD>
      <P align=center>
      <FONT face=System color=#0d74f2>
      <p align=center><b>Inicio</b></p>
      <p align=center><input type=button Value=Inicio ONClick=javascript:history.go(-2)> </p>
      </FONT></P>
      </TD>
      
      
      
      
      
      
      
      
      </TR>
      </TBODY>
    </TABLE>
    </P>
        ");
        exit;
     }
    ////////////////////////////////////////////////////////
    
    
    ////////////////////////////////////////////////////////
    function linha_branco()
             {
             print
             ("<tr>
             <TD background='' bgColor=#004080></TD>
             <TD background='' bgColor=#004080></TD>
             <TD background='' bgColor=#004080></TD>
             <TD background='' bgColor=#004080></TD>
             <TD background='' bgColor=#004080></TD>
             <TD background='' bgColor=#004080></TD>
             <TD background='' bgColor=#004080></TD>
             <TD background='' bgColor=#004080></TD>


             </tr>");
             }
    ////////////////////////////////////////////////////////
    
    
    ////////////////////////////////////////////////////////
  function traduz_mes($mes)

  {if ($mes == "01")
   {$val_mes="Janeiro";}

   elseif ($mes == "02")
   {$val_mes="Fevereiro";}

   elseif ($mes == "03")
   {$val_mes="Mar�o";}

   elseif ($mes == "04")
   {$val_mes="Abril";}
   
   elseif ($mes == "05")
   {$val_mes="Maio";}
   
   elseif ($mes == "06")
   {$val_mes="Junho";}
   
   elseif ($mes == "07")
   {$val_mes="Julho";}
   
   elseif ($mes == "08")
   {$val_mes="Agosto";}
   
   elseif ($mes == "09")
   {$val_mes="Setembro";}
   
   elseif ($mes == "10")
   {$val_mes="Outubro";}
   
   elseif ($mes == "11")
   {$val_mes="Novembro";}
   
   elseif ($mes == "12")
   {$val_mes="Dezembro";}

   return $val_mes;
  }



  function input_mes($texto)
   {print ("<FONT size=2>
   <FONT color=#00005e>
   <STRONG>".$texto.":&nbsp;</STRONG>
   <select size=1 name=mes_inicio &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; >
   <option Value='01'>Janeiro</option>
   <option Value='02'>Fevereiro</option>
   <option Value='03'>Mar�o</option>
   <option Value='04'>Abril</option>
   <option Value='05'>Maio</option>
   <option Value='06'>Junho</option>
   <option Value='07'>Julho</option>
   <option Value='08'>Agosto</option>
   <option Value='09'>Setembro</option>
   <option Value='10'>Outubro</option>
   <option Value='11'>Novembro</option>
   <option Value='12'>Dezembro</option>
   </select> ");
   }

  function input_ano2($textoano)
   {print ("<FONT size=2>
   <FONT color=#00005e>
   <STRONG>".$textoano.":&nbsp;</STRONG>
   <select size=1 name=ano_inicio>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <option Value='25'>2025</option>
   <option selected Value='24'>2024</option>
   <option Value='23'>2023</option>
   <option Value='22'>2022</option>
   </select> ");
   }


  function input_ano3($textoano)
   {
   // determino qual � o ano corrente, com formato de 02 digitos para colocar como
   // selected na pesquisa
   $today = getdate();
   $hoje = (date("d/m/Y", mktime (0,0,0,$today['mon'],$today['mday'],$today['year'])));
   $mes = substr($hoje,3,2);

   { if ($mes>=11)
          $ano = substr($hoje,8,2)+1;
        else
          $ano = substr($hoje,8,2)+0;}

   $a=($ano-1);       //diminue o range para buscar um ano antes do atual

   print ("<FONT size=2>
   <FONT color=#00005e>
   <STRONG>".$textoano."</STRONG>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

   <select size=1 name=ano_inicio>" );
   for ($a;$a<($ano+2);$a++)

     {  if ($a==($ano))
          print "<option Value=".sprintf('%02d',$a)." selected>20".sprintf('%02d',$a)."</option>";
        else
          print "<option Value=".sprintf('%02d',$a).">20".sprintf('%02d',$a)."</option>";
      }

    print ("</select>");
}




///////////////////////////////////////////////////////  (atualizada em 20/04/25)
function modal($mensagem, $tipo) {
    echo '
    <!-- Botão invisível para disparar o modal -->
    <button type="button" id="triggerModal" class="btn btn-primary d-none" data-toggle="modal" data-target="#resultadoModal"></button>

    <!-- Modal -->
    <div class="modal fade" id="resultadoModal" tabindex="-1" role="dialog" aria-labelledby="resultadoModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-' . $tipo . ' text-white">
            <h5 class="modal-title" id="resultadoModalLabel">Resultado</h5>
          </div>
          <div class="modal-body">
            <p>' . $mensagem . '</p>
          </div>
          <div class="modal-footer">
            <a href="fundo.html" class="btn btn-primary">Voltar</a>
          </div>
        </div>
      </div>
    </div>

    <script>
      // Dispara o modal automaticamente ao carregar a página
      window.onload = function() {
        document.getElementById("triggerModal").click();
      };
    </script>
    ';
}


/////////////////////////////////////////////////////  (atualizada em 21/04/25)

/////////////FUNCAO QUE VERIFICA SE A DATA DA DESPESA CONFORME SUA DESCRI��O, TEM ALGUMA DIA ESPECIFICO PARA VENCIMENTO ESTIPULADO ANTERIORMENTE
/////////////COLOCA ESSE DIA PARA MONTAR NOVA DATA, OU COLOCA DIA 01 CASO N�O TENHA NADA ESPECIFICADO ANTERIOMENTE, OU AINDA USA A DATA INFORMADA NO
/////////////FORMULARIO INCLUI_DESPESA.PHP

  function ver_data($id_descricao)
  {  
    // config.php tem a conexao com o banco de dados
    require_once ("config.php");

     // Função que conecta ao banco, já definida em seu config.php
     $conn = conectar();

    // Verifica se já existe
    $sql = "SELECT descricao.* FROM descricao WHERE descricao.id_descricao = ?";

    // prepara a query
    $stmt = $conn->prepare($sql);

    // 🚨 Se a preparação falhou, exibir erro
    if (!$stmt) {die("Erro ao preparar o SELECT: " . $conn->error);}

    // monta o sql com os dados nas variaveis recebidas pela funcao
    $stmt->bind_param("d",$id_descricao);

  // se a execução do sql for bem sucedida ele cria um objeto $result com o resultado da sql
    if ($stmt->execute()) {
        $result = $stmt->get_result();

        /// se o resultado da sql for maior que 0. significa que ela encontrou uma resposta
        if ($result->num_rows > 0) 
        // cria um array com os resultados encontrados e coloca em um array associativo com o campo desejado
        $descricao = $result->fetch_all(MYSQLI_ASSOC);  // Se você quiser usar foreach, primeiro você precisa transformar o resultado em array  
                                                        //fetch_all() traz todas as linhas de uma vez, e só funciona se você usar MYSQLI_ASSOC como parâmetro.
        // passa pelos array encontrados, apresentando o resultado da sql. 
        //neste caso retorna para onde a função foi chamada, o resultado da dia do vencimento da tabela  
        foreach ($descricao as $row)  {return ($row["dia_vencimento"]);}        
        }




     //require("orcamento.inc");
    // estabelece a consulta com a tabela descri��o para saber o dia do vencimento ///////////
    //$query="SELECT orcamento.descricao.*  FROM   orcamento.descricao WHERE  orcamento.descricao.id_descricao=$id_descricao";
       //  if ($result = mysqli_query($mysqli_connection, $query))
     //{mysqli_num_rows($result);}
       //     while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))      // executa enquanto houver resultados
         //          {return ($row["dia_vencimento"]);}

    // Fechar conexões
    $stmt->close();
    $conn->close();     
  }


/////////////////////////////////////////////////////  (atualizada em 21/04/25)
function nova_data($dia_venc,$vencimento)
  {
// tratamento da nova data $dia_venc acima
if ($dia_venc) {
    //caso a variavel $dia_venc tenha um dia de vencimento especifico na tabela descri��o
    // ela ser� utilizada para a data do novo vencimento
    // caso n�o tenha um dia especifico, ela poder� usar o dia 01 para montagem da nova data,
    // ou escolher alguma data especifica informada no formulario inclui_despesa.php
} elseif (!$vencimento) {
    // nesse caso o vencimento ser� dia 01:
    $dia_venc="01";
} else {
    {
    //  caso a variavel $id_venc seja em branco e tenha sido escolhido uma data de vencimento da despesa,
    //  a nova data sera formada dos 2 primeiros digitos da data de vencimento escolhida na data de vencimento do formulario
        $dia_venc= substr($vencimento,0,2);
    }
 }

  return $dia_venc;
 }


/////////////////////////////////////////////////////  (atualizada em 09/05/25)
// esta função pega a data do dia e abate 10 dias e soma 10 dias para verificar o vencimento a aparecer no pop-up
function getRangeDatas_Anterior(){ 

    // Data atual (meia-noite, UTC)
    $hoje = new DateTime('now', new DateTimeZone('UTC'));
    $hoje->setTime(0, 0, 0);

    // Data 10 dias antes
    $data_inicio = clone $hoje;
    $data_inicio->modify('-10 days');

    // Data 10 dias depois
    $data_fim = clone $hoje;
    $data_fim->modify('+10 days');

    // Formata e retorna as datas no padrão yyyy-mm-dd (igual ao banco)
 
    return [
        'data_inicio' => $data_inicio->format('Y-m-d'),
        'data_fim'    => $data_fim->format('Y-m-d')
    ];

}
////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////  (atualizada em 14/05/25)
// esta função pega a data do dia e abate 10 dias e soma 10 dias para verificar o vencimento a aparecer no pop-up
function getRangeDatas() {
    $conn = conectar();

    $consulta = "SELECT * FROM configuracao WHERE modulo = 'popup_vencimento'";
    $stmt = $conn->prepare($consulta);

    if (!$stmt) {
        die("Erro ao preparar a consulta: " . $conn->error);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $valores_MinMax = $result->fetch_assoc(); // ✅ Uma única linha como array associativo

    if (!$valores_MinMax) {
        die("Nenhum valor encontrado.");
    }

    // Data atual em UTC, zerando o horário
    $hoje = new DateTime('now', new DateTimeZone('UTC'));
    $hoje->setTime(0, 0, 0);

    // Calcula datas com base nos valores retornados
    $data_inicio = clone $hoje;
    $data_inicio->modify($valores_MinMax['valor1'] . ' days'); // ✅ espaço antes de 'days'

    $data_fim = clone $hoje;
    $data_fim->modify($valores_MinMax['valor2'] . ' days');

    return [
        'data_inicio' => $data_inicio->format('Y-m-d'),
        'data_fim'    => $data_fim->format('Y-m-d')
    ];
}

////////////////////////////////////////////////////////////////////////








/////////////////////////////////////////////////////  (atualizada em 03/05/25)
// esta função pega a data do dia e retorna a diferença entre a data do dia e do vencimento
function dif($dataVencimento){    

    // Define a data atual com fuso UTC, forçando a hora para meia-noite
    $DataEntrada = new DateTime('now', new DateTimeZone('UTC'));
    $DataEntrada->setTime(0, 0, 0);

      // Define a data de vencimento, também forçando a hora para meia-noite
    $vencimento = new DateTime($dataVencimento, new DateTimeZone('UTC'));
    $vencimento->setTime(0, 0, 0);

    // Calcula a diferença
    $intervalo = $DataEntrada->diff($vencimento);

    // retorna o número de dias
    return($intervalo->format('%r%a dias'));
}
////////////////////////////////////////////////////////////////////////










/////////////////////////////////////////////////////     apagar.;;;;;;;;;;; 21/04/25

function ver_datas($id_descricao)
{
    // Conexão com o banco
    $conn = new mysqli("localhost", "orcamento", "orcamento", "orcamento");

    // Verifica se houve erro na conexão
    if ($conn->connect_error) {  die("Erro na conexão: " . $conn->connect_error);  }

    // Preparar a query com um parametro
    $sql = "SELECT dia_vencimento FROM descricao WHERE id_descricao = ?";
    $stmt = $conn->prepare($sql);

    // Se a preparação falhou, exibir erro
    if (!$stmt) { die("Erro ao preparar o SELECT: " . $conn->error);  }

    // Passar o parâmetro
    $stmt->bind_param("i", $id_descricao);   // é o valor da pesquisa da consulta

    // executa a consulta
    $stmt->execute();
    $stmt->store_result();

    // Associar o resultado corretamente
    $stmt->bind_result($dia_vencimento);  // dia _vencimento é o nome do campo da tabela descrição que retornará pelo return

    // Buscar e retornar o valor encontrado
    if ($stmt->fetch()) {
        return $dia_vencimento;
    } else {
        return null; // Retorna null se não encontrar o $dia_vencimento;
    }

    // Fechar conexões
    $stmt->close();
    $conn->close();
}
////////////////////////////////////////////////////////mmmmmmmmmmmmmmmmmmmmmm

















///////////////////////////////////////////////////////////////////////////////////////////////////




  function input_mes3($texto)
   {
   // determino qual � o ano corrente, com formato de 02 digitos para colocar como
   // selected na pesquisa
   $today = getdate();
   $hoje = (date("d/m/Y", mktime (0,0,0,$today['mon'],$today['mday'],$today['year'])));
   //$mes = substr($hoje,3,2);

   $mes = substr($hoje,3,2);
   $a=1;
   
      if ($texto=='Despesa ser� paga no m�s de')
      {$mes++; }

   print ("<FONT size=2>
   <FONT color=#00005e>
   <STRONG>".$texto."</STRONG>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

   <select size=1 name=mes_inicio>" );
   for ($a;$a<13;$a++)

     {  if ($a==($mes))                                          // traduz_mes(sprintf('%02d',$a))
          print "<option Value=".sprintf('%02d',$a)." selected>".traduz_mes(sprintf('%02d',$a))."</option>";
        else
          print "<option Value=".sprintf('%02d',$a).">".traduz_mes(sprintf('%02d',$a))."</option>";
      }

    print ("</select>");
}

















  function input_ano($textoano)
   {
   // determino qual � o ano corrente, com formato de 02 digitos para colocar como
   // selected na pesquisa
   $today = getdate();
   $hoje = (date("d/m/Y", mktime (0,0,0,$today['mon'],$today['mday'],$today['year'])));
   $ano = substr($hoje,8,2)+1;
   $mes = substr($hoje,3,2);


   { if ($mes==11)                    // quando chega ao mes de dezembro ele abre oportunidade de cria��o de
          $ano = substr($hoje,8,2)+1; // novas despesas para o ano seguinte.
        else
          $ano = substr($hoje,8,2)+0;}

   $inicio = $ano;
   print ("<FONT size=2>
   <FONT color=#00005e>
   <STRONG>".$textoano."&nbsp;</STRONG>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

   <select size=1 name=ano_inicio>" );

   for($a = $inicio; $a >= 23; $a--)  // a variavel $a>= informa qual o ano inicial do ano


      { if ($opcao1==$a)
          print "<option Value=".sprintf('%02d',$a)."selected>20".sprintf('%02d',$a)."</option>";
        else
          print "<option Value=".sprintf('%02d',$a).">20".sprintf('%02d',$a)."</option>";
      }


    print ("</select>"); 

   }





    function lista_mes_old($textomes,$opcao1)
    {print ("
    <FONT color=#00005e size=2>
    <STRONG>&nbsp;&nbsp;&nbsp;&nbsp;".$textomes.":&nbsp;</STRONG>
    <select size=1 name=mes_inicio>" );
    for ($a=1;$a<13;$a++)
      { if ($opcao1==$a)
          print "<option Value=$a selected>$a</option>";
        else
          print "<option Value=$a>$a</option>";
      }
    print ("</select>");
    }


    function lista_mes($textomes,$opcao1)
    {// determino qual � o mes corrente, com fo de 02 digitos para colocar como
     // selected na pesquisa
     $today = getdate();
     $hoje = (date("d/m/Y", mktime (0,0,0,$today['mon'],$today['mday'],$today['year'])));
     $mes = substr($hoje,3,2);
     
     // acrescenta mais um ao mes, no caso especifico de inclusao de novas despesas
     if (!empty($opcao1))
     { $mes++; }
     // fim

    print ("
    <FONT color=#00005e size=2>
    <STRONG>&nbsp;&nbsp;&nbsp;&nbsp;".$textomes.":&nbsp;</STRONG>
    <select size=1 name=mes_inicio>" );
    for ($a=1;$a<13;$a++)
      { if ($mes==sprintf('%02d',$a))
          print "<option Value=".sprintf('%02d',$a)." selected>".trad_mes($a)."</option>";
        else
          print "<option Value=".sprintf('%02d',$a).">".trad_mes($a)."</option>";
      }
    print ("</select>");
    }


    // pega um texto adcional e a variavel mes_inicio e transforma
    // buscando do banco de dados mes.
    function traduzir_mes($textomes,$opcao1)
    {print ("&nbsp;&nbsp;&nbsp;&nbsp;".$textomes."&nbsp;");
     $result=obtem_dados_aux("mes","id_mes","asc") or  die (mysql_error());
     $linhas=mysqli_num_rows($result);
     for($i=0;$i<$linhas;$i++)
       {$array[$i]=mysqli_fetch_array($result);
          if ($opcao1==$array[$i][0])
             {print $array[$i][1];}
       }
     }

     // pega uma variavel mes_inicio e busca no banco de dados mes
    function trad_mes($opcao)
    {print ("&nbsp;&nbsp;&nbsp;&nbsp;".$textomes."&nbsp;");
     $result=obtem_dados_aux("mes","id_mes","asc") or  die (mysql_error());
     $linhas=mysql_num_rows($result);
     for($i=0;$i<$linhas;$i++)
       {$array[$i]=mysql_fetch_array($result);
          if ($opcao==$array[$i][0])
             {return $array[$i][1];}
       }
     }




   function lista_ano($textoano,$opcao2)
   {print ("
    <FONT color=#00005e size=2>
    <STRONG>&nbsp;&nbsp;&nbsp;&nbsp;".$textoano.":&nbsp;</STRONG>
    <select size=1 name=ano_inicio>" );
    for ($b=2023;$b<2025;$b++)

      { if ($opcao2==$b)
          print "<option Value=$b selected>$b</option>";
        else
          print "<option Value=$b>$b</option>";
      }
    print ("</select>");
    }


    function alertaxx ($vence)
    {
           $today = getdate();
           $hoje = (date("d/m/Y", mktime (0,0,0,$today['mon'],$today['mday'],$today['year'])));
           // print "hoje ".$hoje."<br>";

           //$vence='2006-12-19';
           $vence=date("d/m/Y", (strtotime ($vence)));
           print "vence ".$vence."<br>";


           $hoje_mais5=date("d/m/Y", mktime (0,0,0,$today['mon'],$today['mday']+5,$today['year']));
           //print "mais10 ".$hoje_mais5."<br>";


        //   if (($hoje_mais5 < $vence))
      //      {$tipo='blue';}

      //     if (($hoje_mais5 >= $vence))
       //      {$tipo='red';}

       //  return  $tipo;
       
   }




function grava_cartao($cartao_total,$busca)
{
        require("orcamento.inc");
        // estabelece a primeira query ///////////
        $query="SELECT orcamento.despesa_cartao.*
        FROM orcamento.despesa_cartao
        WHERE orcamento.despesa_cartao.ocorrencia = '$busca'";

        // Executa a primeira query sql
        $result = mysqli_query ($link_aux,$query) or die ("N�o consegui consultar" . $query . mysqli_error());
        $ano='20'.substr($busca,0,2);
        
        if (!mysqli_num_rows($result))
        {
             $query = "INSERT INTO despesa_cartao (valor,id_descricao,ocorrencia,ano) values ";
             
             
             $query = $query . "('$cartao_total','1','$busca','$ano')";
             // executa a sql para a inclus�o, usando a variavel $link localizado em fotografia.php
             mysqli_query($link_aux,$query) or die(mysqli_error($link_aux));
         }
         else
         {

            $query = "UPDATE despesa_cartao
                SET valor='$cartao_total',
                id_descricao='1',
                ocorrencia='$busca',
                ano='$ano'
                WHERE ocorrencia ='$busca'";
               // print $query;
                mysqli_query($link_aux,$query)or die(mysqli_error($link_aux));
         }
}



Function Diferenca($data1){
//print $data1;
$data2 = date("Y/m/d");
$corr='';
$origin = new DateTime($data2);
$target = new DateTime($data1);
$interval = $origin->diff($target);

$difere= $interval->format('%R%a') . "\n";

if ($difere >= 0) {
    { $corr='#FF8080';}
} elseif ($difere <= -5) {
    { $corr='#FF0000';}
} elseif ($difere >= -5 & $difere <= -1 ) {
     { $corr='#FFFF00';}
}

//return $difere;
//print $difere. "   ". $corr;
return $corr;
}














Function Diferenca_old($data1){


print $data1;
$tipo="D";
$data2 = date("d/m/Y");
// print $data2;
for($i=1;$i<=2;$i++){
${"dia".$i} = substr(${"data".$i},0,2);
${"mes".$i} = substr(${"data".$i},3,2);
${"ano".$i} = substr(${"data".$i},6,4);
${"horas".$i} = substr(${"data".$i},11,2);
${"minutos".$i} = substr(${"data".$i},14,2);
}

$segundos = mktime(0,0,0,$mes1,$dia1,$ano1)-mktime(0,0,0,$mes2,$dia2,$ano2);
//$difere = $segundos/-86400000;
$difere=3;
//print "----:".$difere;

if ($difere >= +5)
   { $cor_letra='#1FA70C';
   }

if ($difere <= 0)
    { $cor_letra='red';
    }

if (($difere >= 1)&($difere <= +4))
    { $cor_letra='blue';
    }

return $cor_letra;
}



// verifica a condi��o da data de pagamento: se for igual a 2001-01-01, que �
//a data estipulada na inclusao da despesa, como flag que ainda n�o foi paga.
function status ($data_pagamento,$cor,$valor)
{
  // print  "aaaaaaa ".$data_pagamento."ccccccddd ". $cor."ddddddd ". $valor ;

   $msg=date("d/m/Y", (strtotime($data_pagamento)));
  // print $msg;
   $fontcolor='#61616F';

   if ($data_pagamento=="2001-01-01")
      {$msg='<strong> N�o Pago! </strong>';
       $falta_pagar=$valor;
     //  print "iiiiiii ". $falta_pagar;
       $fontcolor='#FF0000';
      // print $msg;
       }
       else {
       $falta_pagar=0; }

      
   print("
          <td
          valign='middle'
          align='right'
          width='10%'
          BGCOLOR=". $cor ."
          height='20'
          style='padding-left:4px'>
         <span style='font-family: Arial;
         font-size:14px; color:".$fontcolor.";'>
         ". $msg."</font></td>
         ");
      
      
   return $falta_pagar;
}



function stringParaBusca($str)
    {
	//Transformando tudo em min�sculas
	$str = trim(strtolower($str));

	//Tirando espa�os extras da string... "tarcila  almeida" ou "tarcila   almeida" viram "tarcila almeida"
	while ( strpos($str,"  ") )
		$str = str_replace("  "," ",$str);

	//Agora, vamos trocar os caracteres perigosos "�,�..." por coisas limpas "a"
	$caracteresPerigosos = array ("�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","!","?",",","�","�","-","\"","\\","/");
	$caracteresLimpos    = array ("a","a","o","o","a","a","e","e","i","i","o","o","u","u","c","c","a","a","e","e","i","i","o","o","u","u","a","a","e","e","i","i","o","o","u","u","A","E","I","O","U","a","e","i","o","u",".",".",".",".",".",".","." ,"." ,".");
	$str = str_replace($caracteresPerigosos,$caracteresLimpos,$str);

	//Agora que n�o temos mais nenhum acento em nossa string, e estamos com ela toda em "lower",
	//vamos montar a express�o regular para o MySQL
	$caractresSimples = array("a","e","i","o","u","c");
	$caractresEnvelopados = array("[a]","[e]","[i]","[o]","[u]","[c]");
	$str = str_replace($caractresSimples,$caractresEnvelopados,$str);
	$caracteresParaRegExp = array(
		"(a|�|�|�|�|�|&atilde;|&aacute;|&agrave;|&auml;|&acirc;|�|�|�|�|�|&Atilde;|&Aacute;|&Agrave;|&Auml;|&Acirc;)",
		"(e|�|�|�|�|&eacute;|&egrave;|&euml;|&ecirc;|�|�|�|�|&Eacute;|&Egrave;|&Euml;|&Ecirc;)",
		"(i|�|�|�|�|&iacute;|&igrave;|&iuml;|&icirc;|�|�|�|�|&Iacute;|&Igrave;|&Iuml;|&Icirc;)",
		"(o|�|�|�|�|�|&otilde;|&oacute;|&ograve;|&ouml;|&ocirc;|�|�|�|�|�|&Otilde;|&Oacute;|&Ograve;|&Ouml;|&Ocirc;)",
		"(u|�|�|�|�|&uacute;|&ugrave;|&uuml;|&ucirc;|�|�|�|�|&Uacute;|&Ugrave;|&Uuml;|&Ucirc;)",
		"(c|�|�|&ccedil;|&Ccedil;)" );
	$str = str_replace($caractresEnvelopados,$caracteresParaRegExp,$str);

	//Trocando espa�os por .*
	$str = str_replace(" ",".*",$str);

	//Retornando a String finalizada!
	return $str;
}



// verifica a condi��o da parcela: se a divis�o for igual a 1
//significa que a parcela inicial � igual a parcela final.
function status22 ($parcela)
{

   $parcela_inicio=substr($parcela,0,1);
   $parcela_final=substr($parcela,2,1);
   
   $fontcolor='#FF0000';

   if ($parcela_inicio==$parcela_final)
      {
      $fontcolor='#D5D9EC';
      }
     
   return $fontcolor;
}



function status2 ($parcela)
{
$tamanho = strlen($parcela);
//$pos = strpos($parcela, '/');
$fontcolor='#606060';

switch ($tamanho) {
    case 3:
         $parcela_inicio=substr($parcela,0,1);
         $parcela_final=substr($parcela,2,1);   break;
    case 4:
         $parcela_inicio=substr($parcela,0,1);
         $parcela_final=substr($parcela,2,2);  break;
    case 5:
         $parcela_inicio=substr($parcela,0,2);
         $parcela_final=substr($parcela,3,2);  break;
}

$resto =($parcela_inicio/$parcela_final);

if($resto<>1) {$fontcolor='#FF8080';}
return $fontcolor;
}






function parcela_func($parc){
if ($parc<>'01/01')
    {$resp = ('<font color="#FF0000">'. $parc. '</font>');}
else
    {$resp = ($parc);}
return $resp;
}



function pago_func($pg) {
if ($pg=='2001-01-01')
    {$resp = ('<strong><font color="#FF0000">N Pago</font></strong>');}
 else
   {$resp = (date("d/m/Y", (strtotime($pg))));}
return $resp;
}

















?>



