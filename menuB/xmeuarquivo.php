<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Consulta de Despesas</title>

    <!-- Bootstrap 3 -->
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>

    <!-- Estilo próprio -->
    <link rel="stylesheet" href="./styles.css">

    <style>
        body {
            overflow-y: auto;
        }
        .small-font {
            font-size: 12px;
        }
        .bg-cinza {
            background-color: #f0f0f0;
        }
        .bg-cabecalho {
            background-color: #5bc0de;
            color: white;
        }
        .linha-dados {
            border-bottom: 1px solid #ccc;
        }
    </style>
</head>
<body>
<div class="container" style="margin-top: 20px;">


<?
require_once ("config.php");
require_once ("functions.inc");

// Recebe a data enviada
if (isset($_POST['mesAno'])) {
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
            ORDER BY  despesa.categoria , despesa.valor DESC";  

    $stmtA = $conn->prepare($query);

    if (!$stmtA) {
        die("Erro ao preparar a query: " . $conn->error);
    }
    
    $stmtA->bind_param("s", $mesAno);
    
    
         if ($stmtA->execute()) {
            $result = $stmtA->get_result();

            if ($result->num_rows > 0) {
                $resposta .= "
                <div class='row bg-cabecalho text-center'>
                    <div class='col-xs-2'>Despesa</div>
                    <div class='col-xs-1'>Valor</div>
                    <div class='col-xs-1'>Ocorrência</div>
                    <div class='col-xs-1'>Data</div>
                    <div class='col-xs-1'>Parc</div>
                    <div class='col-xs-2'>Descrição</div>
                    <div class='col-xs-2'>Categoria</div>
                    <div class='col-xs-1'>Venc</div>
                    <div class='col-xs-1'>Pago</div>
                </div>";

                $despesas = $result->fetch_all(MYSQLI_ASSOC);

                foreach ($despesas as $row) {
                    $resposta .= "
                    <div class='row linha-dados bg-cinza'>
                        <div class='col-xs-2 small-font'>" . htmlspecialchars($row['despesa']) . "</div>
                        <div class='col-xs-1 small-font text-right'>" . htmlspecialchars($row['valor']) . "</div>
                        <div class='col-xs-1 small-font text-right'>" . htmlspecialchars($row['ocorrencia']) . "</div>
                        <div class='col-xs-1 small-font text-right'>" . htmlspecialchars(date("d/m/Y", strtotime($row['data']))) . "</div>
                        <div class='col-xs-1 small-font text-center'>" . htmlspecialchars($row['parcela']) . "</div>
                        <div class='col-xs-2 small-font text-center'>" . htmlspecialchars($row['descricao_abreviada']) . "</div>
                        <div class='col-xs-2 small-font text-center'>" . htmlspecialchars($row['nome_categoria']) . "</div>
                        <div class='col-xs-1 small-font text-right'>" . htmlspecialchars(date("d/m/Y", strtotime($row['vencimento']))) . "</div>
                        <div class='col-xs-1 small-font text-right'>" . htmlspecialchars(date("d/m/Y", strtotime($row['pago']))) . "</div>
                    </div>";
                }
            } else {
                $resposta = "<p class='alert alert-info'>Nenhum resultado encontrado.</p>";
            }
        }

   echo "$resposta
   </div>
   ";
} else {
    echo "Nenhuma data foi enviada.";
}       
 $stmtA->close();
 $conn->close();
?>
