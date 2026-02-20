
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modal Bootstrap Example</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  
  
     <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">-->
  <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
  <link href="css/bootstrap-datepicker.css" rel="stylesheet" />

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>-->


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="js/bootstrap-datepicker.min.js"></script>
  <script src="js/bootstrap-datepicker.pt-BR.min.js" charset="UTF-8"></script>
    <style>
    .row{
      align-items: center;
      margin-top: 15px;
      margin-bottom: 15px;
    }
    .mh-34 {
      min-height: 34px;
    }
    .mw-100 {
      max-width: 100%;
    }
  </style>
<p align="right"></p>
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
</head>
<body>


  <?php
  require ("orcamento.inc");
  require ("functions.inc");
  $indice = '5238';

  $query = "SELECT $dbname.despesa.*,$dbname_aux.descricao.*
          FROM $dbname.despesa ,$dbname_aux.descricao
          WHERE $dbname.despesa.valido='S'
          AND $dbname.despesa.id_descricao=$dbname_aux.descricao.id_descricao
          AND $dbname.despesa.id_despesa=" . $indice;

  //print "$query";
// Executa a primeira query sql

  $result = mysqli_query($mysqli_connection, $query) or die("N�o consegui consultar" . $query . mysqli_error());
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

  ?>




<!-- Modal extra grande -->
<button class="btn btn-primary" data-toggle="modal" data-target="#modalID">Modal extra grande</button>



<div class="modal fade bd-example-modal-xl" id='modalID' tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <!--///////////////////////////////////////////////////////////////-->
      <div class='modal-dialog modal-dialog-centered modal-lg' role='document'>
        <div class='modal-content'>

          <div class="modal-header">
            <h5 class="modal-title">Alterar/Excluir</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>


          <div class='modal-body'>


            <div class="container mw-100">

              <div class="row" id="linha1">
                <!-- linha 1 coluna 1 -->
                <div class="col-5">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Despesa</span>
                    <input style='WIDTH: 180px' name=despesa value=<? echo $row["despesa"]; ?> type="text"
                      class="form-control">
                  </div>

                </div>

                <!-- linha 1 coluna 2 -->
                <div class="col-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Valor</span>
                    <input style='WIDTH: 80px' name=valor value=<? echo $row["valor"]; ?> type="text"
                      class="form-control">
                  </div>
                </div>

                <!-- linha 1 coluna 3 -->
                <div class="col-4">
                  <div class="form-group input-group-prepend mb-0">
                    <span class="input-group-text">Data</span>
                    <div class="input-group date">
                      <input type='text' class="form-control" id="exemplo" name="data" value=<? echo date("d/m/Y", (strtotime($row["data"]))); ?>>
                      <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row" id="linha2">
                <!-- linha 2 coluna 1 -->
                <div class="col-4">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Parcela</span>
                    <input style='WIDTH: 70px' name=parcela type="text" class="form-control" value=<? echo $row["parcela"]; ?>>

                  </div>
                </div>
                <!-- linha 2 coluna 2 -->
                <div class="col-4 ">
                  <div class="form-group input-group-prepend mb-0">
                    <span class="input-group-text">Vencimento</span>
                    <div class="input-group date">
                      <input type='text' class="form-control" id="exemplo3" name="vencimento"
                        value=<? echo date("d/m/Y", (strtotime($row["vencimento"]))); ?>>
                      <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- linha 2 coluna 3 -->
                <div class="col-4">
                  <div class="input-group-prepend">
                    <span class="input-group-text mh-34">Descricao</span>
                    <?php
                    //****************** Obtem os tipos de despesas ************ -->
                    $result = obtem_dados_aux("descricao", "descricao_abreviada", "asc") or die(mysql_error());
                    $linhas = mysqli_num_rows($result);
                    for ($i = 0; $i < $linhas; $i++) {
                      $array[$i] = mysqli_fetch_array($result);
                    }
                    print ("<select size=1 name=id_descricao>");

                    for ($i = 0; $i < $linhas; $i++) {
                      if ($array[$i][0] == $row["id_descricao"])
                        print "<option Value=" . $array[$i][0] . " selected>" . $array[$i][2] . "</option>";
                      else
                        print "<option Value=" . $array[$i][0] . ">" . $array[$i][2] . "</option>";
                    }
                    print ("</select>");
                    //********************** Fim ***************************** -->

                    ?>
                  </div>
                </div>
              </div>
              <div class="row" id="linha3">
                <!-- linha 3 coluna 1 -->
                <div class="col-6">
                  <div class="input-group-prepend mh-34">
                    <span class="input-group-text">Categoria</span>
                    <?
                    //****************** Obtem os tipos de despesas ************ -->
                    $result = obtem_dados_aux("categoria", "nome_categoria", "asc") or die(mysql_error());
                    $linhas = mysqli_num_rows($result);
                    for ($i = 0; $i < $linhas; $i++) {
                      $array[$i] = mysqli_fetch_array($result);
                    }
                    print ("<select size=1 name=categoria>");

                    for ($i = 0; $i < $linhas; $i++) {
                      if ($array[$i][0] == $row["categoria"])
                        print "<option Value=" . $array[$i][0] . " selected>" . $array[$i][1] . "</option>";
                      else
                        print "<option Value=" . $array[$i][0] . ">" . $array[$i][1] . "</option>";
                    }
                    print ("</select>");
                    //********************** Fim ***************************** -->
                    ?>
                  </div>
                </div>

                <!-- linha 3 coluna 2 -->
                <div class="col-4">
                  <div class="form-group input-group-prepend mb-0">
                    <span class="input-group-text">Pago em</span>
                    <div class="input-group date">
                      <input type='text' class="form-control" id="exemplo4" name="pago" value=<? echo date("d/m/Y", (strtotime($row["pago"]))); ?>>
                      <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row" id="linha4">

              <!-- linha 4 coluna 1 -->
              <div class="col-2">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Salvar</span>
                    <button type="button" class="btn btn-light">
                      <a href=<? echo $row["id_despesa"]; ?>><i class="bi bi-save-fill"></i></a>
                    </button>
                  </div>
                </div>
              </div>

            </div>


    

       <!--///////////////////////////////////////////////////////////////-->
    </div>
  </div>
</div>


        <script type="text/javascript">
          $('#exemplo').datepicker({
            format: "dd/mm/yyyy",
            language: "pt-BR",
            startDate: '-120d',
            autoclose: true,

          });
        </script>


        <script type="text/javascript">
          $('#exemplo2').datepicker({
            format: "mm/yyyy",
            language: "pt-BR",
            startDate: '-3d',
            startView: 'months',
            minViewMode: 'months',
            autoclose: true,
          });
        </script>

        <script type="text/javascript">
          $('#exemplo3').datepicker({
            format: "dd/mm/yyyy",
            language: "pt-BR",
            startDate: '-120d',
            autoclose: true,

          });
        </script>



        <script type="text/javascript">
          $('#exemplo4').datepicker({
            format: "dd/mm/yyyy",
            language: "pt-BR",
            startDate: '-120d',
            autoclose: true,

          });
        </script>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>




