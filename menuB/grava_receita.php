<?
require("orcamento.inc");
require("functions.inc");
$mes_inicio=($_POST["mes_inicio"]);
$ano_inicio=($_POST["ano_inicio"]);
$receita=($_POST["receita"]);

// verifica se já existe alguma receita na ocorrencia solicitada
$busca=$ano_inicio.$mes_inicio;

// estabelece a primeira query ///////////
$query="SELECT $dbname.receita.*
        FROM   $dbname.receita
        WHERE  $dbname.receita.ocorrencia = '$busca'";

// Executa a primeira query sql
$result = mysqli_query($mysqli_connection, $query);

//print $query;


if (mysqli_num_rows($result))
{  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))      // executa enquanto houver resultados
    {
    mensagem (("ATENÇÃO!! ".traduz_mes($mes_inicio)." de 20".$ano_inicio ."
             já possui receita cadastrada de R$ : ").$row["receita"]);
    }
}

else

{
$receita_sem_cpmf=($receita-(($receita*0.38)/100));
$ocorrencia=(sprintf("%02d", $ano_inicio).sprintf("%02d", $mes_inicio));
$query = "INSERT INTO receita (receita,ocorrencia,receita_sem_cpmf) values ";
$query = $query . "('$receita','$ocorrencia','$receita_sem_cpmf')";

     // executa a sql para a inclusão, usando a variavel $link localizado em fotografia.php
     

     
   if (!mysqli_query($mysqli_connection, $query) )
       {mensagem("Não foi possível realizar a inclusão");
       }
   else
       {mensagem("A Inclusão foi realizada com sucesso!!!");
       }
}
?>
