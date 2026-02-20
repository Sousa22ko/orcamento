<?php

/* #INFO############################################
Author: Igor Feghali
Email: ifeghali@interveritas.net
################################################# */

/* #FILE DESCRIPTION################################
Example for the bar graph
################################################# */

// #INCLUDE#########################################
// requisição da classe PHPlot
require_once 'C:/xampp/htdocs/orcamento/phplot-6.2.0/phplot.php';

//$ano=($_POST["ano_inicio"]);

  $ano=('24');
  $cor='#000000';


     $busca='20'.$ano;
//#################################

  // Conecta-se com o MySQL
  
     // Conecta-se com o MySQL
      $host="localhost";
      $user="orcamento";
      $senha="orcamento";
      $dbname="orcamento";

      $mysqli_connection = new MySQLi($host, $user, $senha, $dbname);
      
      
        $host="localhost";
        $user_aux = "orcamento";
        $password_aux = "orcamento";
        $dbname_aux = "orcamento";

        $link_aux = new MySQLi($host, $user, $senha, $dbname_aux);

      
      
      
      
      
      
      
      
      
      

//      mysql_select_db("orcamento");
     // estabelece a consulta  ///////////
     //WHERE orcamento.despesa_cartao.id_descricao='1'
     $consulta="SELECT orcamento.despesa_cartao.*
        FROM orcamento.despesa_cartao
        WHERE orcamento.despesa_cartao.ano=$busca
        order by orcamento.despesa_cartao.ocorrencia ASC";
        
//print $consulta."<br>";
//SE QUIZER PESQUISAR SOMENTE UM ANO, HABILITAR O WHERE ACIMA/

    // Executa a segunda query sql
    //$resultado = mysqli_query ($consulta, $link_aux) or die ("Não consegui consultar" . $consulta . mysql_error());
    $result = mysqli_query($link_aux, $consulta) or die ("Não consegui consultar" . $consulta . mysqlI_error());

// #################################################

// Array com dados de Ano x Índice de fecundidade Brasileira 1940-2000
// Valores por década

 // Valores por década

/*

$data = array (
  array("Volvo",22),
  array("BMW",15),
  array("Saab",5),
  array("Land Rover",17)
);




for ($row = 0; $row < 4; $row++) {
  echo "<p><b>Row number $row</b></p>";
  echo "<ul>";
    for ($col = 0; $col < 3; $col++) {
      echo "<li>".$cars[$row][$col]."</li>";
    }
  echo "</ul>";
}


*/

$data = array(
             array('1940' , 6.2 ),
             array('1950' , 6.2 ),
             array('1960' , 6.3 ),
             array('1970' , 5.8 ),
             array('1980' , 4.4 ),
             array('1991' , 2.9 ),
             array('2000' , 2.3 )
             );

/*


      echo "ano ". $data[0][0].": dados: ".$data[0][1].".<br>";
      echo "ano ". $data[1][0].": dados: ".$data[1][1].".<br>";
      echo "ano ". $data[2][0].": dados: ".$data[2][1].".<br>";
      echo "ano ". $data[3][0].": dados: ".$data[3][1].".<br>";
      echo "ano ". $data[4][0].": dados: ".$data[4][1].".<br>";
      echo "ano ". $data[5][0].": dados: ".$data[5][1].".<br>";
      echo "ano ". $data[6][0].": dados: ".$data[6][1].".<br>";



for ($row = 0; $row < 4; $row++) {
  echo "<p><b>Row number $row</b></p>";
  echo "<ul>";
    for ($col = 0; $col < 3; $col++) {
      echo "<li>".$cars[$row][$col]."</li>";
    }
  echo "</ul>";

 */
 
 
 while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
            {
            $data = array(array((substr($row["ocorrencia"],2,2).'/20'.substr($row["ocorrencia"],0,2) )  , $row["valor"] ));
      //     print ("%s (%s)\n", $row["ocorrencia", $row["valor"]);                parei aqui

        //
       //  echo "ano ". $data[0][0].": dados: ".$data[0][1].".<br>";
            }

// Array com índice numérico
//$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
//print ("%s (%s)\n", $row[0], $row[1]);





# Cria um novo objeto do tipo PHPlot com 500px de largura x 350px de altura
$plot = new PHPlot(500 , 400);

// Organiza Gráfico -----------------------------
$plot->SetTitle('Taxa de fecundidade no Brasil 1940-2000');

# Precisão de uma casa decimal
$plot->SetPrecisionY(1);
# tipo de Gráfico em barras (poderia ser linepoints por exemplo)  area, bars, boxes, candlesticks2, linepoints, lines,ohlc,pie, points,squared
$plot->SetPlotType("bars");
# Tipo de dados que preencherão o Gráfico text(label dos anos) e data (valores de porcentagem)
$plot->SetDataType("text-data");
# Adiciona ao gráfico os valores do array
$plot->SetDataValues($data);
// -----------------------------------------------

// Organiza eixo X ------------------------------
# Seta os traços (grid) do eixo X para invisível
$plot->SetXTickPos('none');
# Texto abaixo do eixo X
$plot->SetXLabel("Fonte: Censo Demográfico 2000, Fecundidade e Mortalidade Infantil, Resultados\n Preliminares da Amostra IBGE, 2002");
# Tamanho da fonte que varia de 1-5
$plot->SetXLabelFontSize(2);
$plot->SetAxisFontSize(2);
// -----------------------------------------------

// Organiza eixo Y -------------------------------
# Coloca nos pontos os valores de Y
$plot->SetYDataLabelPos('plotin');
// -----------------------------------------------

// Desenha o Gráfico -----------------------------
$plot->DrawGraph();
// -----------------------------------------------
/**/











?>
