<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Despesas Agrupadas</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #e4fccb;
        }

        .balao {
            background: #d7e7b9;
            border: 1px solid #000;
            border-radius: 14px;
            padding: 14px;
            margin-bottom: 20px;
            box-shadow: 4px 4px 0 #000;
        }

        .balao-titulo {
            font-size: 18px;
            font-weight: bold;
            border-bottom: 1px solid #000;
            padding-bottom: 6px;
            margin-bottom: 10px;
        }

        .balao-linha {
            display: grid;
            grid-template-columns:
                300px 30px 110px 110px 110px 150px 140px 100px 80px;
            gap: 6px;
            padding: 6px 0;
            border-bottom: 1px dotted #999;
            align-items: center;
            text-align: center;
        }

        .balao-linha2 {
            display: grid;
            grid-template-columns:
                600px 600px 110px 110px 110px 70px 140px 100px 80px;
            gap: 6px;
            padding: 6px 0;
            border-bottom: 1px dotted #999;
            align-items: left;
            text-align: left;
        }

        .balao-linha3 {
            display: grid;
            grid-template-columns:
                300px 30px 110px 110px 110px 70px 140px 100px 80px;
            gap: 6px;
            padding: 6px 0;
            border-bottom: 1px dotted #999;
            align-items: center;
            text-align: left;
        }



        .balao-linha:last-child {
            border-bottom: none;
            align-items: right;
        }

        .despesa {
            text-align: left;
        }

        .valor {
            text-align: right;
        }

        .pago {
            color: green;
            font-weight: bold;
        }

        .nao-pago {
            color: red;
            font-weight: bold;
        }

        .diferenca-positiva {
            color: green;
            font-weight: bold;
        }

        .diferenca-negativa {
            color: red;
            font-weight: bold;
        }

        .balao-total {
            margin-top: 10px;
            padding-top: 8px;
            border-top: 1px solid #000;
            font-weight: bold;
            text-align: right;
        }

        .balao-total_Brasilia {
            margin-top: 10px;
            padding-top: 8px;
            border-top: 1px solid #000;
            font-weight: bold;
            text-align: left;
        }


        .btn-editar {
            padding: 4px 8px;
            border-radius: 6px;
            border: 1px solid #000;
            background: #ddd;
            cursor: pointer;
        }

        #totalMarcado {
            position: fixed;
            bottom: 450px;
            right: 1080px;
            background-color: #886161;
            color: white;
            padding: 6px 18px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, .2);
        }

        /* Estilo do campo flutuante fixo */
        #campo-flutuante {
            position: fixed;
            /* Mantém fixo na tela */
            bottom: 560px;
            /* Distância do fundo */
            right: 12px;
            /* Distância da direita */
            /* background-color: #007bff;  Azul chamativo */
            background-color: rgb(66, 38, 0);
            color: white;
            padding: 5px 20px;
            border-radius: 8px;
            font-size: 17px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            /* Mantém sobre outros elementos */
        }
    </style>

    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.pt-BR.min.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- JS (ordem IMPORTANTE) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



</head>

<body>

    <div id='campo-flutuante'>
        <span id='total'>Total: R$ 0,00</span>
    </div>



    <?php
    include '../api/dbConnection.php';
    require_once '../pages/generic.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);


    setlocale(LC_TIME, 'pt_BR.UTF-8');

    $mesAno = $_GET['mesAno'] ?? null;
    if (!$mesAno) {
        exit("Ocorrência não informada");
    }

    $conn = getDBConnection();

    /* =====================================================
       BUSCA RECEITA
    ===================================================== */
    $salario = 0;

    $sqlReceita = "SELECT receita FROM receita WHERE ocorrencia = ?";
    $stmt = $conn->prepare($sqlReceita);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $salario = $row['receita'];
    }
    $stmt->closeCursor();

    /* =====================================================
       BUSCA DESPESAS
    ===================================================== */
    $sql = "
SELECT 
    despesa.*,
    descricao.descricao_abreviada,
    categoria.nome_categoria
FROM despesa
JOIN descricao ON despesa.id_descricao = descricao.id_descricao
JOIN categoria ON despesa.categoria = categoria.categoria
WHERE despesa.ocorrencia = ?
  AND despesa.valido = 'S'
ORDER BY despesa.id_descricao ASC, despesa.valor DESC 
";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$mesAno]);
    $despesas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    /* =====================================================
       VARIÁVEIS DE CONTROLE
    ===================================================== */
    $descricaoAtual = null;
    $descricaoNome = '';
    $subtotalDescricao = 0;
    $resta_pagar = 0;
    $resta_pagar_Brasilia = 0;
    $totalGeral = 0;
    $totalBrasilia = 0;
    $totalVA = 0;
    $diferenca = 0;
    $ano = "20" . substr($mesAno, 0, 2);
    $mes = substr($mesAno, 2, 2);
    $data = mktime(0, 0, 0, $mes, 1);
    $meses = [
        "01" => "Janeiro",
        "02" => "Fevereiro",
        "03" => "Março",
        "04" => "Abril",
        "05" => "Maio",
        "06" => "Junho",
        "07" => "Julho",
        "08" => "Agosto",
        "09" => "Setembro",
        "10" => "Outubro",
        "11" => "Novembro",
        "12" => "Dezembro"
    ];

    $arraySelectDescricao = [];
    $arraySelectCategoria = [];

    // IDs que devem ser ignorados nos totais
    $idsIgnorados = [34, 35, 36, 37];
    // 33 despesa VA
// 34 aluguel br
// 35 condominio br
// 36 energia br
// 37 agua br
    
    /* =====================================================
       LOOP PRINCIPAL
    ===================================================== */
    foreach ($despesas as $index => $d) {

        $id = (int) $d['id_descricao'];
        $ignorar = in_array($id, $idsIgnorados, true);

        /* -------- TOTAIS GERAIS -------- */

        // Resta pagar
        // verifica se a despesa está marcada como "não paga" e não é uma das descrições ignoradas
        if ($d['pago'] === '2001-01-01' && !$ignorar) {
            $resta_pagar += $d['valor'];
        }

        // Resta pagar Brasília
        // verifica se a despesa está marcada como "não paga" e não é uma das descrições ignoradas
        if ($d['pago'] === '2001-01-01' && $ignorar) {
            $resta_pagar_Brasilia += $d['valor'];
        }


        // Total VA
        // Somente soma se a descrição não estiver na lista de ignorados
        if ($id === 33) {
            $totalVA += $d['valor'];
        }


        // Total Brasilia
        // Somente soma se a descrição não estiver na lista de ignorados
        if ($ignorar) {
            $totalBrasilia += $d['valor'];
        }


        // Total geral
        // Somente soma se a descrição não estiver na lista de ignorados
        if (!$ignorar) {
            $totalGeral += $d['valor'];
        }


        if ($descricaoAtual !== null && $descricaoAtual != $id) {

            echo "
        <div class='balao-total'>
                <!-- Exibe o total do balão anterior -->
                    Total {$descricaoNome} → R$ " . number_format($subtotalDescricao, 2, ',', '.') . "
                </div>
            </div>";

            $subtotalDescricao = 0;
        }




        if ($descricaoAtual != $id) {
            echo "
        <div class='balao'>
            <div class='balao-titulo'>
                {$d['descricao_abreviada']}
            </div>
                    <div class='col-md-6'>
                        <div class='balao-linha'>
                            <div class='despesa' style='text-align: left;'><strong>Despesa</strong></div>
                            <div><strong>Check</strong></div>
                            <div><strong>Valor</strong></div>
                            <div><strong>Data</strong></div>
                            <div><strong>Parcela</strong></div>
                            <div class='despesa' style='text-align: left;'><strong>Categoria</strong></div>
                            <div><strong>Vence</strong></div>
                            <div><strong>Status</strong></div>
                            <div><strong>Editar</strong></div>
                         </div>
                    </div>
        
        ";
            $descricaoAtual = $id;
            $descricaoNome = $d['descricao_abreviada'];
        }

        /* -------- STATUS -------- */
        // Verifica se a despesa está paga ou não
        // Se o sistema encontrar a data padrão (2001-01-01), ele exibe um aviso de "N Pago" com uma classe CSS específica
        // (provavelmente para ficar vermelho). Caso contrário, exibe "Pago" (provavelmente em verde)
        $statusPago = ($d['pago'] === '2001-01-01')
            ? "<span class='nao-pago'>N Pago</span>"
            : "<span class='pago'>Pago</span>";
        /* --------FIM DO STATUS -------- */

        /* -------- LINHA -------- <input type='checkbox' class='check' value='{$d['valor']}'> */
        echo "
        <div class='balao-linha'>
            <div class='despesa'>{$d['despesa']}</div>
            <div><input class='check' type='checkbox' value='{$d['valor']}'></div>
            <div class='valor'>R$ " . number_format($d['valor'], 2, ',', '.') . "</div>
            <div>" . date("d/m/Y", strtotime($d["data"])) . "</div>
            <div>" . parcela_func($d["parcela"]) . "</div>
            <div class='despesa' style='text-align:left;'>{$d['nome_categoria']}</div>
            <div>" . date("d/m/Y", strtotime($d["vencimento"])) . "</div>
            <div>{$statusPago}</div>
            <div class='bg-bege col-1 small-font'>
                <button class='btn btn-edit btn-bege' data-index=" . $index . " data-id=" . $d["id_despesa"] . ">
                    Editar
                </button>
            </div>
        </div>";

        $subtotalDescricao += $d['valor'];


        /* -------- PREENCHE OS DOIS SELECTS DA EDIÇÃO -------- */
        $selectDescricao = '';
        $result = obtem_dados_aux("descricao", "descricao_abreviada", "asc");
        $linhas = count($result);
        $selectDescricao .= "<select class='select' size=1 name=id_descricao>";

        $temp = $result;
        for ($i = 0; $i < $linhas; $i++) {
            if ($temp[$i]["id_descricao"] == $d["id_descricao"])
                $selectDescricao .= "<option Value=" . $temp[$i]["id_descricao"] . " selected>" . $temp[$i]["descricao_abreviada"] . "</option>";
            else
                $selectDescricao .= "<option Value=" . $temp[$i]["id_descricao"] . ">" . $temp[$i]["descricao_abreviada"] . "</option>";
        }
        $selectDescricao .= "</select>";


        $selectCategoria = '';
        $result = obtem_dados_aux("categoria", "nome_categoria", "asc");
        $linhas = count($result);

        $temp = $result;
        $selectCategoria .= "<select class='select' size=1 name=categoria>";
        for ($i = 0; $i < $linhas; $i++) {
            if ($temp[$i]["categoria"] == $d["categoria"])
                $selectCategoria .= "<option Value=" . $temp[$i]["categoria"] . " selected>" . $temp[$i]["nome_categoria"] . "</option>";
            else
                $selectCategoria .= "<option Value=" . $temp[$i]["categoria"] . ">" . $temp[$i]["nome_categoria"] . "</option>";
        }
        $selectCategoria .= "</select>";


        array_push($arraySelectDescricao, $selectDescricao);
        array_push($arraySelectCategoria, $selectCategoria);
        /* -------- PREENCHE OS DOIS SELECTS DA EDIÇÃO -------- */
    }
    /* -------- FECHA ÚLTIMO BALÃO -------- */
    if ($descricaoAtual !== null) {
        echo "
                <div class='balao-total'>
                    Total {$descricaoNome} → R$ " . number_format($subtotalDescricao, 2, ',', '.') . "
                </div>
            </div>";
    }
    ?>


    <!-- TOTAIS FINAIS -->
    <div class="col-md-10">
        <div class="balao">
            <div class="balao-titulo">Resumo Orçamento de <? echo $meses[$mes] . " de " . $ano; ?></div>

            <div class="balao-linha2">
                <div>BRASILIA</div>
                <div>NATAL</div>
            </div>

            <div class="balao-linha2">
                <div>Resta pagar → <strong>R$ <?= number_format($resta_pagar_Brasilia, 2, ',', '.') ?></strong></div>
                <div>Resta pagar → <strong>R$ <?= number_format($resta_pagar, 2, ',', '.') ?></strong></div>
            </div>

            <div class="balao-linha2">
                <div>Total de Despesas → <strong> R$ <?= number_format($totalBrasilia, 2, ',', '.') ?></strong></div>
                <div>Total de Despesas (inclui o VA)→ <strong>R$ <?= number_format($totalGeral, 2, ',', '.') ?></strong>
                </div>
            </div>

            <div class="balao-linha2">
                <div>Gastos com VA em Natal → <strong> R$ <?= number_format($totalVA, 2, ',', '.') ?> </strong></div>
                <div>Salário mês → <strong>R$ <?= number_format($salario, 2, ',', '.') ?></strong></div>
            </div>

            <div class="balao-linha2">
                <?php
                /* -------- STATUS DE CREDITO/DEBITO -------- */
                // calcula a diferença
                $diferenca = $totalBrasilia - $totalVA;

                // define a classe CSS
                $statusDiferenca = ($diferenca < 0)
                    ? "<span class='diferenca-negativa'>R$ " . number_format($diferenca, 2, ',', '.') . "</span>"
                    : "<span class='diferenca-positiva'>R$ " . number_format($diferenca, 2, ',', '.') . "</span>";
                /* -------- FIM DO STATUS -------- */
                ?>

                <div>TDif VA - DespBR → <strong>R$ <?= number_format($totalVA, 2, ',', '.') ?> - R$
                        <?= number_format($totalBrasilia, 2, ',', '.') ?> = <?= $statusDiferenca ?></strong></div>
                <div>Saldo →<strong>R$ <?= number_format($salario - $totalGeral, 2, ',', '.') ?></strong></div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="editDespesaModal" tabindex="-1" role="dialog" aria-labelledby="editDespesaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDespesaModalLabel">Editar Despesa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- <form action=grava_despesas_new.php method="POST" enctype="multipart/form-data" id=formulario  name=formulario> -->

                    <form id="editDespesaForm" method="POST" enctype="multipart/form-data">
                        <div class="container">

                            <div class="row">
                                <div class="col-9">
                                    <div class="form-group">
                                        <label for="editDescricao">Despesa:</label>
                                        <input type="text" class="form-control" id="editDescricao" name="descricao">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="editData">Data:</label>
                                        <input type="text" class="form-control" id="editData" name="data">
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="editValor">Valor:</label>
                                        <input type="text" class="form-control" id="editValor" name="valor"
                                            oninput="formatarValor(this)">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="editValor_casa">Valor Total:</label>
                                        <input type="text" class="form-control" id="editValor_casa" name="valor_casa"
                                            oninput="formatarValor(this)">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="editParcela">Parcela:</label>
                                        <input type="text" class="form-control" id="editParcela" name="parcela">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="editOcorrencia">Ocorrencia:</label>
                                        <input type="text" class="form-control" id="editOcorrencia" name="ocorrencia">
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="editSelectDescricao">Descrição:</label>
                                        <!-- <input type="text" class="form-control" id="editSelectDescricao" name="descricao"> -->
                                        <div id="editSelectDescricao"></div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="editSelectCategoria">Categoria:</label>
                                        <!-- <input type="text" class="form-control" id="editSelectCategoria" name="categoria"> -->
                                        <div id="editSelectCategoria"></div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="editVencimento">Vencimento:</label>
                                        <input type="text" class="form-control" id="editVencimento" name="vencimento">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="editPago">Pago:</label>
                                        <input type="text" class="form-control" id="editPago" name="pago">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="editObs">Observação:</label>
                                        <input type="text" class="form-control" id="editObs" name="obs">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                                        <label class="form-check-label" for="flexSwitchCheckDefault">Ativo</label>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <div id="pdfUploadSection" style="display:none;">
                                            <label for="pdfFile">Incluir novo arquivo PDF:</label>
                                            <input type="file" id="pdfFile" name="pdfFile" accept="application/pdf">
                                        </div>
                                    </div>
                                </div>
                                <!--   -->

                                <div class="col-2">
                                    <input type="hidden" id="despesaId" name="despesaId">
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="imagem">Arquivo PDF:</label>
                                        <!-- <img id='img'> -->
                                        <iframe id="pdfViewer" style="width:100%; height:500px;"></iframe>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        let valorTotalCheckbox = 0;
        document.querySelectorAll('.check').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                let value = parseFloat(this.value);
                if (this.checked) {
                    valorTotalCheckbox += value;
                } else {
                    valorTotalCheckbox -= value;
                }
                document.getElementById('total').textContent =
                    "Total: R$ " + valorTotalCheckbox.toLocaleString('pt-BR', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

            });

        });
    </script>

    <script>
        var id_despesa = undefined;
        var ocorrencia = undefined;

        $(document).ready(function () {

            // Adicionar o evento de clique para os botões de editar
            $('.btn-edit').on('click', function () {
                var despesaId = $(this).data('id');
                var index = $(this).data('index');
                id_despesa = despesaId;

                console.log(id_despesa)
                // Aqui fazemos a requisição para obter os dados da despesa
                $.ajax({
                    url: 'getDadosDaDespesa.php',
                    type: 'GET',
                    data: { id: despesaId, index: index },
                    success: function (data) {
                        // console.log(data)

                        var jsonData = JSON.parse(data);
                        console.log(jsonData)
                        var despesa = jsonData.despesa;
                        var categorias = jsonData.categorias;
                        var descricoes = jsonData.descricoes;

                        $('#editDescricao').val(despesa.despesa);
                        $('#editValor').val(despesa.valor);
                        $('#despesaId').val(despesa.id_despesa);
                        $('#editParcela').val(despesa.parcela);
                        $('#editOcorrencia').val(despesa.ocorrencia);
                        $('#editSelectDescricao').html(buildSelect(descricoes, despesa.id_descricao, 'id_descricao', 'descricao_abreviada', 'id_descricao'));
                        $('#editSelectCategoria').html(buildSelect(categorias, despesa.categoria, 'categoria', 'nome_categoria', 'categoria'));
                        $('#editData').val(dateFormat(despesa.data));
                        $('#editValor').val(despesa.valor);
                        $('#editParcela').val(despesa.parcela);
                        $('#editVencimento').val(dateFormat(despesa.vencimento));
                        $('#editPago').val(dateFormat(despesa.pago));
                        $('#editObs').val(despesa.obs);
                        $('#imagem').val(despesa.nome_imagem);
                        $('#flexSwitchCheckDefault').prop('checked', true)
                        $('#pdfViewer').attr('src', URL.createObjectURL(b64toBlob(despesa.imagem)));
                        $('#editValor_casa').val(despesa.valor_casa);


                        // Verifica se há um PDF associado
                        if (despesa.imagem && despesa.imagem.trim() !== "") {
                            // Se houver, exibe no visualizador
                            $('#pdfViewer').attr('src', 'data:application/pdf;base64,' + despesa.imagem);
                            // Esconde a seção de upload, pois já existe um arquivo
                            $("#pdfUploadSection").hide();
                        } else {
                            // Se não houver, limpa o visualizador e exibe o campo de upload
                            $('#pdfViewer').attr('src', '');
                            $("#pdfUploadSection").show();
                        }

                        /**/

                        // Exibe o modal
                        $('#editDespesaModal').modal('show');
                    }
                });
            });

            $('#editDespesaForm').on('submit', (event) => {
                event.preventDefault();
                console.log(event)

                var formData = new FormData();
                formData.append('id_despesa', id_despesa)
                formData.append('despesa', event.target[0].value)
                formData.append('data', dateDesformat(event.target[1].value))
                formData.append('valor', event.target[2].value.replace(',', '.'))
                formData.append('valor_casa', event.target[3].value.replace(',', '.'))
                formData.append('ocorrencia', ocorrencia)
                formData.append('parcela', event.target[4].value)
                formData.append('ocorrencia', event.target[5].value)
                formData.append('id_descricao', event.target[6].value)
                formData.append('categoria', event.target[7].value)
                formData.append('vencimento', dateDesformat(event.target[8].value))
                formData.append('pago', dateDesformat(event.target[9].value))
                formData.append('obs', event.target[10].value)
                formData.append('valido', event.target[11].checked ? 'S' : 'N')
                if (event.target[12] && event.target[12]?.files && event.target[12]?.files[0])
                    formData.append('pdf', event.target[12]?.files[0])

                for (let pair of formData.entries()) {
                    console.log(pair[0] + ':', pair[1]);
                }

                // var despesa = {};

                // despesa.id_despesa =  id_despesa;
                // despesa.despesa = event.target[0].value;
                // despesa.data = dateDesformat(event.target[1].value);
                // despesa.valor = event.target[2].value.replace(',','.');
                // despesa.valor_casa = event.target[3].value.replace(',','.');
                // despesa.ocorrencia = ocorrencia;
                // despesa.parcela = event.target[4].value;
                // despesa.ocorrencia = event.target[5].value;
                // despesa.id_descricao = event.target[6].value;
                // despesa.categoria = event.target[7].value;
                // despesa.vencimento = dateDesformat(event.target[8].value);
                // despesa.pago = dateDesformat(event.target[9].value);
                // despesa.obs = event.target[10].value;                
                // despesa.valido = event.target[11].checked ? 'S' : 'N';
                // despesa.pdf = event.target[12].files[0];
                // despesa.pdf.tmp_name = event.target[12].value


                // console.log('despesa', despesa);
                //    console.log(event)

                $.ajax({
                    url: 'save_despesa2.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: (result) => {
                        console.log(result)
                        alert(result);
                        $('#editDespesaModal').modal('hide');
                        $('#mesAno').datepicker('update');
                    },
                    error: () => {

                    }
                })
            })
        });

        function dateFormat(date) {
            let datasplit = date.split('-')
            return `${datasplit[2]}/${datasplit[1]}/${datasplit[0]}`;
        }

        function dateDesformat(date) {
            let datasplit = date.split('/');
            return `${datasplit[2]}-${datasplit[1]}-${datasplit[0]}`;
        }

        function buildSelect(options, selectedValue, valueField, labelField, name) {
            let html = `<select class="form-control" name="${name}">`;

            options.forEach(opt => {
                const selected = (opt[valueField] == selectedValue) ? 'selected' : '';
                html += `<option value="${opt[valueField]}" ${selected}>${opt[labelField]}</option>`;
            });

            html += `</select>`;

            return html;
        }

        function formatarValor(input) {
            let value = input.value;

            // remove tudo que não for número
            value = value.replace(/\D/g, '');

            // transforma em número decimal (centavos)
            value = (value / 100).toFixed(2);

            // formata para pt-BR
            value = value.replace('.', ',');

            // adiciona separador de milhar
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            input.value = value;
        }

        // converte base64 em blob
        function b64toBlob(b64Data, contentType = 'application/pdf', sliceSize = 512) {
            const byteCharacters = atob(b64Data);
            const byteArrays = [];

            for (let offset = 0; offset < byteCharacters.length; offset += sliceSize) {
                const slice = byteCharacters.slice(offset, offset + sliceSize);
                const byteNumbers = new Array(slice.length);
                for (let i = 0; i < slice.length; i++) {
                    byteNumbers[i] = slice.charCodeAt(i);
                }
                byteArrays.push(new Uint8Array(byteNumbers));
            }

            return new Blob(byteArrays, { type: contentType });
        }

    </script>
</body>

</html>