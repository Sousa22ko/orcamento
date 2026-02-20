
<?php
require_once 'phplot.php';

// Crie uma instância do PHPlot
$grafico = new PHPlot();

// Defina o formato do arquivo de saída (por exemplo, PNG)
$grafico->SetFileFormat("png");

// Indique o título do gráfico e os títulos dos eixos X e Y
$grafico->SetTitle("Gráfico de exemplo");
$grafico->SetXTitle("Eixo X");
$grafico->SetYTitle("Eixo Y");

// Defina os dados do gráfico (por exemplo, meses e valores)
$dados = array(
    array('Janeiro', 10),
    array('Fevereiro', 5),
    array('Março', 4),
    // ... adicione mais dados aqui
);

$grafico->SetDataValues($dados);

// Neste caso, usaremos o gráfico em barras
$grafico->SetPlotType("bars");

// Exiba o gráfico
$grafico->DrawGraph();
?>
