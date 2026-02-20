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

<br>  <br>

<div class="container p-3 mb-2 bg-beige" style="padding-top: 15px; padding-bottom: 15px">

        <!-- <div class="p-3 mb-2 bg-info">  -->
         
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                    <button type="button" class="btn btn-primary">Inclui Despesa
                    <span class="badge badge-light">Inclui</span>
                    </button>
                    </div>
                </div>
             </div>




        <form action=grava_despesas.php method="POST" enctype="multipart/form-data" id=formulario  name=formulario onSubmit="return ValidaFormulario();">
            <!-- Linha 1 -->
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="despesa">Despesa</label>
                        <input type="text" class="form-control" id="despesa" placeholder="Digite Despesa" name="despesa" required>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="data">Data</label>
                        <div class="input-group date">
		                	<input type="text" class="form-control" id="exemplo" name="data" value=<?php echo valor_data(); // função que pega a data do dia?>>
				           <div class="input-group-addon">
                               <span class="glyphicon glyphicon-th"></span>
                           </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="valor">Valor</label>
                      <!-- <input type="text" class="form-control"  id="valor" placeholder="Digite valor" name="valor" oninput="formatarValor(this)" required> -->
                       <input type="number" class="form-control" name="valor" id="valor" step="0.01" placeholder="Digite valor" required> <!--formata o valor-->
                    </div>
                </div>
            </div>
            


   <!-- Linha 2 -->
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="ocorrencia">Ocorrencia</label>
                        <div class="input-group date">
		                	<input type="text" class="form-control" id="exemplo2" name="ocorrencia" value=<?php echo proximo_mes(); // função que pega o prox mes?>>
				           <div class="input-group-addon">
                               <span class="glyphicon glyphicon-th"></span>
                           </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="parcela" class="form-label">Parcelas</label>
                        <select class='form-control' aria-label='smal select example'  id="parcela" name="parcela">
                        <?php
                         for($i=1;$i<13;$i++)
                         { echo "<option value=".$i.">$i parcela(s)</option>"; }
                        ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="id_descricao">Descricao</label>
                         <?php
                        //****************** Obtem os tipos de despesas ************ -->
                         $result=obtem_dados_aux('descricao','id_descricao','asc') or  die (mysqli_error());
                         echo "<select class='form-control' aria-label='smal select example' name='id_descricao'>";
                         while ($linha = mysqli_fetch_array($result)) {echo "<option value=\"" . $linha[0] . "\">" . $linha[2] . "</option>";}
                         echo "</select>"; 
                        ?>
                     </div>
                </div>
            </div>

    <!-- Linha 3 -->
            <div class="row">         
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="id_categoria">Categoria</label>
                         <?php
                         //****************** Obtem os tipos de Categoria ************ -->
                         $result=obtem_dados_aux("categoria","nome_categoria","asc") or  die (mysql_error());
                         echo "<select class='form-control' aria-label='smal select example' name='categoria'>";
                         while ($linha = mysqli_fetch_array($result)) {echo "<option value=\"" . $linha[0] . "\">" . $linha[1] . "</option>";}
                         echo "</select>"; 
                         ?>
                    </div>
                </div>
               


                <div class="col-md-4">
                    <div class="form-group">
                      <label for="vencimento">Vencimento</label>
                        <div class="input-group date">
		                	<input type="text" class="form-control" id="exemplo3" placeholder="Digite vencimento" name="vencimento">
				           <div class="input-group-addon">
                               <span class="glyphicon glyphicon-th"></span>
                           </div>
                        </div>
                    </div>
                </div>





              
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="imagem">Download Imagem</label>
                        <input type="file" name="pdf" accept="application/pdf">
                        <!--<input type="file" name="pdf" accept="application/pdf" required>-->
                         <!--<input type="hidden" name="MAX_FILE_SIZE" value="99999999"/>
                        <div><input name="imagem" type="file"/></div>-->
                        <!--   <input type="text" class="form-control" id="campo1" placeholder="Digite Observacao" name="texto"> -->
                     </div>    
                </div> 
            </div>

     <!-- Linha 4 -->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="texto">Observacao</label>
                        <input type="text" class="form-control" id="campo1" placeholder="Digite Observacao" name="texto">
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
