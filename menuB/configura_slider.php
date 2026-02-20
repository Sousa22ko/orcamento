<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Slider - Range slider</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <style>
    #slider-range { margin: 10px 0; width: 250px; }
    label { width: 500px; /* Define a largura como 200 pixels */
            /*display: block;  Se necessário, garante que o label ocupe a largura definida */
          }
  </style>

<?php
include('config.php');
require_once('functions.inc');
$conn = conectar();

$result = $conn->query("SELECT * FROM configuracao WHERE modulo = 'popup_vencimento'");
if ($row = $result->fetch_assoc()) {
    $min = (int)$row['min'];
    $max = (int)$row['max'];
    $valor1 = (int)$row['valor1']; 
    $valor2 = (int)$row['valor2'];
} else {
    $min = 2;
    $max = 29;
    $valor1 = 3;
    $valor2 = 17;
}
$values = array($valor1, $valor2);
?>

<script>
  var min = <?php echo json_encode($min); ?>;
  var max = <?php echo json_encode($max); ?>;
  var values = <?php echo json_encode($values); ?>;
  console.log("Valores do slider:", values); // debug

  $(function() {

      $("#slider-range").slider({
        range: true,
        min: min,
        max: max,
        values: values,
        slide: function(event, ui) {
         // $("#amount").val("Dias: <-" + ui.values[0] + " Dias: -> " + ui.values[1]);
          $("#amount").val(ui.values[0] + " Dias Antes -> " + ui.values[1] +" Dias Depois");
        },
        stop: function(event, ui) {
          // Envia os valores atualizados ao servidor
          $.ajax({
            url: "atualiza_slider.php",
            method: "POST",
            data: {
              valor1: ui.values[0],
              valor2: ui.values[1]
            },
            success: function(response) {
              console.log("Atualização feita:", response);
            },
            error: function(xhr, status, error) {
              console.error("Erro ao atualizar:", error);
            }
          });
        }
      });

 // ✅ Atualiza o campo com os valores iniciais
  $("#amount").val(values[0] + "Dias Antes - " + values[1]+"Dias Depois");


  });

</script>
</head>
<body>


<p>
  <label for="amount">Intervalo</label>
  <input type="text" id="amount" readonly style="width:300px; border:0; color:#f6931f; font-weight:bold;">
</p>




<div id="slider-range"></div>

</body>
</html>
