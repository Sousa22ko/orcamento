<?php
require_once ("config.php");
require("functions.inc");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orcamento</title>

  <!-- Bootstrap 3 CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">      

  <!-- Datepicker CSS -->
  <link href="css/bootstrap-datepicker.css" rel="stylesheet">

  <!-- Seu estilo -->
  <link rel="stylesheet" href="./styles.css">

  <style>
    .container {
      margin: 15px;
      margin-top: 90px;
    }
  </style>
</head>

<body>

<?php header("Content-Type: text/html; charset=UTF-8", true);    // ajusta os acentos na lingua portuguesa

// Função que conecta ao banco, já definida em seu config.php
$conn = conectar();

// verifica se as variaveis vieram realmente de um formulario anteriormente enviado. messe caso por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
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
  //$mes=substr($ocorrencia,0,2);
  //$ano=substr($ocorrencia,5,2);
  $ocorrencia= (substr($ocorrencia,5,2).substr($ocorrencia,0,2));
  
  ////////////////////////////////////variaveis antigas //////////////////////////////////////////////////
  $novadata=dateFormat($data);  // $novadata é a data vinda do formulario, com formato igual ao da tabela para salvamento
  $valor_casa=$valor;           // igualo o valor da variavel $valor_casa a variavel $valor 
  $dia_vencimento=$vencimento;   // atribuo a $dia_vencimento a variavel $vencimento
  $pago= '2001-01-01';
  $valido='S';
  
}


///////////// SUBMETE A VARIAVEL ID_DESCRI��O VINDO DO FORMULARIO, A FUN��O VER_DATA PARA ESTABELECER QUAL SERA A NOVA DATA DO VENCIMENTO.
//$id_descricao=($_POST["id_descricao"]);   //  recebe a variavel id_descri��o do formulario

 $dia_venc=ver_data("$id_descricao");          // submete a variavel id_descri��o para a funcao ver_data
                                              //para buscar a data de vencimento correspondente e coloca na variavel $dia_venc

                                            
// atribui a $ndia_venc o resultado submetido a função nova_data
// a qual vai buscar na tabela descrição a data do vencimento daquele tipo de descrição
// submetendo a variavel $dia_venc e $vencimento para a funcao nova_data
// para buscar o dia inicial da despesa, j� modificado, dependendo do tipo de
// despesa, ou da data espeficidada para  o vencimento.
// inicia a variavel transferindo para ela, o mes de onde vai iniciar o debito da despesa
// despesa, ou da data espeficidada para  o vencimento.


$cont=$mes_inicio;

 $ndia_venc=nova_data("$dia_venc","$vencimento");          

// Inicia a transação
$conn->begin_transaction();

/*
var_dump([
    'despesa' => $despesa,
    'data' => $novadata,
    'valor' => $valor,
    'ocorrencia' => $ocorrencia
]);
*/




////////////////////////////////////////////////////////////////////////novo //////////////////////////////////
// Verifica se já existe uma despesa com mesma descrição, data, valor e ocorrencia/////
$sql = "SELECT despesa.* FROM despesa WHERE despesa = ? AND data = ? AND valor_casa = ? AND ocorrencia = ? AND valido = ?";
$stmt = $conn->prepare($sql);

// 🚨 Se a preparação falhou, exibir erro
if (!$stmt) {
    die("Erro ao preparar o SELECT: " . $conn->error);
}

$stmt->bind_param("ssdss", $despesa, $novadata, $valor, $ocorrencia, $valido);
$stmt->execute();
$stmt->store_result();


if ($stmt->num_rows > 0) {
    echo "<script>
  if (confirm('Atenção! Existe um Registro com essa mesma Despesa/Data/Valor/Ocorrência! Deseja continuar mesmo assim?')) {
    // OK - continua o processamento
    window.location.href = 'continuar_insercao.php'; // ou qualquer lógica de continuação
  } else {
    // Cancelar - volta ou cancela
    window.location.href = 'formulario.php'; // ou volta para o formulário
  }
</script>";

//echo "<script>alert('Atenção!\n\nExiste um Registro com essa mesma Despesa/Data/Valor/Ocorrência!');</script>";


} else {    //3005
            //////////////////// inicio do cabeçalho ////////////////////////////////
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
            //////////////////// termino do cabeçalho ////////////////////////////////

      for($i=1;$i<$parcela+1;$i++)
      {
          if ($mes_inicio>=13) {$mes_inicio=1; $ano_inicio++; $cont=1;}  
          // testa e muda se o mes é maior que 12. Caso afirmativo ele soma +1 ao ano e reinicia o mes com 1

       print "<tr><td>".$despesa;
       print "</td><td>".$data;
       print "</td><td>".$valor;
       // print "</td><td>".$valor_casa;

       $n_parcela=(sprintf("%02d", $i)."/".sprintf("%02d", $parcela));     
       // atribui e formata a $n_parcela com o valor de $i concatenado ao "/" + numero da parcela com formato de duas casas
       print "</td><td>".$n_parcela;   // numero da parcela já formatada

       $datamod=dateformat2(($ndia_venc.(sprintf("%02d", $mes_inicio))."20".$ano_inicio)); 
       // data do vencimento tratado para o banco de dados com dia com 2 casas decimais/
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


////////////////////// INCLUIR AS DESPESAS - INICIO ////////////////////

    // Query SQL para inserção
    $sql = "INSERT INTO despesa (despesa, data, valor, valor_casa, ocorrencia, parcela, id_descricao, vencimento, pago, valido, obs, categoria) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmtA = $conn->prepare($sql);

    // 🚨 Se a preparação falhou, exibir erro
    if (!$stmtA) {
        die("Erro ao preparar o INSERT: " . $conn->error);
    }

    // Associar os parâmetros corretamente
    $stmtA->bind_param("ssddsssssssi", 
        $despesa,  
        $novadata, 
        $n_valor,  
        $valor_casa, 
        $n_ocorrencia, /////////
        $n_parcela,
        $id_descricao, 
        $datamod, //////////
        $pago, 
        $valido, 
        $texto, 
        $categoria
    );

    // Executar a query com os dados da despesa, caso seja bem sucedido, ela executa a nova query com a inclusão da imagem
    // na tabela tabela_imagem
        if ($stmtA->execute()) {
            // 2. Obter o último ID inserido (id_despesa) pega o id_despesa do campo autoincremental da tabela despesas
            $id_despesa = $conn->insert_id;
        // caso a query seja bem sucedida, ou seja gravada com sucesso,
        // comecar a incluir a imagem vinculada a despesa  
    $stmtA->close();
////////////////////// INCLUIR AS DESPESAS - FINAL ////////////////////

////////////////////// INCLUIR O ARQUIVO PDF - INICIO ////////////////////
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  //  $conn = new mysqli("localhost", "orcamento", "orcamento", "orcamento");
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    // Verifica se foi enviado um arquivo
    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
        $nome = $_FILES['pdf']['name'];
        $tipo = $_FILES['pdf']['type'];
        $tamanho = $_FILES['pdf']['size'];
        $conteudo = file_get_contents($_FILES['pdf']['tmp_name']);

        // Prepare e execute a query
        $stmtB = $conn->prepare("INSERT INTO tabela_imagens (id_despesa_imagem,nome_imagem, tipo_imagem, tamanho_imagem, imagem) VALUES (?, ?, ?, ?, ?)");
        $null = NULL;
        $stmtB->bind_param("sssib", $id_despesa, $nome, $tipo, $tamanho, $null);
        $stmtB->send_long_data(4, $conteudo);  // o índice 4 corresponde ao 5º parâmetro (imagem)


        if ($stmtB->execute()) {
            echo "PDF enviado com sucesso!";
            $conn->commit(); // commit na transação se tudo foi OK

        } else {
            echo "Erro ao inserir: " . $stmtB->error;
        }

        $stmtB->close();
    } else {
       // echo "Erro ao enviar o arquivo."; 
          echo "Despesa sem arquivo.";
    }

    //$conn->close();

    $cont++;
    $mes_inicio++;
}
////////////////////// INCLUIR O ARQUIVO PDF - FINAL ////////////////////   

    } else {

        // Desfaz tudo se houver erro
        $conn->rollback();
        echo "Erro ao inserir: " . $stmtB->error;
    }
}

///////////////////////////////////////////////////////////// end //////////////////////////////////////
   

  } //3005

// Fechar conexão
//$stmtA->close();
$conn->close();


print ("</tbody></table>botao");
//mysqli_close($mysqli_connection);
?>


  <!-- Scripts agrupados -->
  <?php include("includes/scripts.php"); ?>
</BODY>
</HTML>
