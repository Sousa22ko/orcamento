<?
require ("orcamento.inc");
require ("functions.inc");

if (isset($_POST['buscaPHP'])) {
  $busca = ($_POST["buscaPHP"]);

  $mes = substr($busca, 2, 2);
  $ano = substr($busca, 0, 2);

  $cor = "#f9f5e6";
  $a = 0;
  $contador = 1;
  $subtotal = 0;
  $subtotal_casa = 0;
  $subtotal_casa1 = 0;
  $subtotal_casa2 = 0;
  $total = 0;
  $somatorio = 0;
  $aindanaopago = 0;
  $naopago = 0;
  $rec = 0;
  $despesas_cartao["1"] = 0;
  $despesas_cartao["3"] = 0;
  $contar = 0;
  $A_teste = array();











  // estabelece a primeira query ///////////
  $query = "SELECT $dbname.despesa.*,$dbname_aux.descricao.*
        FROM $dbname.despesa,$dbname_aux.descricao
        WHERE $dbname.despesa.ocorrencia = '$busca'
        AND $dbname.despesa.id_descricao=$dbname_aux.descricao.id_descricao
        AND $dbname.despesa.valido='S'
        ORDER BY $dbname.despesa.id_descricao,$dbname.despesa.valor  DESC";

  $result = mysqli_query($mysqli_connection, $query);

  if (mysqli_num_rows($result)) {
    print (" <p><div class='container p-3 mb-5 bg-light'>

             <div class='row'>
                <div class='col-md-4'>
                    <div class='form-group' style='font-size: xx-small'>
                    <button type='button' class='btn btn-primary'>Consulta/Altera/Eclui
                    </button>
                    </div>
                </div>
             </div>
             
             
         <table class='table table-striped table-bordered table-condensed table-hover'>

         <thead>
          <tr>
             <th scope='col' class='form-group' style='font-size: xx-small'> Despesa</th>
             <th scope='col'>Valor</th>
             <th scope='col'>Data</th>
             <th scope='col'>Parcela</th>
             <th scope='col'>Descricao</th>
             <th scope='col'>Vencimento</th>
             <th scope='col'>Pago em</th>
             <th scope='col'>Alter</th>
             <th scope='col'>Excl</th>

          </tr>
          </thead>
          <tbody>
                
          
   ");

    $id_desp = [];
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))      // executa enquanto houver resultados
    {
      $contar++;
      while ($row["id_descricao"] != $contador)  // procede a virada de subtotais
      {
        $cartao["$contador"] = $subtotal;
        if (impar($contador)) {
          $cor = "#c0c0c0";
        } else {
          $cor = "#f9f5e6";
        } // troca cor de fundo
        if ($subtotal != 0) {
          linha_branco();
        }  //verifica se subtotal e 0 e encerra com linha azul
        $contador = $contador + 1;
        $subtotal = 0;                          // zera o subtotal
      }


      ///////////////////////////////////////////////

      print ("<tr>
      <th scope='row'><a target=_top href=http://localhost/orcamento/mostra_despesa_alterar.php?indice=".$row["id_despesa"].">". $row["despesa"]." 
                      </a></span></th>      
      
      <td>" . $row["valor"] . "<INPUT TYPE='checkbox' NAME='OPCAO' VALUE='op2'></td>
      <td>" . date("d/m/Y", (strtotime($row["data"]))) . "</td>
      <td><strong><font color =" . status2($row["parcela"]) . ">" . $row["parcela"] . "</strong></font></td>
      <td><span style='font-family: Arial;font-size:10px; color:#000000;'>" . $row["descricao_abreviada"] . "</font></td>");


      ////////////////////////////////////////////////////


      $subtotal = $subtotal + $row["valor"];    // atribui valor a subtotal
      $total = $total + $row["valor"];      // atribui valor a total geral acumulando

      if ($row["id_descricao"] <= 3)   // acumula o valor dos cartoes de credito na variavel $despesas_cartao
      {
        $despesas_cartao["$contador"] = $subtotal;
      }



      $data1 = date("Y/m/d", (strtotime($row["vencimento"])));
      $corr = '';



      ///////////////////////////////////////////////////////////////////////


      //alerta($row["vencimento"])
      print ("
      <td><span style='font-family: Arial;font-size:10px; color=" . Diferenca($data1) . "'><strong>" . date("d/m/Y", (strtotime($row["vencimento"]))) . "    " . $corr . "</strong></font></td>
      ");

      // esta fun��o verifica a condi��o da data de pagamento:se for igual a 2001-01-01,
      // que � a data estipulada na inclusao da despesa, como flag que ainda n�o foi paga.
      //caso n�o tenha sido paga apresenta a informa��o nao 'paga!', caso tenha sido
      // apresenta a data do pagamento
      $aindanaopago = status($row["pago"], $cor, $row["valor"]);

      if ($aindanaopago <> 0)  // atribui a variavel naopago, o valor total que ainda n�o foi pago neste mes
      {
        $naopago = ($naopago + $row["valor"]);
      }

      print $row["id_despesa"];
      $idteste2=$row["id_despesa"];  
      array_push($id_desp, $row["id_despesa"]);
      
      
     

      ?>
      <td><a href="#conteudo1" class= data-index="<?echo $idteste2?>"><img src='imagem/lapiz.jpg' width='32' height='32' border='0' alt='modificar'></a></td>
      <a target=_top href=http://localhost/orcamento/mostra_despesa_alterar.php?indice=".$row["id_despesa"].">". $row["despesa"]." 
                      </a>
      <?


      print ("<td><a href=". $row["id_despesa"] . " class= data-index=" . $idteste2 . "><img src='imagem/lapiz.jpg' width='32' height='32' border='0' alt='modificar'></a></td>");
      print ("<td><a href=" . $row["id_despesa"] . "><img src='imagem/lixeira.jpg' width='23' height='23' border='0' alt='excluir'></a></td>");
      print ("<td><button type='button' id='botaoModal' class='btn btn-primary botaoModal' data-toggle='modal' data-target='#modalAlterar' data-index=" . $idteste2 . ">
                                Abrir modal de " . $row["id_despesa"] . "
                            </button></td>");

    }
    //mysqli_free_result($result);


  }
  echo '</tbody></table>';
}




?>


<HTML>

<HEAD>
  <TITLE>Crud orcamento</TITLE>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="css/bootstrap-datepicker.css" rel="stylesheet" />-->
  <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>-->
  <script src="js/bootstrap-datepicker.min.js"></script>
  <script src="js/bootstrap-datepicker.pt-BR.min.js" charset="UTF-8"></script>

  <tr style="color: blue; font-size: xx-small">
    <!-- Arquivos CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Arquivos JavaScript do Bootstrap (incluindo jQuery) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</HEAD>

<BODY>
  <div class="modal fade bd-example-modal-xl" id='modalAlterar' tabindex="-1" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">

    <div id="conteudo1">
              <h2>Conteúdo 1</h2>
        <p><? echo $idteste2; ?> </p>
    </div>




















    <?



    $query = "SELECT $dbname.despesa.*,$dbname_aux.descricao.*
          FROM $dbname.despesa ,$dbname_aux.descricao
          WHERE $dbname.despesa.valido='S'
          AND $dbname.despesa.id_descricao=$dbname_aux.descricao.id_descricao
          AND $dbname.despesa.id_despesa=" . $idteste2;

    //print "$query";
// Executa a primeira query sql
    
    $result = mysqli_query($mysqli_connection, $query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    ?>

  

    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <!--///////////////////////////////////////////////////////////////-->
        <div class='modal-dialog modal-dialog-centered modal-lg' role='document'>
          <div class='modal-content'>

            <div class="modal-header">
              <h5 class="modal-title">Alterar/Excluir <? print $idteste2; ?></h5>
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
                      <input style='WIDTH: 180px' name=despesa value="<? echo $row["despesa"]; ?>" type="text"
                        class="form-control">
                    </div>

                  </div>

                  <!-- linha 1 coluna 2 -->
                  <div class="col-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Valor</span>
                      <input style='WIDTH: 80px' name='valor' value="<? echo $row["valor"]; ?>" type="text"
                        class="form-control">
                    </div>
                  </div>

                  <!-- linha 1 coluna 3 -->
                  <div class="col-4">
                    <div class="form-group input-group-prepend mb-0">
                      <span class="input-group-text">Data</span>
                      <div class="input-group date">
                        <input type='text' class="form-control" id="exemplo" name="data"
                          value="<? echo date("d/m/Y", (strtotime($row["data"]))); ?>">
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
                      <input style='WIDTH: 70px' name=parcela type="text" class="form-control"
                        value="<? echo $row["parcela"]; ?>">

                    </div>
                  </div>
                  <!-- linha 2 coluna 2 -->
                  <div class="col-4 ">
                    <div class="form-group input-group-prepend mb-0">
                      <span class="input-group-text">Vencimento</span>
                      <div class="input-group date">
                        <input type='text' class="form-control" id="exemplo3" name="vencimento"
                          value='<? echo date("d/m/Y", (strtotime($row["vencimento"]))); ?>'>
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
                        <input type='text' class="form-control" id="exemplo4" name="pago"
                          value='<? echo date("d/m/Y", (strtotime($row["pago"]))); ?>'>
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
                        <a href='<? echo $row["id_despesa"]; ?>'><i class="bi bi-save-fill"></i></a>
                      </button>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
        <!--///////////////////////////////////////////////////////////////-->
      </div>
    </div>
  </div>

  <div class="container pt-4">

    <div class="row">
      <div class="col-md-2">
        <div class='form-group'>
          <label for="datepicker">Mes e Ano: </label>
        </div>
      </div>

      <div class="col-md-2">
        <div class='form-group'>
          <input type="text" id="datepicker" class="form-control" placeholder="MM/YYYY">
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class='col-md-12' id="table-container">
          <!-- A tabela será atualizada aqui -->
        </div>
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

  <script>
    $(document).ready(function () {
      $('#datepicker').datepicker({
        format: "mm/yyyy",
        startView: "months",
        minViewMode: "months",
        language: "pt-BR",
        autoclose: true
      }).on('hide', function (e) {
        var date = $(this).val();

        let temp = date.split('/');
        date = "" + temp[1].substring(2) + "" + temp[0];
        //     $.ajax({
        //         url: './crud.php',
        //         type: 'POST',
        //         data: { buscaPHP: date },
        //         success: function (response) {
        //           console.log("sucesso")
        //           // $('#table-container').html(response);
        //           // $('#modalAlterar').click(function (event) {
        //           $('.botaoModal').on('click', function (event) {
        //             // var button = $(event.relatedTarget);
        //             // var index = button.data("index");

        //             var index = $(this).data('index')
        //             // var index = $('#modalAlterar').attr('')

        //             console.log(index);
        //           });
        //         },
        //         error: function (xhr, status, error) {
        //           console.error("Erro na requisição: " + error);
        //           $('#table-container').html('<div class="alert alert-danger">Erro ao carregar dados.</div>');
        //         }
        //     });
      });
    });
  </script>


</BODY>

</HTML>