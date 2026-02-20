<?php

require_once ("config.php");
require_once ("functions.inc");

$compara=1;
$cor = "#93C2C4";
$cor1 = "bg-info";
$a = 0;
$contador = 0;
$tot = 0;
$subtot = 0;
$resta_pagar=0;
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
$temp = 'Itau Personalite';
$salario= 0;


$resposta = '';

$resposta = "
<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Bootstrap Modal com PHP e MySQL</title>
    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>
    <link href='https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap' rel='stylesheet'>
 

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



        /* Estilo do campo flutuante fixo */
        #campo-flutuante {
            position: fixed; /* Mantém fixo na tela */
            bottom: 450px;  /* Distância do fundo */
            right: 1235px;   /* Distância da direita */
            /* background-color: #007bff;  Azul chamativo */
            background-color:rgb(66, 38, 0);
            color: white;
            padding: 5px 20px;
            border-radius: 8px;
            font-size: 17px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000; /* Mantém sobre outros elementos */
        }

        
        .btn-bege {
        background-color: rgb(153, 91, 5); /* Bege claro */
        color: rgb(252, 251, 251); /* Branco para contraste */
        border-color: #e5cfa3;
        }

        .btn-bege:hover {
        background-color:rgb(230, 167, 42);
        color: rgba(88, 43, 5, 0.91); /* Preto para contraste */
        }


        .bg-beige {
            background-color: #f5deb3 /*  !important;*/
        }

        .bg-beigetwo {
            background-color:rgb(66, 38, 0)/*  !important;/* 
        }

        body {
             font-family: 'Dancing Script', cursive;
             }


    </style>
    
</head>
<body>
";


/////////////////////////////////////////// busca o valor da Receita de um determinado mes ////////////////////////////////
if (isset($_GET['mesAno'])) {
    $mesAno = $_GET['mesAno'];
    
    //Função que conecta ao banco, já definida em seu config.php
    $conn = conectar();
    
    // Verifica se houve erro na conexão
    if ($conn->connect_error) {  die("Erro na conexão: " . $conn->connect_error);  }
    
    // Preparando a query com placeholders para evitar SQL Injection  
    $query = "SELECT receita.*
              FROM receita
              WHERE receita.ocorrencia = ?
              "; 

    // Query SQL para SELECT
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Erro ao preparar a query: " . $conn->error);
    }

    // Bind do parâmetro s(string)
    $stmt->bind_param("s", $mesAno);

    // Executar a consulta
    if ($stmt->execute()) {
        
        // Usa get_result para obter os dados
        $result = $stmt->get_result();
        
        // se a $result tiver encontrado algum valor ele roda este IF
        if ($result->num_rows > 0) {
            $receita = $result->fetch_all(MYSQLI_ASSOC); //lista o array $despesas e coloca o nome do campo junto para listagem
            // abastece a variavel $salario com o valor do array receita da tabela
            $salario=$receita[0]['receita'];
            } 
    } 
    else {echo "Erro ao executar: " . $stmt->error;}
    $stmt->close();
} 

/////////////////////////////////////////// fim da pesquisa da receita////////////////////////////////////////////////


///////////////////////////////////// inicio da pesquisa das despesas de um determinada ocorrencia //////////////////////
if (isset($_GET['mesAno'])) {
    // Mocking data
    $mesAno = $_GET['mesAno'];

    // Preparando a query com placeholders para evitar SQL Injection  
    $query ="SELECT despesa.*,
                    descricao.*,
                    categoria.*
            FROM despesa
            JOIN descricao 
                ON despesa.id_descricao = descricao.id_descricao
            JOIN categoria 
                ON despesa.categoria = categoria.categoria
            WHERE despesa.ocorrencia = ?
            AND despesa.valido = 'S'
            ORDER BY 
                despesa.id_descricao,
                despesa.valor DESC,
                despesa.parcela ASC";


    // Query SQL para SELECT
    $stmtA = $conn->prepare($query);

    if (!$stmtA) {
        die("Erro ao preparar a query: " . $conn->error);
    }

    // Bind do parâmetro s(string)
    $stmtA->bind_param("s", $mesAno);

    // Executar a consulta
    if ($stmtA->execute()) {
        
        // Usa get_result para obter os dados
        $result = $stmtA->get_result();
        
        // se a $result tiver encontrado algum valor ele roda este IF
        if ($result->num_rows > 0) {
            $despesas = $result->fetch_all(MYSQLI_ASSOC); //lista o array $despesas e coloca o nome do campo junto para listagem  
        } 

    } else {
        echo "Erro ao executar: " . $stmtA->error;
    }

///////////////////////////////////// fim da pesquisa das despesas de um determinada ocorrencia /////
$stmtA->close();

$resposta .= " 
</body>
    <script>
    ////////////////////////////////////////////////////////script referente ao checkbox para somar ou diminuir os valores
        valorTotalCheckbox = 0
        document.querySelectorAll('.check').forEach(checkbox => {
            checkbox.addEventListener('change', (change) => {

            console.log(valorTotalCheckbox)
                let value = parseFloat(change.target.value);
                
                if (change.target.checked) {
                    valorTotalCheckbox += value;  // Soma se marcado
                } else {
                    valorTotalCheckbox -= value;  // Subtrai se desmarcado
                }

                document.getElementById('total').textContent = ' Total: R$ ' + valorTotalCheckbox.toFixed(2);
            });
        });
            ///////////////////////////////////////////////////////////////////////////
    </script>



    <div class='container'>
    <div class='row'>
        <div class='col-3 bg-beigetwo text-light p-3 centro'>Despesa</div>        
        <div class='col-1 bg-beigetwo text-light p-3 esquerda'>Valor</div>
        <div class='col-1 bg-beigetwo text-light p-3 esquerda'>Val.Total</div>
        <div class='col-1 bg-beigetwo text-light p-3 centro'>Data</div>
        <div class='col-1 bg-beigetwo text-light p-3 centro'>Parcela</div>
        <div class='col-2 bg-beigetwo text-light p-3 centro'>Categoria</div>
        <div class='col-1 bg-beigetwo text-light p-3 esquerda'>Vence</div>        
        <div class='col-1 bg-beigetwo text-light p-3 centro'>Pago</div>
        <div class='col-1 bg-beigetwo text-light p-3 centro'>Ação</div>
    </div>
    <div class='row'>


<div id='campo-flutuante'><span id='total'> Total: R$ 0.00</span></div>
    </div>
";



$arraySelect = [];
$arrayCategoria = [];
foreach ($despesas as $index => $despesa) {

// if ($despesa["pago"]==='2001-01-01')
//           {$resta_pagar=($resta_pagar+$despesa["valor"]);}  // acumula os subtotais das despesas que ainda não foram pagas.

        // exclui da soma do $resta_pagar os valores das despesas refentes 
        // a id_despesa == 33 e entre 36 e 37
        $id = (int)$despesa["id_descricao"];
        $ignorar = ($id == 33 OR ($id >= 36 AND $id <= 37));


        if ($despesa["pago"] === '2001-01-01' && !$ignorar)
             {$resta_pagar=($resta_pagar+$despesa["valor"]);}  // acumula os subtotais das despesas que ainda não foram pagas.


////////////////////////////////////////////////
if ($despesa["id_descricao"]!=$compara)   // procede a virada de subtotais
{ //imprime o subtotal da categoria     
$resposta .= '<div class="row bg-beigetwo"><div class="col p-3 centro text-light">'.$temp.'-> '.number_format($subtot, 2, ',', '.').'</div></div>';

    // imprime a linha com descricao abreviada e subtotal da descricao
                                                   // imprime uma linha de fechamento da descricao atual
      $compara=$despesa["id_descricao"];          // atribuo o valor da id_descricao atualizada para fins de compara��o posterior
      $subtot=0;                                 // zero o subtotal da descri��o para voltar a acumular para a proxima
      $contador++;                                               
}
                 // passa sempre por aqui no caso de impressao normal quando os valores do $compara e da $row["id_descricao"] s�o iguiais
                 $subtot=$subtot+$despesa['valor'];  // acrescenta o $row[valor] ao subtotal

                // exclui da soma do $subtot os valores das despesas refentes 
                // a id_despesa id_despesa == 33 e entre 36 e 37 
                $id = (int)$despesa["id_descricao"];
                $ignorar = ($id == 33 || ($id >= 36 && $id <= 37));
                if ($despesa["pago"] === '2001-01-01' && !$ignorar)
                    {// exclui da soma do total geral os valores da id_despesa entre 33 e 37
                        $tot=$tot+$despesa['valor']; 
                    }
   
                 
    ///////////////////////////////////////
    $result = obtem_dados_aux("descricao", "descricao_abreviada", "asc");
    $linhas = mysqli_num_rows($result);
    for ($i = 0; $i < $linhas; $i++) {
        $array[$i] = mysqli_fetch_array($result);
    } 
    ////////////////////////////////////////////////////
    $result2 = '';
    $result2 .= "<select class='select' size=1 name=id_descricao>";
    for ($i = 0; $i < $linhas; $i++) {
        if ($array[$i][0] == $despesa["id_descricao"])
            $result2 .= "<option Value=" . $array[$i][0] . " selected>" . $array[$i][2] . "</option>";
        else
            $result2 .= "<option Value=" . $array[$i][0] . ">" . $array[$i][2] . "</option>";
    }
    $result2 .= "</select>";



    ///////////////////////////////////////////////////
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
    $result3 .= "</select>";
    ////////////////////////////////////////////////////////


/*
$result = '';
$result = obtem_dados_aux("descricao", "descricao_abreviada", "asc");

if (!$result) {
    die("Erro na consulta: " . mysqli_error($conn)); // Use a conexão ativa aqui
    }
$result2 = '';
$result2 .= "<select class='form-control' aria-label='small select example' name='categoria'>";

while ($linha = mysqli_fetch_array($result)) {
    $selected = ($linha[0] == $despesa["categoria"]) ? "selected" : "";
    $result2 .= "<option value='{$linha[0]}' $selected>{$linha[2]}</option>";
    }
$result2 .= "</select>";




$result3 = '';
$result = obtem_dados_aux("categoria", "nome_categoria", "asc");
if (!$result) {
    die("Erro na consulta: " . mysqli_error($conn)); // Use a conexão ativa aqui
}
$result3 .= "<select class='form-control' aria-label='small select example' name='categoria'>";
while ($linha = mysqli_fetch_array($result)) {
    $selected = ($linha[0] == $despesa["categoria"]) ? "selected" : "";
    $result3 .= "<option value='{$linha[0]}' $selected>{$linha[1]}</option>";
}
$result3 .= "</select>";

*/


        $resposta .='<div class="row bg-beige"><div class="col-3 col ms-auto "><strong>' . ucwords($despesa["despesa"]) . '</strong></div>'; 
        $resposta .='<div class="bg-beige col-1 small-font col ms-auto"><input class="form-check-input check" type="checkbox" value="' .$despesa["valor"]. '" id="flexCheckDefault"><strong>' . $despesa["valor"] . '</strong></div>';
        $resposta .='<div class="col-1 small-font col ms-auto"><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"><strong>' . $despesa["valor_casa"] . '</strong></div>';
        $resposta .='<div class="bg-beige col-1 small-font esquerda"><strong>' . date("d/m/Y", (strtotime($despesa["data"]))). '</strong></div>';
        $resposta .='<div class="col-1 small-font centro"><strong>'. parcela_func($despesa["parcela"]). '</strong></div>'; // a funcao parcela_func trata e inf se a parcela é unica ou se trata de compra parcelada
        $resposta .='<div class="bg-beige col-2 small-font esquerda"><strong>' . $despesa['nome_categoria'] . '</strong></div>';
        $resposta .= '<div class="col-1 small-font"><strong>'.date("d/m/Y", (strtotime($despesa["vencimento"]))).'</strong></div>';
        $resposta .= '<div class="col-1 small-font direita"><strong>'.pago_func($despesa["pago"]).'</strong></div>';  // a funcao pago_func trata e informa se o valor foi pago ou ainda não foi pago  

       // botão de edição no final de cada linha
       $resposta .= '<div class="bg-bege col-1 small-font"><button class="btn btn-edit btn-bege" data-index=' . $index . ' data-id="' . $despesa["id_despesa"] . '">Editar</button></div>';

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

$resposta .= '<div class="row bg-beigetwo" style="min-width: 100%"><div class="col-3 centro text-light" style="min-width: 100%">'.$temp.'-> '.number_format($subtot, 2, ',', '.').'';
//imprime o subtotal da categoria    
$resposta .= '</div>';
$resposta .= "<div class='container' style='text-align: left; padding-top: 5px'>";
$resposta .= '<div class="row">
<div class="col-12 text-light">  
Total Geral -><strong> '.number_format($tot, 2, ',', '.').'</strong> 
 - Falta Pagar -><strong> '.number_format($resta_pagar, 2, ',', '.').'</strong>
</div></div>';


$resposta .= '<div class="row">
<div class="col-12 text-light">  
Salario Mes -><strong> '.number_format($salario, 2, ',', '.').'</strong> 
 - Saldo -><strong> '.number_format(($salario-$tot), 2, ',', '.').'</strong>
</div></div>';


$resposta .= '</div>';
$resposta .= "</div>";

array_push($subtotais, $total);

echo json_encode(['tabela' => $resposta, 'select' => $arraySelect, 'categoria' => $arrayCategoria, 'subtotal' => $subtotais, 'nomeAbv' => $subtotalNome]);

}




?>

