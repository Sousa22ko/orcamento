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

//require("orcamento.inc");
require("functions.inc");


// Conexão com o banco
$conn = new mysqli("localhost", "orcamento", "orcamento", "orcamento");

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}


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
$pago= '2001-01-01';
$valido='S';
////////////////////////////////////////////////// trata a imagem que sera salva no BD /////////////////////////////
$imagem = $_FILES['imagem']['tmp_name'];
$tamanho = $_FILES['imagem']['size'];
$tipo = $_FILES['imagem']['type'];
$nome = $_FILES['imagem']['name'];




/////////////FUNCAO QUE VERIFICA SE A DATA DA DESPESA CONFORME SUA DESCRI��O, TEM ALGUMA DIA ESPECIFICO PARA VENCIMENTO ESTIPULADO ANTERIORMENTE
/////////////COLOCA ESSE DIA PARA MONTAR NOVA DATA, OU COLOCA DIA 01 CASO N�O TENHA NADA ESPECIFICADO ANTERIOMENTE, OU AINDA USA A DATA INFORMADA NO
/////////////FORMULARIO INCLUI_DESPESA.PHP

  function ver_data_antigo_no_outro_formato($id_descricao)
  {
     require("orcamento.inc");
  // estabelece a consulta com a tabela descri��o para saber o dia do vencimento ///////////
  $query="SELECT orcamento.descricao.*  FROM   orcamento.descricao WHERE  orcamento.descricao.id_descricao=$id_descricao";

         if ($result = mysqli_query($mysqli_connection, $query))
            {mysqli_num_rows($result);}

             while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))      // executa enquanto houver resultados
                   {return ($row["dia_vencimento"]);}
  }

/////////////////////////////////////////////////////

function ver_data($id_descricao)
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


print("<div><p></div>
        <div class='container p-3 mb-2 bg-success'>
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
       print "</td></tr>";

////////////////////////////////////////////////////////////////////////novo //////////////////////////////////
// Verifica se já existe
$sql = "SELECT despesa FROM despesa WHERE despesa = ? AND data = ? AND valor = ? AND ocorrencia = ?";
$stmt = $conn->prepare($sql);

// 🚨 Se a preparação falhou, exibir erro
if (!$stmt) {
    die("Erro ao preparar o SELECT: " . $conn->error);
}

$stmt->bind_param("ssds", $despesa, $novadata, $n_valor, $n_ocorrencia);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "<script>alert('Registro ja existe!');</script>";
} else {
    $stmt->close(); // Fechar primeiro statement antes de criar outro

    // Query SQL para inserção
    $sql = "INSERT INTO despesa (despesa, data, valor, valor_casa, ocorrencia, parcela, id_descricao, vencimento, pago, valido, obs, categoria) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    // 🚨 Se a preparação falhou, exibir erro
    if (!$stmt) {
        die("Erro ao preparar o INSERT: " . $conn->error);
    }

    // Associar os parâmetros corretamente
    $stmt->bind_param("ssddsssssssi", 
        $despesa,  
        $novadata, 
        $n_valor,  
        $valor_casa, 
        $n_ocorrencia, 
        $n_parcela,
        $id_descricao, 
        $datamod, 
        $pago, 
        $valido, 
        $texto, 
        $categoria
    );

    // Executar a query com os dados da despesa, caso seja bem sucedido, ela executa a nova query com a inclusão da imagem
    // na tabela tabela_imagem
        if ($stmt->execute()) {

        // caso a query seja bem sucedida, ou seja gravada com sucesso,
        // comecar a incluir a imagem vinculada a despesa
        if ( $imagem != "none" )
        {
            $fp = fopen($imagem, "rb");
            $conteudo = fread($fp, $tamanho);
            $conteudo = addslashes($conteudo);
            fclose($fp);

            $queryInsercao = "INSERT INTO tabela_imagens (nome_imagem,tamanho_imagem, tipo_imagem, imagem)                            
                              VALUES (?, ?, ?, ?)";                       
        
            $stmt = $conn->prepare($queryInsercao);             
            

        // 🚨 Se a preparação falhou, exibir erro
            if (!$stmt) {
                 die("Erro ao preparar o INSERT: " . $conn->error);
                 }

        // Associar os parâmetros corretamente
        $stmt->bind_param("ssss", 
        $nome,  
        $tamanho, 
        $tipo,  
        $conteudo
        );

            // 🚨 Se a preparação falhou, exibir erro
            if (!$stmt) {
                die("Erro ao preparar o INSERT: " . $conn->error);
            }

            if ($stmt->execute()) {              }
            else { echo "Erro ao inserir: " . $stmt->error;}
        }



        // echo "Registro inserido com sucesso!";
    } else {
        echo "Erro ao inserir: " . $stmt->error;
    }
}

///////////////////////////////////////////////////////////// end //////////////////////////////////////
   
  $cont++;
  $mes_inicio++;

  }

// Fechar conexão
$stmt->close();
$conn->close();


print ("</tbody></table>botao");
//mysqli_close($mysqli_connection);
?>


</BODY>
</HTML>
