<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Formulário com Datepicker Automático</title>
  
  <!-- Bootstrap CSS -->
  
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>

  <!-- Datepicker CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

</head>
<body>

<div class="container mt-5">
  <h2>Escolha o Mês e Ano</h2>
  <form method="post" action="" class="form-inline" id="meuFormulario">
  <!--<form id="meuFormulario" action="xmeuarquivo.php" method="POST">-->

  <div class="form-group">
  <label for="exemplo4" style="font-size: 38px;">Selecionar Mês e Ano:</label>
        <div class="input-group date col-sm-6">
        <input type="text" class="form-control" id="datepicker" name="mesAno" autocomplete="off" required>
            <div class="input-group-addon">
                <span class="glyphicon glyphicon-th col-sm-2"></span>
            </div>
        </div>
    </div>
    <!-- Não tem botão -->
  </form>
</div>








<?php
require_once ("config.php");
require_once ("functions.inc");

// $cor = "#f9f5e6";
// $a = 0;

 $contador = 0;
 $tot = 0;
 $subtot = 0;

$temp = 'Alimentação';

// $subtotal = 0;
// $subtotal_casa = 0;
// $subtotal_casa1 = 0;
// $subtotal_casa2 = 0;
// $total = 0;
// $somatorio = 0;
// $aindanaopago = 0;
// $naopago = 0;
// $rec = 0;
// $despesas_cartao["1"] = 0;
// $despesas_cartao["3"] = 0;
$compara = 1;

 $Array =array();
 $subtotais = array();
 $subtotalNome = array();
 $total = 0;


// Recebe a data enviada
if ($_SERVER["REQUEST_METHOD"] == "POST") {
?>
  <!-- jQuery e Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  
 <!-- Bootstrap CSS -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  
  <!-- Datepicker JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  
  <!-- Datepicker em português -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.pt-BR.min.js"></script>  

      <!-- Seu CSS (opcional) ok -->
      <link rel="stylesheet" href="./styles.css">

<style>
    body {
        overflow-y: auto;
    }


    .small-font {
        font-size: 12px;
    }
  
    </style>

  
  <div class="container" style="margin-top: 20px;">

<?php
    $mesAno = $_POST['mesAno'];
    $mesAno= (substr($mesAno,5,2).substr($mesAno,0,2));
    $resposta = "";
    $conn = conectar();

    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

    $query = "SELECT despesa.*,
                     descricao.*,
                     categoria.*
             FROM    despesa
            INNER JOIN descricao ON despesa.id_descricao = descricao.id_descricao
            INNER JOIN categoria ON despesa.categoria = categoria.categoria
            WHERE despesa.ocorrencia = ?
            AND despesa.valido='S'
            ORDER BY despesa.categoria , despesa.valor DESC";  

    $stmtA = $conn->prepare($query);

    if (!$stmtA) {
        die("Erro ao preparar a query: " . $conn->error);
      }
    
    $stmtA->bind_param("s", $mesAno);
    
    
         if ($stmtA->execute()) {

          $result = $stmtA->get_result();

          ////    SE DER CERTO  //////////////////////////////// INICIO
         /*   $result = $stmtA->get_result();

            if ($result->num_rows > 0) {
                $resposta .= "
                <div class='row bg-cabecalho text-center'>
                    <div class='col-xs-3'>Despesa</div>
                    <div class='col-xs-1'>Valor</div>
                    <div class='col-xs-1'>Ocorrência</div>
                    <div class='col-xs-1'>Data</div>
                    <div class='col-xs-1'>Parc</div>
                    <div class='col-xs-2'>Descrição</div>
                    <div class='col-xs-2'>Categoria</div>
                    <!--<div class='col-xs-1'>Venc</div>-->
                    <div class='col-xs-1'>Pago</div>
                </div>";


                $arraySelect = [];
                $arrayCategoria = [];

                $despesas = $result->fetch_all(MYSQLI_ASSOC);
                
                foreach ($despesas as $despesa) {
                    $resposta .= "
                    <div class='row linha-dados bg-cinza'>
                        <div class='col-xs-3 small-font'>" . htmlspecialchars($despesa['despesa']) . "</div>
                        <div class='col-xs-1 small-font text-right'>" . htmlspecialchars($despesa['valor']) . "</div>
                        <div class='col-xs-1 small-font text-right'>" . htmlspecialchars($despesa['ocorrencia']) . "</div>
                        <div class='col-xs-1 small-font text-right'>" . htmlspecialchars(date("d/m/Y", strtotime($despesa['data']))) . "</div>
                        <div class='col-xs-1 small-font text-center'>" . htmlspecialchars($despesa['parcela']) . "</div>
                        <div class='col-xs-2 small-font text-center'>" . htmlspecialchars($despesa['descricao_abreviada']) . "</div>
                        <div class='col-xs-2 small-font text-center'>" . htmlspecialchars($despesa['nome_categoria']) . "</div>
                        <!--<div class='col-xs-1 small-font text-right'>" . htmlspecialchars(date("d/m/Y", strtotime($despesa['vencimento']))) . "</div>-->
                        <div class='col-xs-1 small-font text-right'>" . htmlspecialchars(date("d/m/Y", strtotime($despesa['pago']))) . "</div>
                    </div>";
                }
            } 
         */   
            
          ////    SE DER CERTO  //////////////////////////////// FIM





            
           //////////////////////// INICIO TESTE 
             //   é do GRAFICO
    $resposta .= "


    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>

    <div class='container'>
       <div class='row' id='linha1'>
           <div class='col-sm-3 bg-dark text-light p-3 centro'>Despesas</div>
           <div class='col-sm-1 bg-dark text-light p-3 centro'>Data</div>
           <div class='col-sm-2 bg-dark text-light p-3 centro'>Valor</div>
           <div class='col-sm-1 bg-dark text-light p-3 centro'>Parc</div>
           <div class='col-sm-1 bg-dark text-light p-3 centro'>Venc</div>
           <div class='col-sm-2 bg-dark text-light p-3 centro'>Categ</div>
           <div class='col-sm-2 bg-dark text-light p-3 centro'>Pago</div>
       </div>
    </div>";


   $arraySelect = [];
   $arrayCategoria = [];
   $despesas = $result->fetch_all(MYSQLI_ASSOC);

   foreach ($despesas as $index => $despesa) {
       ////////////////////////////////////////////////
       if ($despesa["categoria"] != $compara)   // procede a virada de subtotais
       { 
        //imprime o subtotal da categoria 
           $resposta .= '<div class="col-sm-3 small-font">' . $temp . ' -> ' . number_format($subtot, 2, ',', '.') . '</div>';   
           
           // imprime a linha com descricao abreviada e subtotal da descricao
           // imprime uma linha de fechamento da descricao atual
           $compara = $despesa["categoria"];          // atribuo o valor da id_descricao atualizada para fins de compara��o posterior
          
           $subtot = number_format($subtot, 2);
           array_push($Array,array($temp,$subtot));

          // $resposta .= '<pre> var_dump($Array[array()]) </pre>';
          
           $subtot = 0;                                 // zero o subtotal da descri��o para voltar a acumular para a proxima
           $contador++;           
          
       }
       // passa sempre por aqui no caso de impressao normal quando os valores do $compara e da $row["id_descricao"] s�o iguiais
       $subtot = $subtot + $despesa['valor'];  // acrescenta o $row[valor] ao subtotal
       $tot = $tot + $despesa['valor'];
       //////////////////////////////////////////////////



       if ($contador % 2 == 0) {
           $resposta .= '<div class="container cl1">';
       } else {
           $resposta .= '<div class="container cl2">';
       }



       $resposta .= "
       <div class='row' id='linha1'>
           <div class='col-sm-3 small-font'>" . $despesa['despesa'] . "</div>
           <div class='col-sm-1 small-font'>" . date("d/m/Y", (strtotime($despesa["data"]))) . "</div>
           <div class='col-sm-2 small-font direita'>" . $despesa["valor"] . "</div>
           <div class='col-sm-1 small-font centro'>" . $despesa["parcela"] . "</div>
           <div class='col-sm-1 small-font'>" . date("d/m/Y", (strtotime($despesa["vencimento"]))) . "</div>
           <div class='col-sm-2 small-font'>" . $despesa["nome_categoria"] . "</div>
           <div class='col-sm-2 small-font'>" . date("d/m/Y", (strtotime($despesa["pago"]))) . "</div>
       </div>
   </div>
       ";


       // $result = obtem_dados_aux("descricao", "descricao_abreviada", "asc");


       // $linhas = mysqli_num_rows($result);
       // for ($i = 0; $i < $linhas; $i++) {
       //     $array[$i] = mysqli_fetch_array($result);
       // }

       // $result2 = '';
       // $result2 .= "<select class='select' size=1 name=id_descricao>";

       // for ($i = 0; $i < $linhas; $i++) {
       //     if ($array[$i][0] == $despesa["id_descricao"])
       //         $result2 .= "<option Value=" . $array[$i][0] . " selected>" . $array[$i][2] . "</option>";
       //     else
       //         $result2 .= "<option Value=" . $array[$i][0] . ">" . $array[$i][2] . "</option>";
       // }
       // $result2 .= "</select>";

       // $result3 = '';
       // $result = obtem_dados_aux("categoria", "nome_categoria", "asc");
       // $linhas = mysqli_num_rows($result);
       // for ($i = 0; $i < $linhas; $i++) {
       //     $array[$i] = mysqli_fetch_array($result);
       // }
       // $result3 .= "<select class='select' size=1 name=categoria>";

       // for ($i = 0; $i < $linhas; $i++) {
       //     if ($array[$i][0] == $despesa["categoria"])
       //         $result3 .= "<option Value=" . $array[$i][0] . " selected>" . $array[$i][1] . "</option>";
       //     else
       //         $result3 .= "<option Value=" . $array[$i][0] . ">" . $array[$i][1] . "</option>";
       // }
       // $result3 .= "</select>'";

       // array_push($arraySelect, $result2);
     // array_push($arrayCategoria, $result3);


       // Se o id_descricao ainda não existir no array de subtotais, inicialize com zero
       if (!isset($subtotais[$despesa['id_descricao']])) {
           $subtotais[$despesa['id_descricao']] = 0;
       }



       //$subtotal = number_format($subtot, 2);
       //$subtotal = sprintf("%.2f", $subtotal);
       //$subtotal = number_format($subtot, 2);
      // array_push($Array,array($temp,$subtot));

       // Adicionar o valor ao subtotal correspondente ao despesa['id_descricao']
       // $subtotais[$despesa['id_descricao']] += $despesa['valor'];
       // $subtotalNome[$despesa['id_descricao']] = $despesa['descricao_abreviada'];
       // $total += $despesa['valor'];


       $temp = $despesa['nome_categoria'];   // captura a descri��o abreviada para utilizar no subtotal    

   }


   $subtot = number_format($subtot, 2);
   $subtot = sprintf("%.2f", $subtot);
   array_push($Array,array($temp,$subtot));




   //imprime o subtotal da categoria    
   $resposta .= '<div class=row><div class="col-sm-3 small-font"> ' . $temp . ' -> ' . number_format($subtot, 2, ',', '.') . '</div></div>';
   $resposta .= '<div class=row><div class=col-sm-3 small-font>  Total -> ' . number_format($tot, 2, ',', '.') . '</div></div>';
   $resposta .= '</div>';


   array_push($subtotais, $total);

   
  echo $resposta; 
   
  // $json_convert=json_encode($Array);   // converte o array para ser levado para a pagina seguinte

/*
   //2407          C:/wamp64/www/menubootstrap/grafico/getGraph22.php
   $resposta .= "<FORM action=http://localhost/menubootstrap/grafico/getGraph22.php id=formulario method=post>";
   $resposta .= "<input type='hidden' name='passaarray' value='" . htmlspecialchars($json_convert, ENT_QUOTES, 'UTF-8') . "'>";
   $resposta .= "<input type='hidden' name='mes_inicio' value='" . traduz_mes(substr($mesAno, 2, 2)). "'>";
   $resposta .= "<input type='hidden' name='ano_inicio' value='". substr($mesAno, 0, 2). "'>";
            
   $resposta .= "<STRONG>Formato Grafico: </STRONG>";
   $resposta .= "<select name='formato'>";
   $resposta .= "<option value='pie'>Pizza</option>";
   $resposta .= "<option value='bars'>Barra</option>";
   $resposta .= "</select>";
            
   
   $resposta .= "<P align=center>";
   $resposta .= "<INPUT type=submit value='Enviar' name=Enviar>";
   $resposta .= "<INPUT type=reset value='Cancelar' name=Cancelar>";
   $resposta .= "</FONT></P>";
   $resposta .= "</FORM>";
    /*echo json_encode(['tabela' => $resposta, 'select' => $arraySelect, 'categoria' => $arrayCategoria, 'subtotal' => $subtotais, 'nomeAbv' => $subtotalNome]);
 
 
  
  // echo json_encode(['tabela' => $resposta]);
 */ 
$stmtA->close();
 $conn->close();
}
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            //////////////////////////////////////////////////   FIM TESTE
            else {$resposta = "<p class='alert alert-info'>Nenhum resultado encontrado.</p>";}
}

   echo $resposta. "</div>";

      
       
 
?>

<!-- Scripts agrupados -->
<?php include("includes/scripts.php"); ?>

























</body>
</html>







