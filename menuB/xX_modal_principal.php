<?php
require_once ("orcamento.inc");
require_once ("functions.inc");




$resposta = "
<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Bootstrap Modal com PHP e MySQL</title>
    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>
<style>
        /* Estilo para letras pequenas */
        .small-font {
            font-size: small;
            }
        /* Reduzindo espa�amento entre linhas e c�lulas da tabela */
        .custom-table {
            border-collapse: collapse;
            border-spacing: 0;
            }
        /* Estilo adicional para a borda e cor de fundo */
        .borda-custom-titulo {
           border: 1px solid #ccc; /* Cor e espessura da borda */
           padding: 1px; /* Espa�amento interno para destacar a borda */
           background-color: #f0f0f0; /* Cor de fundo da coluna */
           text-align: center;
          }

        /* Estilo adicional para a borda e cor de fundo */
        .borda-custom{
           border: 1px solid #ccc; /* Cor e espessura da borda */
           padding: 1px; /* Espa�amento interno para destacar a borda */
           background-color: #f0f0f0; /* Cor de fundo da coluna */
           text-align: right;
          }

         .direita {
          text-align: right;
          }

          .esquerda {
          text-align: left;
          background-color: #f0f0f0; /* Cor de fundo personalizada */
          }
          
         .centro {
          text-align: center;
          }

          .texto-vermelho {
           color: red;
           }
           .cl1 {
           background-color: #B0E0E6
           }
           .cl2 {
           background-color: #D3D3D3
           }

.minha-div {
    width: 300px; /* largura da div */
    height: 200px; /* altura da div */
    background-color: #B0E0E6; /* cor de fundo da div */
    padding: 20px; /* espaçamento interno */
    margin: 0 auto; /* centralizar horizontalmente */
    text-align: center; /* alinhar conteúdo ao centro */
    border: 1px solid #ccc; /* borda com cor cinza */
  }

.custom-background {
    background-color: #f0f0f0; /* Cor de fundo personalizada */
    /* Outros estilos, como padding, margin, etc. */
  }


    </style>
    
</head>
<body>
";






$compara=1;
$cor = "#93C2C4";
$cor1 = "bg-info";
$a = 0;

$contador = 0;
$tot = 0;
$subtot = 0;


$subtotal_casa = 0;
$subtotal_casa1 = 0;
$subtotal_casa2 = 0;

$somatorio = 0;
$aindanaopago = 0;
$naopago = 0;
$rec = 0;
$despesas_cartao["1"] = 0;
$despesas_cartao["3"] = 0;

$subtotais = array();
$subtotalNome = array();
$total = 0;

if (isset($_GET['mesAno'])) {
    // Mocking data
    $mesAno = $_GET['mesAno'];

    $query = "SELECT $dbname.despesa.*,$dbname_aux.descricao.*,$dbname_aux.categoria.*
        FROM $dbname.despesa,$dbname_aux.descricao,$dbname_aux.categoria
        WHERE $dbname.despesa.ocorrencia = '$mesAno'
        AND $dbname.despesa.id_descricao=$dbname_aux.descricao.id_descricao
        AND $dbname.despesa.categoria=$dbname_aux.categoria.categoria
        AND $dbname.despesa.valido='S'
        ORDER BY $dbname.despesa.id_descricao,$dbname.despesa.valor  DESC";

    $result = mysqli_query($mysqli_connection, $query);

    $despesas = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $resposta = '';



$resposta = "
    <div class='container'>
    <div class='row'>
        <div class='col-3 bg-dark text-light p-3 centro'>Despesa</div>        
        <div class='col-1 bg-dark text-light p-3 centro'>Valor</div>
        <div class='col-1 bg-dark text-light p-3 centro'>Data</div>
        <div class='col-1 bg-dark text-light p-3 centro'>Parc</div>
        <div class='col-2 bg-dark text-light p-3 centro'>Categ</div>
        <div class='col-1 bg-dark text-light p-3 centro'>Venc</div>        
        <div class='col-2 bg-dark text-light p-3 centro'>Pago</div>
        <div class='col-1 bg-dark text-light p-3 centro'>Acao</div>
    </div>

";



$arraySelect = [];
$arrayCategoria = [];
foreach ($despesas as $index => $despesa) {

////////////////////////////////////////////////
if ($despesa["id_descricao"]!=$compara)   // procede a virada de subtotais
{ //imprime o subtotal da categoria    
$resposta .= '<div class="row bg-dark"><div class="col p-3 centro text-light">'.$temp.'-> '.number_format($subtot, 2, ',', '.').'</div></div>';

    // imprime a linha com descricao abreviada e subtotal da descricao
                                                   // imprime uma linha de fechamento da descricao atual
      $compara=$despesa["id_descricao"];          // atribuo o valor da id_descricao atualizada para fins de compara��o posterior
      $subtot=0;                                 // zero o subtotal da descri��o para voltar a acumular para a proxima
      $contador++;                                               
}
                 // passa sempre por aqui no caso de impressao normal quando os valores do $compara e da $row["id_descricao"] s�o iguiais
                 $subtot=$subtot+$despesa['valor'];  // acrescenta o $row[valor] ao subtotal
                 $tot=$tot+$despesa['valor'];
//////////////////////////////////////////////////

// $resposta .='<div class="row"><div class="col-3 esquerda">' . $despesa["despesa"] . '</div>'; 
// $resposta .='<div class="col-1 small-font esquerda"><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">' . $despesa["valor"] . '</div>'; 
// $resposta .='<div class="col-1 small-font centro">' . date("d/m/Y", (strtotime($despesa["data"]))). '</div>';
// $resposta .='<div class="col-1 small-font centro">'. parcela_func($despesa["parcela"]). '</strong></div>'; // a funcao parcela_func trata e inf se a parcela é unica ou se trata de compra parcelada



    
   
    $result = obtem_dados_aux("descricao", "descricao_abreviada", "asc");
    $linhas = mysqli_num_rows($result);
    for ($i = 0; $i < $linhas; $i++) {
        $array[$i] = mysqli_fetch_array($result);
    }
    
    
    $result2 = '';
    $result2 .= "<select class='select' size=1 name=id_descricao>";

    for ($i = 0; $i < $linhas; $i++) {
        if ($array[$i][0] == $despesa["id_descricao"])
            $result2 .= "<option Value=" . $array[$i][0] . " selected>" . $array[$i][2] . "</option>";
        else
            $result2 .= "<option Value=" . $array[$i][0] . ">" . $array[$i][2] . "</option>";
    }
    $result2 .= "</select>";

  // $resposta .= '<div class="col-2 small-font">' . $despesa['descricao_abreviada'] . '</div>';

    $result3 = '';
    $result = obtem_dados_aux("categoria", "nome_categoria", "asc");
    $linhas = mysqli_num_rows($result);
    for ($i = 0; $i < $linhas; $i++) {
        $array[$i] = mysqli_fetch_array($result);
    }
    $result3 .= "<select class='select' size=1 name=categoria>";

    for ($i = 0; $i < $linhas; $i++) {
        if ($array[$i][0] == $despesa["categoria"])
            $result3 .= "<option Value=" . $array[$i][0] . " selected>" . $array[$i][1] . "</option>";
        else
            $result3 .= "<option Value=" . $array[$i][0] . ">" . $array[$i][1] . "</option>";
    }
    $result3 .= "</select>'";

    if($contador % 2 == 0) {
        $resposta .='<div class="row bg-light"><div class="col-3 col ms-auto">' . $despesa["despesa"] . '</div>'; 
        $resposta .='<div class="col-1 small-font col ms-auto"><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">' . $despesa["valor"] . '</div>'; 
        $resposta .='<div class="col-1 small-font esquerda">' . date("d/m/Y", (strtotime($despesa["data"]))). '</div>';
        $resposta .='<div class="col-1 small-font centro">'. parcela_func($despesa["parcela"]). '</strong></div>'; // a funcao parcela_func trata e inf se a parcela é unica ou se trata de compra parcelada
        $resposta .='<div class="col-2 small-font centro"></strong>' . $despesa['nome_categoria'] . '</div>';
        $resposta .= '<div class="col-1 small-font">'.date("d/m/Y", (strtotime($despesa["vencimento"]))).'</div>';
        $resposta .= '<div class="col-2 small-font direita">'.pago_func($despesa["pago"]).'</div>';  // a funcao pago_func trata e informa se o valor foi pago ou ainda não foi pago
    
    } else {
        $resposta .='<div class="row bg-light "><div class="col-3 esquerda">' . $despesa["despesa"] . '</div>'; 
        $resposta .='<div class="col-1 small-font esquerda"><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">' . $despesa["valor"] . '</div>'; 
        $resposta .='<div class="col-1 small-font centro">' . date("d/m/Y", (strtotime($despesa["data"]))). '</div>';
        $resposta .='<div class="col-1 small-font centro">'. parcela_func($despesa["parcela"]). '</strong></div>'; // a funcao parcela_func trata e inf se a parcela é unica ou se trata de compra parcelada
        $resposta .='<div class="col-2 small-font"></strong>' . $despesa['nome_categoria'] . '</div>';
        $resposta .= '<div class="col-1 small-font">'.date("d/m/Y", (strtotime($despesa["vencimento"]))).'</div>';
        $resposta .= '<div class="col-2 small-font direita">'.pago_func($despesa["pago"]).'</div>';  // a funcao pago_func trata e informa se o valor foi pago ou ainda não foi pago
  
    }
   
    //$resposta .= '<td>' . $despesa["obs"] . '</td>';
   $resposta .= '<div class="col-1 small-font"><button class="btn btn-info btn-edit border border-light" data-index=' . $index . ' data-id="' . $despesa["id_despesa"] . '">Editar</button></div>';
    //$resposta .= '</div>';            

    array_push($arraySelect, $result2);
    array_push($arrayCategoria, $result3);

   $resposta .= '</div>';
 

    // Se o id_descricao ainda não existir no array de subtotais, inicialize com zero
    if (!isset($subtotais[$despesa['id_descricao']])) {
        $subtotais[$despesa['id_descricao']] = 0;
    }

    // Adicionar o valor ao subtotal correspondente ao despesa['id_descricao']
    $subtotais[$despesa['id_descricao']] += $despesa['valor'];
    $subtotalNome[$despesa['id_descricao']] = $despesa['descricao_abreviada'];
    $total += $despesa['valor'];

$temp=$despesa['descricao_abreviada'];   // captura a descri��o abreviada para utilizar no subtotal

}

//imprime o subtotal da categoria    
$resposta .= '<div class="row bg-dark" id="linha1"><div class="col-3 text-light">'.$temp.'-> '.number_format($subtot, 2, ',', '.').'';
$resposta .= '<div class="row"><div class="col-8 text-light">  Total -><strong> '.number_format($tot, 2, ',', '.').'</strong></div></div>';
$resposta .= '</div></div>';

array_push($subtotais, $total);

echo json_encode(['tabela' => $resposta, 'select' => $arraySelect, 'categoria' => $arrayCategoria, 'subtotal' => $subtotais, 'nomeAbv' => $subtotalNome]);

}

?>
