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
    <h4>Pesquisa</h4>
    <form method="post" action="" class="form-inline">
        <div class="form-group">
            <label for="pesq">Texto pesquisado:</label>
            <input type="text" id="pesq" name="pesq" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Consultar</button>
    </form>

    <br>

    <?php
    require_once("config.php");
    require_once("functions.inc");

    $resposta = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_d = $_POST['pesq'];
        $vald = 'S';
        $conn = conectar();

        if ($conn->connect_error) {
            die("Erro na conexão: " . $conn->connect_error);
        }

        $query = "SELECT despesa.*, descricao.*, categoria.*
                  FROM despesa
                  INNER JOIN descricao ON despesa.id_descricao = descricao.id_descricao
                  INNER JOIN categoria ON despesa.categoria = categoria.categoria
                  WHERE (despesa.despesa LIKE ? OR despesa.valor LIKE ?) 
                  AND despesa.valido = ?
                  ORDER BY despesa.data DESC, despesa.despesa, despesa.parcela ASC";

        $stmtA = $conn->prepare($query);

        if (!$stmtA) {
            die("Erro ao preparar a query: " . $conn->error);
        }

        $id_d_param = '%' . $id_d . '%';
        $stmtA->bind_param("sss", $id_d_param, $id_d_param, $vald);

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

                foreach ($despesas as $despesa){
                    $resposta .= "
                    <div class='row linha-dados bg-cinza'>
                        <div class='col-xs-2 small-font'>" . htmlspecialchars($despesa['despesa']) . "</div>
                        <div class='col-xs-1 small-font text-right'>" . htmlspecialchars($despesa['valor']) . "</div>
                        <div class='col-xs-1 small-font text-right'>" . htmlspecialchars($despesa['ocorrencia']) . "</div>
                        <div class='col-xs-1 small-font text-right'>" . htmlspecialchars(date("d/m/Y", strtotime($despesa['data']))) . "</div>
                        <div class='col-xs-1 small-font text-center'>" . htmlspecialchars($despesa['parcela']) . "</div>
                        <div class='col-xs-2 small-font text-center'>" . htmlspecialchars($despesa['descricao_abreviada']) . "</div>
                        <div class='col-xs-2 small-font text-center'>" . htmlspecialchars($despesa['nome_categoria']) . "</div>
                        <div class='col-xs-1 small-font text-right'>" . htmlspecialchars(date("d/m/Y", strtotime($despesa['vencimento']))) . "</div>
                        <div class='col-xs-1 small-font text-right'>" . htmlspecialchars(date("d/m/Y", strtotime($despesa['pago']))) . "</div>
                    </div>";
                }
            } else {
                $resposta = "<p class='alert alert-info'>Nenhum resultado encontrado.</p>";
            }
        } else {
            $resposta = "<p class='alert alert-danger'>Erro ao executar a consulta: " . $stmtA->error . "</p>";
        }

        $stmtA->close();
        $conn->close();
    }

    echo $resposta;
    ?>
</div>
</body>
</html>
