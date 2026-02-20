<?php
//require("orcamento.inc");
require("functions.inc");
//require_once("config.php");
?>


<!DOCTYPE html>
<head lang="pt-br">
<head>
<style>
  /* Estilo para centralizar o container */
  .custom-container {
    max-width: 600px; /* Largura máxima desejada */
    margin: 0 auto; /* Margem automática para centralizar */
    background-color: #f0f0f0; /* Cor de fundo para visualização */
    padding: 20px; /* Espaçamento interno opcional */
  }
</style>
</head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="css/bootstrap-datepicker.css" rel="stylesheet"/>
        <link rel="stylesheet" href="./styles.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="js/bootstrap-datepicker.min.js"></script>
		<script src="js/bootstrap-datepicker.pt-BR.min.js" charset="UTF-8"></script>
    <title>Registrar Pagamentos</title>
</head>


<body>
<br>  <br>
<div class="container custom-container bg-beige">
                
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                    <button type="button" class="btn btn-primary">Registrar Pagamentos
                    <span class="badge badge-light">Registrar</span>
                    </button>
                    </div>
                </div>
             </div>

        <!--<form action=grava_desp2.php id=formulario method=post name=formulario onSubmit="return ValidaFormulario();"> -->
        <form action=registra_pagamentos.php id=formulario method=post name=formulario onSubmit="return ValidaFormulario();">
           
        
        <!-- Linha 1 -->
            <div class="row">            
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="ocorrencia">Ocorrencia</label>
                         <div class="input-group date">
		                <!--	<input type="text" class="form-control" id="exemplo2" name="ocorrencia" > -->
                            <input type="text" class="form-control" id="exemplo2" name="ocorrencia" value=<?php echo este_mes(); // função que pega o prox mes?>>
				           <div class="input-group-addon">
                               <span class="glyphicon glyphicon-th"></span>
                           </div>
                      </div>
                    </div>
                </div>
           

            
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="data">Data do Pagamento</label>
                        <div class="input-group date">
		                	<!-- <input type="text" class="form-control" id="exemplo" name="data" value=<? echo $valor_data; ?>> -->
                            <input type="text" class="form-control" id="exemplo" name="data" value=<?php echo valor_data(); // função que pega a data do dia?>>
				           <div class="input-group-addon">
                               <span class="glyphicon glyphicon-th"></span>
                           </div>
                      </div>
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


     <!-- Linha 4 -->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="texto"></label>
                         <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </div>
            </div>

        </form>
</div>




		<script type="text/javascript">
			$('#exemplo').datepicker({
				format: "dd/mm/yyyy",
				language: "pt-BR",
				startDate: '-60d',
				autoclose: true,

			});
		</script>


 		<script type="text/javascript">
			$('#exemplo2').datepicker({
				format: "mm/yyyy",
				language: "pt-BR",
				startDate: '-60d',
				startView: 'months',
				minViewMode: 'months',
				autoclose: true,
			});
		</script>




      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



  

</body>
</html>
