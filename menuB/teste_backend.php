<?php

// aponta para o arquivo config.php onde está a conexao com o Banco de Dados
Include ('config.php');
//require_once ("config.php");
require_once ("functions.inc");

// Faz uma chamada a function conectar que está em config.php e traz o resultado ou nao da conexao

$conn=conectar();


if (isset($_POST['dias_antes']) && isset($_POST['dias_depois'])) {

    $dias_antes = intval($_POST['dias_antes']);
    $dias_depois = intval($_POST['dias_depois']);

    // Define timezone
    date_default_timezone_set('UTC');

    $hoje = new DateTime('now');
    $hoje->setTime(0, 0, 0);      
    
    $data_inicio = clone $hoje;
    $data_inicio->setTime(0, 0, 0);
    $data_inicio->modify("-{$dias_antes} days");

    // formato do banco de dados
    $data_inicio_str = $data_inicio->format('Y-m-d');    
    
    
    $data_fim = clone $hoje;
    $data_fim->setTime(0, 0, 0);    
    $data_fim->modify("+{$dias_depois} days");

    // formato do banco de dados
    $data_fim_str = $data_fim->format('Y-m-d');

    // Exemplo de resposta para o front-end
      echo "<div class='row bg-cabecalho text-center' style='font-family: 'Calibri', sans-serif'>Buscando despesas entre <strong>". $data_inicio->format('d-m-Y') ."</strong> e <strong>".$data_fim->format('d-m-Y')."</strong><br></div>";
   // echo "Query montada: <code>$query</code>";




$query = "SELECT DISTINCT descricao.descricao_abreviada, despesa.id_descricao, despesa.pago, despesa.ocorrencia, despesa.valido, despesa.vencimento, descricao.id_descricao, descricao.debito 
FROM despesa
INNER JOIN descricao on despesa.id_descricao = descricao.id_descricao
WHERE despesa.vencimento BETWEEN '$data_inicio_str' AND '$data_fim_str'
AND despesa.pago='2001-01-01'
AND despesa.valido='s'
ORDER BY despesa.vencimento ,despesa.id_despesa ";


    // 📌 5. Preparação da consulta SQL com placeholder "?"
    // o SELECT já entra dentro do parenteses de prepare(como argumentos), tudo na mesma linha////
    $stmt = $conn->prepare("$query");

    // 📌 6. Verifica se a preparação falhou
    if (!$stmt) {
        die("Erro ao preparar a consulta: " . $conn->error);
    }

    $stmt->execute();

    // 📌 8. Obtendo os resultados
    $result = $stmt->get_result();

    // 📌 9. Convertendo os resultados para array associativo
    $vencidos = $result->fetch_all(MYSQLI_ASSOC);

?>

<div id="popup" class="popup">
    <div class="popup-content">     
            <?php if (!empty($vencidos)): ?>

              <!-- cabecalho -->
                    <div class='row bg-cabecalho text-left'>
                    <div class='col-xs-4'>Descrição</div>
                    <div class='col-xs-2'>Vencimento</div>
                    <div class='col-xs-1'>Ocorr</div>
                    <div class='col-xs-1'>Débito</div>
                    <div class='col-xs-3'>Vence em</div>
               </div>

              <!-- corpo da pesquisa -->
               <?php foreach ($vencidos as $index => $vencido): ?>
                    <div class='row'>
                      <div class="col-xs-4" style='text-align: left'>
                      <?php echo $vencido['descricao_abreviada']; ?>
                      </div>
                      <div class="col-xs-2" style='text-align: left'>
                        <?php echo date('d/m/Y', strtotime($vencido['vencimento'])); ?>
                      </div>
                      <div class="col-xs-1" style='text-align: left'>
                        <?php echo $vencido['ocorrencia']; ?>
                      </div>
                       <div class="col-xs-1" style='text-align: left'>
                        <?php echo $vencido['debito']; ?>
                      </div>

                      <div class="col-xs-3" style='text-align: left'>
                        <?php                    
                           // envia para a função dif a data do vencimento para ser comparada com a data de hoje e retorna a quantidade de dias.
                            echo dif($vencido['vencimento']); 
                        ?>
                      </div>
                        <!-- <div class='col-12 bg p-6 centro'>
                        </div> -->
                    </div> 
                <?php endforeach; ?>

               <!-- caso não encontre nenhum vencimento-->
            <?php else: ?>
                    <div colspan="2" class="text-center">Nenhuma despesa vencida <?php //echo $consulta ?></div>
            <?php endif; ?> 

<!-- desativado temporariamente 
    <button onclick="fecharPopup()">Fechar</button>   -->
    </div>
  </div>


<?php 
            }

////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['dias_antes2']) && isset($_POST['dias_depois4'])) {

    $dias_antes2 = intval($_POST['dias_antes2']);
    $dias_depois4 = intval($_POST['dias_depois4']);

    // Define timezone
    date_default_timezone_set('UTC');

    $hoje = new DateTime('now');      
    
    $data_inicio = clone $hoje;
    $data_inicio->modify("-{$dias_antes2} days");
    $data_inicio_a = clone $data_inicio;
    $data_inicio_strg = $data_inicio->format('Y-m-d');    
    
    
    $data_fim = clone $hoje;
    $data_fim->modify("+{$dias_depois4} days");
    $data_fim_a = clone $data_fim;
    $data_fim_strg = $data_fim->format('Y-m-d');

    // Exemplo de resposta para o front-end
      echo "<div class='row bg-cabecalho text-center' style='font-family: 'Calibri', sans-serif'>Buscando despesas entre <strong>". $data_inicio_a->format('d-m-Y') ."</strong> e <strong>".$data_fim_a->format('d-m-Y')."</strong><br></div>";
   // echo "Query montada: <code>$query</code>";




$query = "SELECT DISTINCT descricao.descricao_abreviada, despesa.id_descricao, despesa.pago, despesa.ocorrencia, despesa.valido, despesa.vencimento, descricao.id_descricao, descricao.debito 
FROM despesa
INNER JOIN descricao on despesa.id_descricao = descricao.id_descricao
WHERE despesa.vencimento BETWEEN '$data_inicio_strg' AND '$data_fim_strg'
AND despesa.pago='2001-01-01'
AND despesa.valido='s'
ORDER BY despesa.vencimento ,despesa.id_despesa ";


    // 📌 5. Preparação da consulta SQL com placeholder "?"
    // o SELECT já entra dentro do parenteses de prepare(como argumentos), tudo na mesma linha////
    $stmt = $conn->prepare("$query");

    // 📌 6. Verifica se a preparação falhou
    if (!$stmt) {
        die("Erro ao preparar a consulta: " . $conn->error);
    }

    $stmt->execute();

    // 📌 8. Obtendo os resultados
    $result = $stmt->get_result();

    // 📌 9. Convertendo os resultados para array associativo
    $vencidos = $result->fetch_all(MYSQLI_ASSOC);

?>

<div id="popup" class="popup">
    <div class="popup-content">     
            <?php if (!empty($vencidos)): ?>

              <!-- cabecalho -->
                    <div class='row bg-cabecalho text-left'>
                    <div class='col-xs-4'>Descrição</div>
                    <div class='col-xs-2'>Vencimento</div>
                    <div class='col-xs-1'>Ocorr</div>
                    <div class='col-xs-1'>Débito</div>
                    <div class='col-xs-3'>Vence em</div>
               </div>

              <!-- corpo da pesquisa -->
               <?php foreach ($vencidos as $index => $vencido): ?>
                    <div class='row'>
                      <div class="col-xs-4" style='text-align: left'>
                      <?php echo $vencido['descricao_abreviada']; ?>
                      </div>
                      <div class="col-xs-2" style='text-align: left'>
                        <?php echo date('d/m/Y', strtotime($vencido['vencimento'])); ?>
                      </div>
                      <div class="col-xs-1" style='text-align: left'>
                        <?php echo $vencido['ocorrencia']; ?>
                      </div>
                       <div class="col-xs-1" style='text-align: left'>
                        <?php echo $vencido['debito']; ?>
                      </div>

                      <div class="col-xs-3" style='text-align: left'>
                        <?php                    
                           // envia para a função dif a data do vencimento para ser comparada com a data de hoje e retorna a quantidade de dias.
                            echo dif($vencido['vencimento']); 
                        ?>
                      </div>
                        <!-- <div class='col-12 bg p-6 centro'>
                        </div> -->
                    </div> 
                <?php endforeach; ?>

               <!-- caso não encontre nenhum vencimento-->
            <?php else: ?>
                    <div colspan="2" class="text-center">Nenhuma despesa vencida <?php //echo $consulta ?></div>
            <?php endif; ?> 
<!-- desativado temporariamente 
    <button onclick="fecharPopup()">Fechar</button>   -->

    </div>
  </div>


<?php 
            }




















////////////////////////////////////////////////////////////////////////////////

            ?>


