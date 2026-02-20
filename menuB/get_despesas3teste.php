<?php
//$resposta = '';
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





    </style>
    
</head>
<body>
";





require ("orcamento.inc");
require ("functions.inc");

$cor = "#f9f5e6";
$a = 0;

$contador = 0;
$tot = 0;
$subtot = 0;

$temp = 'Alimentação';

$subtotal = 0;
$subtotal_casa = 0;
$subtotal_casa1 = 0;
$subtotal_casa2 = 0;
$total = 0;
$somatorio = 0;
$aindanaopago = 0;
$naopago = 0;
$rec = 0;
$despesas_cartao["1"] = 0;
$despesas_cartao["3"] = 0;
$compara = 1;

$Array =array();
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
        ORDER BY  $dbname.despesa.categoria , $dbname.despesa.valor DESC";    /*$dbname.despesa.id_descricao,*/      

    $result = mysqli_query($mysqli_connection, $query);
    $despesas = mysqli_fetch_all($result, MYSQLI_ASSOC);

    //   é do GRAFICO
    $resposta .= "
     <div class='container'>
        <div class='row' id='linha1'>
            <div class='col-3 bg-dark text-light p-3 centro'>Despesa</div>
            <div class='col-1 bg-dark text-light p-3 centro'>Data</div>
            <div class='col-2 bg-dark text-light p-3 centro'>Valor</div>
            <div class='col-1 bg-dark text-light p-3 centro'>Parc</div>
            <div class='col-1 bg-dark text-light p-3 centro'>Venc</div>
            <div class='col-2 bg-dark text-light p-3 centro'>Categ</div>
            <div class='col-2 bg-dark text-light p-3 centro'>Pago</div>
        </div>
     </div>";


    $arraySelect = [];
    $arrayCategoria = [];

    foreach ($despesas as $index => $despesa) {

        ////////////////////////////////////////////////
        if ($despesa["categoria"] != $compara)   // procede a virada de subtotais
        { //imprime o subtotal da categoria 
            $resposta .= '<div class="col-3 small-font">' . $temp . ' -> ' . number_format($subtot, 2, ',', '.') . '</div>';   
            
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
            <div class='col-3 small-font'>" . $despesa['despesa'] . "</div>
            <div class='col-1 small-font'>" . date("d/m/Y", (strtotime($despesa["data"]))) . "</div>
            <div class='col-2 small-font direita'>" . $despesa["valor"] . "</div>
            <div class='col-1 small-font centro'>" . $despesa["parcela"] . "</div>
            <div class='col-1 small-font'>" . date("d/m/Y", (strtotime($despesa["vencimento"]))) . "</div>
            <div class='col-2 small-font'>" . $despesa["nome_categoria"] . "</div>
            <div class='col-2 small-font'>" . date("d/m/Y", (strtotime($despesa["pago"]))) . "</div>
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
    $resposta .= '<div class=row><div class="col-3 small-font"> ' . $temp . ' -> ' . number_format($subtot, 2, ',', '.') . '</div></div>';
    $resposta .= '<div class=row><div class=col-3 small-font>  Total -> ' . number_format($tot, 2, ',', '.') . '</div></div>';
    $resposta .= '</div>';


    array_push($subtotais, $total);

    $json_convert=json_encode($Array);   // converte o array para ser levado para a pagina seguinte


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
    //echo json_encode(['tabela' => $resposta, 'select' => $arraySelect, 'categoria' => $arrayCategoria, 'subtotal' => $subtotais, 'nomeAbv' => $subtotalNome]);

    echo json_encode(['tabela' => $resposta]);
}

/**/


// echo json_encode(['tabela' => $resposta, 'select' => $arraySelect, 'categoria' => $arrayCategoria, 'subtotal' => $subtotais, 'nomeAbv' => $subtotalNome]);


?>