<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Relat�rio com Bootstrap e PHP</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    /* Estilo para letras pequenas */
    .small-text {
      font-size: 12px;
    }
    /* Estilo para reduzir espa�amento entre linhas */
    .tight-line-height {
      line-height: 1.2;
    }
  </style>
</head>
<body>
  <div class="container mt-4">
    <h2 class="mb-4">Relat�rio</h2>
   <div class="row">
      <div class="col-sm-2"><strong>Coluna 1</strong></div>
      <div class="col-sm-2"><strong>Coluna 2</strong></div>
      <div class="col-sm-2"><strong>Coluna 3</strong></div>
      <div class="col-sm-3"><strong>Coluna 4</strong></div>
      <div class="col-sm-3"><strong>Coluna 5</strong></div>
    </div>

    <!-- Linha 1 -->
    <div class="row tight-line-height">
      <div class="col-sm-2">Valor A1</div>
      <div class="col-sm-2">Valor B1</div>
      <div class="col-sm-2">Valor C1</div>
      <div class="col-sm-3">Valor D1</div>
      <div class="col-sm-3">Valor E1</div>
    </div>

    <!-- Linha 2 -->
    <div class="row tight-line-height">
      <div class="col-sm-2">Valor A2</div>
      <div class="col-sm-2">Valor B2</div>
      <div class="col-sm-2">Valor C2</div>
      <div class="col-sm-3">Valor D2</div>
      <div class="col-sm-3">Valor E2</div>
    </div>

    <!-- Linha 3 -->
    <div class="row tight-line-height">
      <div class="col-sm-2">Valor A3</div>
      <div class="col-sm-2">Valor B3</div>
      <div class="col-sm-2">Valor C3</div>
      <div class="col-sm-3">Valor D3</div>
      <div class="col-sm-3">Valor E3</div>
    </div>
 </div>

  <!-- Bootstrap JS e depend�ncias opcionais -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

