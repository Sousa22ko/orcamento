<?php
require("functions.inc");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orcamento</title>

  <!-- Bootstrap 3 CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">      

  <!-- Datepicker CSS -->
  <link href="css/bootstrap-datepicker.css" rel="stylesheet">

  <!-- Seu estilo -->
  <link rel="stylesheet" href="./styles.css">

  <style>
    .container {
      margin: 15px;
      margin-top: 90px;
    }
  </style>
</head>

<body>
  <br><br>

  <div class="container p-3 mb-2 bg-beige" style="padding-top: 15px; padding-bottom: 15px">
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <button type="button" class="btn bg-beige">
            Inclui Receita <span class="badge badge-light">Inclui</span>
          </button>
        </div>
      </div>
    </div>

    <form action="grava_receitas_new.php" method="post" name="formulario">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="ocorrencia">Ocorrência</label>
            <div class="input-group date">
              <input type="text" class="form-control" id="exemplo2" name="ocorrencia" value="<?php echo proximo_mes(); ?>">
              <div class="input-group-addon">
                <span class="glyphicon glyphicon-th"></span>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label for="valor">Valor</label>
            <input type="number" class="form-control" name="valor" id="valor" step="0.01" placeholder="Digite valor" required>
          </div>
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
  </div>

  <!-- Scripts agrupados -->
  <?php include("includes/scripts.php"); ?>
</body>
</html>
