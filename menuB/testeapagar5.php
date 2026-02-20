<?php
$minDias = 1;
$maxDias = 30;
$valueDias = 1;
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Filtro por Dias</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.6.2/css/bootstrap-slider.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.6.2/bootstrap-slider.min.js"></script>
</head>
<body>
  <div class="container">
    <h3>Selecionar intervalo de dias</h3>

          <div class='row'>
              <div class="col-xs-4" style='text-align: left'>
                <label for="diasSlider">Dias antes:</label>
                <!-- ativa o script #diasSlider-->
                <input id="diasSlider" type="text" />
                <span id="valorSlider" class="label label-info">1 dia</span>
              </div>

              <div class="col-xs-4" style='text-align: left, align-items: center'>
                <label for="dias2Slider">Dias depois:</label>
                <!-- ativa o script #dias2Slider-->
                <input id="dias2Slider" type="text" />
                <span id="valor2Slider" class="label label-info">1 dia</span>
              </div>

               <div class="col-xs-1" style='text-align: left'> 
                <!-- esse button id=buscar, faz conexão com o script do AJAX -->
               <button id="buscar" class="btn btn-primary">Buscar</button>
              </div>

              <div class="col-xs-5"  id="resultado" style='text-align: left'></div>
          </div>


          <div class='row'>
              <div class="col-xs-4" style='text-align: left'>
                <label for="dias3Slider">Dias antes:</label>
                <!-- ativa o script #diasSlider-->
                <input id="dias3Slider" type="text" />
                <span id="valor3Slider" class="label label-info">1 dia</span>
              </div>

              <div class="col-xs-4" style='text-align: left, align-items: center'>
                <label for="dias4Slider">Dias depois:</label>
                <!-- ativa o script #dias2Slider-->
                <input id="dias4Slider" type="text" />
                <span id="valor4Slider" class="label label-info">1 dia</span>
              </div>

               <div class="col-xs-1" style='text-align: left'> 
                <!-- esse button id=buscar, faz conexão com o script do AJAX -->
               <button id="buscar" class="btn btn-primary">Buscar</button>
              </div>

              <div class="col-xs-5"  id="resultado" style='text-align: left'></div>
          </div>


  </div>

  <script>
    // Inicializa o slider
    // dias_antes ///////////////////

    
    // Recebe os valores do PHP via JS
    var minDias = <?php echo $minDias; ?>;
    var maxDias = <?php echo $maxDias; ?>;
    var valueDias = <?php echo $valueDias; ?>;
    
    $("#diasSlider").slider({
        min: minDias,
        max: maxDias,
        value: valueDias,
        tooltip: 'hide'
    }).on("slide", function(evt) {
      $("#valorSlider").text("-"+evt.value + " dias");
    });
   
    // dias_depois
    $("#dias2Slider").slider({
        min: minDias,
        max: maxDias,
        value: valueDias,
      tooltip: 'hide'
    }).on("slide", function(evt) {
      $("#valor2Slider").text(evt.value + " dias");
    });

    // dias_antes ///////////////////
    $("#dias3Slider").slider({
      min: 1,
      max: 30,
      value: 1,
      tooltip: 'hide'
    }).on("slide", function(evt) {
      $("#valor3Slider").text("-"+evt.value + " dias");
    });
   
    // dias_depois
    $("#dias4Slider").slider({
      min: 1,
      max: 30,
      value: 1,
      tooltip: 'hide'
    }).on("slide", function(evt) {
      $("#valor4Slider").text(evt.value + " dias");
    });








    // Envia via AJAX ao clicar em "Buscar"
    $("#buscar").click(function () {
      const dias = $("#diasSlider").slider('getValue');
      const dias2 = $("#dias2Slider").slider('getValue');
      const dias3 = $("#dias3Slider").slider('getValue');
      const dias4 = $("#dias4Slider").slider('getValue');


      $.ajax({
          url: "teste_backend.php",
          method: "POST",
          data: { dias_antes: dias, 
                  dias_depois: dias2, 
                  dias_antes2: dias3, 
                  dias_depois4: dias4 },
          success: function(resposta) {
              $("#resultado").html(resposta);
            }
        });
        
    });
  </script>

</body>
</html>
