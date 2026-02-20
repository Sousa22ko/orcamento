<HTML>
<HEAD>
 <TITLE>New Document</TITLE>
 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="css/bootstrap-datepicker.css" rel="stylesheet"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="js/bootstrap-datepicker.min.js"></script>
		<script src="js/bootstrap-datepicker.pt-BR.min.js" charset="UTF-8"></script>

 
 
 
 
</HEAD>

<BODY>

 <?php header("Content-Type: text/html; charset=ISO-8859-1",true);

require("orcamento.inc");
require("functions.inc");

// trazendo as variaveis do formulario inclui_despesa.php //////////////////////////
$despesa=($_POST["despesa"]);
$data=($_POST["data"]);
$valor=($_POST["valor"]);

$ocorrencia=($_POST["ocorrencia"]);
$parcela=($_POST["parcela"]);
$id_descricao=($_POST["id_descricao"]);
$categoria=($_POST["categoria"]);
$vencimento=($_POST["vencimento"]);
$texto=($_POST["texto"]);
$mes_inicio=substr($ocorrencia,0,2);
$ano_inicio=substr($ocorrencia,5,2);
$mes=substr($ocorrencia,0,2);
$ano=substr($ocorrencia,5,2);
$ocorrencia= (substr($ocorrencia,5,2).substr($ocorrencia,0,2));

////////////////////////////////////variaveis antigas //////////////////////////////////////////////////
$novadata=dateFormat($data);
$valor_casa=$valor;
$dia_vencimento=$vencimento;
//$valor_parcela=$valor/$parcela;





/////////////FUNCAO QUE VERIFICA SE A DATA DA DESPESA CONFORME SUA DESCRI��O, TEM ALGUMA DIA ESPECIFICO PARA VENCIMENTO ESTIPULADO ANTERIORMENTE
/////////////COLOCA ESSE DIA PARA MONTAR NOVA DATA, OU COLOCA DIA 01 CASO N�O TENHA NADA ESPECIFICADO ANTERIOMENTE, OU AINDA USA A DATA INFORMADA NO
/////////////FORMULARIO INCLUI_DESPESA.PHP

  function ver_data($id_descricao)
  {
     require("orcamento.inc");
  // estabelece a consulta com a tabela descri��o para saber o dia do vencimento ///////////
  $query="SELECT orcamento.descricao.*
  FROM   orcamento.descricao
  WHERE  orcamento.descricao.id_descricao=$id_descricao";

         if ($result = mysqli_query($mysqli_connection, $query))
            {mysqli_num_rows($result);}

             while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))      // executa enquanto houver resultados
                   {return ($row["dia_vencimento"]);}
  }
/////////////////////////////////////////////////////


///
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











///////////// SUBMETE A VARIAVEL ID_DESCRI��O VINDO DO FORMULARIO, A FUN��O VER_DATA PARA ESTABELECER QUAL SERA A NOVA DATA DO VENCIMENTO.
//$id_descricao=($_POST["id_descricao"]);   //  recebe a variavel id_descri��o do formulario

 $dia_venc=ver_data("$id_descricao");          // submete a variavel id_descri��o para a funcao ver_data
                                              //para buscar a data de vencimento correspondente e coloca na variavel $dia_venc


 $ndia_venc=nova_data("$dia_venc","$vencimento");          // submete a variavel $dia_venc e $vencimento para a funcao nova_data
                                                           // para buscar o dia inicial da despesa, j� modificado, dependendo do tipo de
                                                           // despesa, ou da data espeficidada para  o vencimento.
 $cont=$mes_inicio;                                               // inicia a variavel transferindo para ela, o mes de onde vai iniciar o debito da despesa


print(" <p><div class='container p-3 mb-2 bg-success'>
          <div class='row'>
                <div class='col-md-4'>
                    <div class='form-group'>
                    <button type='button' class='btn btn-primary'>Confirma Inclusao da Despesa
                    <span class='badge badge-light'>confirma Inclui</span>
                    </button>
                    </div>
                </div>
             </div>
         <table class='table table-striped table-bordered table-condensed table-hover'>
                <thead>
                  <tr>
                     <th>Despesa</th>
                     <th>Data</th>
                     <th>Valor da Despesa</th>
                     <th>parcela</th>
                     <th>ocorr</th>
                     <th>Valor Parcela</th>
                  </tr>
               </thead>
             <tbody>
");










 for($i=1;$i<$parcela+1;$i++)
  {
    if ($mes_inicio>=13)
       {$mes_inicio=1; $ano_inicio++; $cont=1;}

       print "<tr><td>".$despesa;
       print "</td><td>".$data;
       print "</td><td>".$valor;
       // print "</td><td>".$valor_casa;

       $n_parcela=(sprintf("%02d", $i)."/".sprintf("%02d", $parcela));     // numero da parcela
       print "</td><td>".$n_parcela;   // numero da parcela

       //print "</td><td>".$id_descricao;
       //print "</td><td>".$categoria;


       $datamod=dateformat2(($ndia_venc.(sprintf("%02d", $mes_inicio))."20".$ano_inicio)); // data do vencimento tratado para o banco de dados
       //print "</td><td>".$datamod; // data do vencimento tratado para o banco de dados


       $n_ocorrencia= ((sprintf("%02d", $ano_inicio)).(sprintf("%02d", $cont)));   // valor da ocorrencia
       print "</td><td>".$n_ocorrencia;                                           // valor da ocorrencia

      ///////////////////////////////////////
       $n_valor=(sprintf("%02.2f", ($valor)));    // atribui a variavel $n_valor o valor de $valor, que possui o valor total da compra
       if ($parcela>1){$n_valor=(sprintf("%02.2f", ($valor/$parcela)));}  // caso o numero de parcelas seja maior que 1, o valor da
                                                                          // compra sera dividido pelo numero de parcelas, gerando um novo valor de $n_valor
      //////////////////////////////////////
       print "</td><td>".$n_valor;

       
       //print "</td><td>".$texto;

       print "</td></tr>";

       $query = "INSERT INTO despesa (despesa,data,valor,valor_casa,ocorrencia,parcela,id_descricao,vencimento,pago,valido,obs,categoria) values ";
       $query = $query . "('$despesa','$novadata',$n_valor,$valor_casa,'$n_ocorrencia','$n_parcela' ,'$id_descricao','$datamod','2001-01-01','S','$texto','$categoria')";


       // conexao com o banco de dados orcamento.
       // mandando salvar as variaveis na tabela descri��o
       mysqli_query($mysqli_connection,$query) or die("Erro ao tentar cadastrar registro");



  $cont++;
  $mes_inicio++;


  }
print ("</tbody></table>botao");
mysqli_close($mysqli_connection);
?>


</BODY>
</HTML>
