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
        300px
        30px
        110px
        110px
        110px
        150px
        140px
        100px
        80px;
    gap: 6px;
    padding: 6px 0;
    border-bottom: 1px dotted #999;
    align-items: center;
    text-align: center;
}

.balao-linha2 {
    display: grid;
    grid-template-columns:
        600px
        600px
        110px
        110px
        110px
        70px
        140px
        100px
        80px;
    gap: 6px;
    padding: 6px 0;
    border-bottom: 1px dotted #999;
    align-items: left;
    text-align: left;
}

.balao-linha3 {
    display: grid;
    grid-template-columns:
        400px
        100px
        400px
        100px
        1px
        7px
        1px
        1px
        8px;
    gap: 50px;
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
    box-shadow: 0 4px 6px rgba(0,0,0,.2);
}

/* Estilo do campo flutuante fixo */
#campo-flutuante {
    position: fixed; /* Mantém fixo na tela */
    bottom: 560px;  /* Distância do fundo */
    right: 12px;   /* Distância da direita */
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

</style>
</head>

<body>

<div id='campo-flutuante'>
    <span id='total'>Total: R$ 0,00</span>
</div>



<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "config.php";
require_once "functions.inc";

setlocale(LC_TIME, 'pt_BR.UTF-8');




$mesAno = $_GET['mesAno'] ?? null;
if (!$mesAno) {
    exit("Ocorrência não informada");
}

$conn = conectar();
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

/* =====================================================
   BUSCA RECEITA
===================================================== */
$salario = 0;

$sqlReceita = "SELECT receita FROM receita WHERE ocorrencia = ?";
$stmt = $conn->prepare($sqlReceita);
$stmt->bind_param("s", $mesAno);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $salario = $row['receita'];
}
$stmt->close();

/* =====================================================
   BUSCA DESPESAS
===================================================== */
$sql = "SELECT 
    despesa.*,
    descricao.descricao_abreviada,
    categoria.nome_categoria
FROM despesa
JOIN descricao ON despesa.id_descricao = descricao.id_descricao
JOIN categoria ON despesa.categoria = categoria.categoria
WHERE despesa.ocorrencia = ?
  AND despesa.valido = 'S'
ORDER BY despesa.id_descricao ASC, despesa.valor DESC , despesa.data ASC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $mesAno);
$stmt->execute();
$result = $stmt->get_result();
$despesas = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

/* =====================================================
   VARIÁVEIS DE CONTROLE
===================================================== */
$descricaoAtual = null;
$descricaoNome  = '';
$subtotalDescricao = 0;
$resta_pagar = 0;
$resta_pagar_Brasilia = 0;
$totalGeral  = 0;
$totalBrasilia = 0;
$totalNatal = 0;
$totalVA = 0;
$diferenca = 0;
$diferencaNatal = 0;
$ano = "20" . substr($mesAno,0,2);
$mes = substr($mesAno,2,2);
$data = mktime(0,0,0,$mes,1);
$meses = [
"01"=>"Janeiro","02"=>"Fevereiro","03"=>"Março","04"=>"Abril",
"05"=>"Maio","06"=>"Junho","07"=>"Julho","08"=>"Agosto",
"09"=>"Setembro","10"=>"Outubro","11"=>"Novembro","12"=>"Dezembro"
];

// IDs que devem ser ignorados nos totais
$idsIgnorados = [34,35,36,37];
// 33 despesa VA
// 34 aluguel br
// 35 condominio br
// 36 energia br
// 37 agua br

/* =====================================================
   LOOP PRINCIPAL
===================================================== */
foreach ($despesas as $d) {

    $id = (int)$d['id_descricao'];
    $ignorar = in_array($id, $idsIgnorados, true);

        /* -------- TOTAIS GERAIS -------- */

        // Resta pagar Natal
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

        // Total Somente Natal
        // Somente soma se a descrição não estiver na lista de ignorados
        // Inclue tambem o V.A. (id 33) no total geral, pois é uma despesa de Natal
        if ($ignorar and !$id === 33) {
            $totalNatal += $d['valor'];
        } 

        // Total geral
        // Somente soma se a descrição não estiver na lista de ignorados
        // Inclue tambem o V.A. (id 33) no total geral, pois é uma despesa de Natal
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
                            <div class='despesa' style='text-align: z;'><strong>Categoria</strong></div>
                            <div><strong>Vence</strong></div>
                            <div><strong>Status</strong></div>
                            <div><strong>Ação</strong></div>
                         </div>
                    </div>
        
        ";
        $descricaoAtual = $id;
        $descricaoNome  = $d['descricao_abreviada'];        
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
            <div class='despesa'>
                <button class='btn btn-edit btn-bege' data-id='{$d['id_despesa']}'>
                  Editar
                </button>
            </div>
        </div>";

            $subtotalDescricao += $d['valor'];
}
        /* -------- FECHA ÚLTIMO BALÃO -------- */
        if ($descricaoAtual !== null) {
            echo "
                <div class='balao-total'>
                    Total {$descricaoNome} → R$ " . number_format($subtotalDescricao, 2, ',', '.') . "
                </div>
            </div>";
        }
        $tot=$totalGeral-$totalVA;   
?>


<!-- TOTAIS FINAIS -->
<div class="col-md-10">
    <div class="balao">
        <div class="balao-titulo">Resumo Orçamento de <? echo $meses[$mes] . " de " . $ano; ?></div>

        <div class="balao-linha3">
            <div><strong>BRASILIA</strong></div>
            <div class='despesa' style='text-align: right;'><strong>Valor</strong></div>    
            <div><strong>NATAL</strong></div>
            <div class='despesa' style='text-align: right;'><strong>Valor</strong></div>
        </div>

        <div class="balao-linha3">
            <div>Resta pagar BR</div>
            <div class='despesa' style='text-align: right;'><strong>R$ <?= number_format($resta_pagar_Brasilia, 2, ',', '.') ?></strong></div>
            
            <div>Resta pagar NT</div>
            <div class='despesa' style='text-align: right;'><strong>R$ <?= number_format($resta_pagar, 2, ',', '.') ?></strong></div>       
        </div>

        <div class="balao-linha3">
            <div>Total Despesa (Aluguel + Cond + Luz + Agua)</div>
            <div class='despesa' style='text-align: right;'><strong>R$ <?= number_format($totalBrasilia, 2, ',', '.') ?></strong></div>
            <div>Total Despesa (Desp Natal + VA)</div>
            <div class='despesa' style='text-align: right;'><strong>R$ <?= number_format($totalGeral, 2, ',', '.') ?></strong></div>       
        </div>

        <div class="balao-linha3">
            <div>Gastos com VA em Natal</div>
            <div class='despesa' style='text-align: right;'><strong>R$ <?= number_format($totalVA, 2, ',', '.') ?></strong></div>
            <div>Salário mês</div>
            <div class='despesa' style='text-align: right;'><strong>R$ <?= number_format($salario, 2, ',', '.') ?></strong></div>       
        </div>


        <div class="balao-linha3">
            <?php
            /* -------- STATUS DE CREDITO/DEBITO DE BRASILIA -------- */
            // calcula a diferença
            $diferenca = $totalBrasilia - $totalVA;

            // define a classe CSS
            $statusDiferenca = ($diferenca < 0)
                ? "<span class='diferenca-negativa'>R$ " . number_format($diferenca, 2, ',', '.') . "</span>"
                : "<span class='diferenca-positiva'>R$ " . number_format($diferenca, 2, ',', '.') . "</span>";
            /* -------- FIM DO STATUS BRASILIA -------- */


            /* -------- STATUS DE CREDITO/DEBITO DE NATAL -------- */
            // calcula a diferença
            $diferencaNatal = $salario - $totalGeral;

            // define a classe CSS
            $statusDiferencaNatal = ($diferencaNatal < 0)
                ? "<span class='diferenca-negativa'>R$ " . number_format($diferencaNatal, 2, ',', '.') . "</span>"
                : "<span class='diferenca-positiva'>R$ " . number_format($diferencaNatal, 2, ',', '.') . "</span>";
            /* -------- FIM DO STATUS BRASILIA -------- */


            ?>
            
            <div>Tot_Dif (DespBR - VA Natal)  R$ <?= number_format($totalBrasilia, 2, ',', '.')  ?>  -  R$ <?= number_format($totalVA, 2, ',', '.') ?></div>
            <div class='despesa' style='text-align: right;'><strong><?= $statusDiferenca ?></strong></div>
            <div>Saldo</div>
            <div class='despesa' style='text-align: right;'><strong><?= $statusDiferencaNatal ?></strong></div>      
        </div>      
    </div>
</div>


<script>
let valorTotalCheckbox = 0;
document.querySelectorAll('.check').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
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
</body> 
</html>

