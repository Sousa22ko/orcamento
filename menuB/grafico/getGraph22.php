<?php
$data = json_decode(($_POST["passaarray"]), true);  // traz o array de dados vindo do formulario anterior
$compara=0;                                 // inicia a variavel compara para saber qual � o maior valor para uso no eixo X
$mes_inicio=($_POST["mes_inicio"]);
$ano_inicio=($_POST["ano_inicio"]);
$formato=($_POST["formato"]);      // traz do formulario anterior, qual tipo de grafico ser� montado

function clean($value) {
         return floatval(str_replace(',', '', $value));     // retira a virgula do campo de valor
}




foreach($data as &$row) {
         $row[1] = clean($row[1]) ;

         if ($row[1]>=$compara)    // verifica qual � o maior valor da despesa para configurar o eixo do X
         { $compara = $row[1];}
}


// requisi��o da classe PHPlot   
require_once 'C:/wamp64/www/menubootstrap/phplot-6.2.0/phplot.php';
# Cria um novo objeto do tipo PHPlot com 500px de largura x 350px de altura
$plot = new PHPlot(1100 , 500);
$texto='Orcamento do mes de '.$mes_inicio.' de 20'.$ano_inicio;
// Organiza Gr�fico -----------------------------
$plot->SetTitle($texto);
# Precis�o de uma casa decimal
$plot->SetPrecisionY(2);
# tipo de Gr�fico em barras (poderia ser linepoints por exemplo)  area, bars, boxes, candlesticks2, linepoints, lines,ohlc,pie, points,squared

if($formato == "bars"){
  $plot->SetPlotType("bars");
  # Tipo de dados que preencher�o o Gr�fico text(label dos anos) e data (valores de porcentagem)
  $plot->SetDataType("text-data");
} else {
  $plot->SetPlotType("pie");
  $plot->SetDataType("text-data-single");
}


$plot->SetImageBorderType('plain'); // Improves presentation in the manual

# Adiciona ao gr�fico os valores do array
$plot->SetDataValues($data);
// -----------------------------------------------

// Organiza eixo X ------------------------------
# Seta os tra�os (grid) do eixo X para invis�vel
$plot->SetXTickPos('none');
# Texto abaixo do eixo X
$plot->SetXLabel("");
# Tamanho da fonte que varia de 1-5
$plot->SetXLabelFontSize(2);
$plot->SetAxisFontSize(2);
$labels = array_column($data, 0);
///$plot->SetPieLabelType('label');  ///// $plot->SetPieLabelType('value'); para valores no grafico
//$plot->SetPieLabels($labels);
//
// -----------------------------------------------


function mycallback($str)
{
    list($percent, $label) = explode(' ', $str, 2);
    //return sprintf('%s (%.1f%%)', $label, $percent);
    return sprintf('%s (%01.2f)', $label, $percent);
}

//sprintf("%01.2f", $fecho)



$plot->SetPieLabelType(array('value', 'label'), 'custom', 'mycallback');

$vmax=$compara+300; // valor maximo do grafico

// Organiza eixo Y -------------------------------
# Coloca nos pontos os valores de Y
$plot->SetYDataLabelPos('plotin');

//seta o tamanho do grafico no eixo x e y
//xmin, ymin, xmax, ymax
$plot->SetPlotAreaWorld(NULL, 0, NULL, $vmax) ;
// -----------------------------------------------

// Desenha o Gr�fico -----------------------------
$plot->DrawGraph();
// -----------------------------------------------




/*

# PHPlot Example: Pie Chart Label Types - Multi-part labels
# This requires PHPlot >= 5.6.0
//require_once 'phplot.php';
//require_once 'pielabeltypedata.php'; // Defines $data and $title

function mycallback($str)
{
    list($percent, $label) = explode(' ', $str, 2);
    return sprintf('%s (%.1f%%)', $label, $percent);
}

$plot = new PHPlot(800, 600);
$plot->SetImageBorderType('plain'); // Improves presentation in the manual
$plot->SetPlotType('pie');
$plot->SetDataType('text-data-single');
$plot->SetDataValues($data);
$plot->SetTitle($title);
# Set label type: combine 2 fields and pass to custom formatting function
$plot->SetPieLabelType(array('percent', 'label'), 'custom', 'mycallback');
$plot->DrawGraph();

*/







?>
