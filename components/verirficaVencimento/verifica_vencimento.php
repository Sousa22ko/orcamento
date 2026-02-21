<?php

include '/pages/generic.php';
include '/api/dbConnection.php';

// Faz uma chamada a function conectar que está em config.php e traz o resultado ou nao da conexao
$conn = conectar();

// Obtém as datas do range
$datas = getRangeDatas();

// Acessa individualmente
$data_inicio_str = $datas['data_inicio'];
$data_fim_str    = $datas['data_fim'];



// 4.2 📌Montando a consulta
$consulta = "SELECT DISTINCT descricao.descricao_abreviada, despesa.id_descricao, despesa.pago, despesa.ocorrencia, despesa.valido, despesa.vencimento, descricao.id_descricao, descricao.debito 
FROM despesa
INNER JOIN descricao on despesa.id_descricao = descricao.id_descricao
WHERE despesa.vencimento BETWEEN '$data_inicio_str' AND '$data_fim_str'
AND despesa.pago='2001-01-01'
AND despesa.valido='s'
ORDER BY despesa.vencimento ,despesa.id_despesa 
";

// 📌 5. Preparação da consulta SQL com placeholder "?"
// o SELECT já entra dentro do parenteses de prepare(como argumentos), tudo na mesma linha////
$stmt = $conn->prepare("$consulta");

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

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Relatório de Despesas</title>
  <!-- <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'> -->
</head>

<body>

  <div id="popup" class="popup">
    <div class="popup-content">
      <?php if (!empty($vencidos)): ?>

        <!-- cabecalho -->
        <div class='row bg-cabecalho text-center'>
          <div class='col-xs-4'>Descrição</div>
          <div class='col-xs-2'>Vencimento</div>
          <div class='col-xs-2'>Ocorr</div>
          <div class='col-xs-1'>Débito</div>
          <div class='col-xs-3'>Vence em</div>
        </div>

        <!-- corpo da pesquisa -->
        <?php foreach ($vencidos as $index => $vencido): ?>
          <div class='row'>
            <div class="col-xs-4" style='text-align: left'>
              <?php echo $vencido['descricao_abreviada']; ?>
            </div>
            <div class="col-xs-2">
              <?php echo date('d/m/Y', strtotime($vencido['vencimento'])); ?>
            </div>
            <div class="col-xs-2">
              <?php echo $vencido['ocorrencia']; ?>
            </div>
            <div class="col-xs-1">
              <?php echo $vencido['debito']; ?>
            </div>

            <div class="col-xs-3">
              <?php
              echo diffToday($vencido['vencimento']);
              ?>
            </div>
            <!-- <div class='col-12 bg p-6 centro'>
                        </div> -->
          </div>
        <?php endforeach; ?>

        <!-- caso não encontre nenhum vencimento-->
      <?php else: ?>
        <div colspan="2" class="text-center">Nenhuma despesa vencida <?php //echo $consulta 
                                                                      ?></div>
      <?php endif; ?>

      <button onclick="fecharPopup()">Fechar</button>
    </div>
  </div>


  <script>
    function mostrarPopupSeNecessario() {
      const hoje = new Date().toISOString().slice(0, 10);
      localStorage.setItem('popupData', hoje);
    }

    function fecharPopup() {
      window.parent.carregarPagina('/fundo.html')
    }

    window.onload = mostrarPopupSeNecessario;
  </script>


  <!-- <button onclick="resetarPopup()">Resetar popup</button>

<script>
  function resetarPopup() {
    localStorage.removeItem('popupData');
    alert('Popup resetado!');
  }
</script> -->



  <!-- Scripts agrupados -->
  <?php include("includes/scripts.php"); ?>

  <!-- script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> -->
</body>

</html>

</div>




<?php
// 📌 10. Fechando recursos
$stmt->close();
$conn->close();
?>