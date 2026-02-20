<?php
require ("orcamento.inc");
require ("functions.inc");


$compara=1;
$cor = "#93C2C4";
$cor1 = "#BFDAD7";
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

    $resposta .= '<table class= "table table-borderless">';
    $resposta .= '<thead>';
    $resposta .= '<tr>
    
    <th>Despesa</th>
    <th>Valor</th>
    <th>Data</th>
    <th>Parc</th>
    <th>Descr</th>
    <th>Cat.</th>
    <th>Venc</th>   
    <th>Pago</th>
    <th>Ação</th>
    </tr>';

    $resposta .= '</thead>';
    $resposta .= '<tbody>';

    $arraySelect = [];
    $arrayCategoria = [];
    foreach ($despesas as $index => $despesa) {
    
////////////////////////////////////////////////
if ($despesa["id_descricao"]!=$compara)   // procede a virada de subtotais
{ //imprime o subtotal da categoria    
    $resposta .= '<td>'.$temp.'-> '.number_format($subtot, 2, ',', '.').'</td>';
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

      

        if($contador % 2 == 0) {
            $resposta .= '<tr style="background-color:'.$cor.'">';
        } else {
            $resposta .= '<tr style="background-color:'.$cor1.'">';
        }
        
        $resposta .= '<td>' . $despesa["despesa"] . '</td>';    
        $resposta .= '<td><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">' . $despesa["valor"] . '</td>';
        $resposta .= '<td>' . date("d/m/Y", (strtotime($despesa["data"]))) . '</td>';
        $resposta .= '<td>'. parcela_func($despesa["parcela"]). '</td>'; // a funcao parcela_func trata e inf se a parcela é unica ou se trata de compra parcelada
        $resposta .= '<td>' . $despesa['nome_categoria'] . '</td>';
       
        $result = obtem_dados_aux("descricao", "descricao_abreviada", "asc");
        $linhas = mysqli_num_rows($result);
        for ($i = 0; $i < $linhas; $i++) {
            $array[$i] = mysqli_fetch_array($result);
        }
        // print ('<td>');
        
        
        $result2 = '';
        $result2 .= "<select class='select' size=1 name=id_descricao>";

        for ($i = 0; $i < $linhas; $i++) {
            if ($array[$i][0] == $despesa["id_descricao"])
                $result2 .= "<option Value=" . $array[$i][0] . " selected>" . $array[$i][2] . "</option>";
            else
                $result2 .= "<option Value=" . $array[$i][0] . ">" . $array[$i][2] . "</option>";
        }
        $result2 .= "</select>";

        $resposta .= '<td>' . $despesa['descricao_abreviada'] . '</td>';


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

        $resposta .= '<td>'.date("d/m/Y", (strtotime($despesa["vencimento"]))).'</td>';

        $resposta .= '<td>'.pago_func($despesa["pago"]).'</td>';  // a funcao pago_func trata e informa se o valor foi pago ou ainda não foi pago
         
        //$resposta .= '<td>' . $despesa["obs"] . '</td>';
        $resposta .= '<td><button class="btn btn-primary btn-sm btn-edit" data-index=' . $index . ' data-id="' . $despesa["id_despesa"] . '">Editar</button></td>';
        $resposta .= '</tr>';

        array_push($arraySelect, $result2);
        array_push($arrayCategoria, $result3);


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
    $resposta .= '<td>'.$temp.'-> '.number_format($subtot, 2, ',', '.').'</td></tr>';
    $resposta .= '<tr><td>  Total -> '.number_format($tot, 2, ',', '.').'</td></tr>';


    array_push($subtotais, $total);

    $resposta .= '</tbody>';
    $resposta .= '</table>';

    echo json_encode(['tabela' => $resposta, 'select' => $arraySelect, 'categoria' => $arrayCategoria, 'subtotal' => $subtotais, 'nomeAbv' => $subtotalNome]);

}

?>
