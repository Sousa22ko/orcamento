<!DOCTYPE html>
<html lang="pt-br">
<head>




    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="css/bootstrap-datepicker.css" rel="stylesheet"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="js/bootstrap-datepicker.min.js"></script>
		<script src="js/bootstrap-datepicker.pt-BR.min.js" charset="UTF-8"></script>


    <title>Orcamento</title>
</head>


<body>
<br>  <br>
  <div class="container pt-2">

  <form>
        <div class="form-row">
  
             <div class="form-group col-md-4">
               <input type="text" class="form-control" id="despesa" placeholder="Despesa">
             </div>

             <div class="form-group col-md-2">
                   <div class="input-group date">
		                	<input type="text" class="form-control" id="exemplo" >
				           <div class="input-group-addon">
                               <span class="glyphicon glyphicon-th"></span>
                           </div>
                    </div>
              </div>


              <div class="form-group col-md-2">
                    <input type="text" class="form-control" id="valor" placeholder="Valor">
              </div>
          </div>
          
          
  <div class="row">


  
       <div class="form-group col-md-4">

                      <div class="input-group date">
		                	<input type="text" class="form-control" id="exemplo2" >
				           <div class="input-group-addon">
                               <span class="glyphicon glyphicon-th"></span>
                           </div>
                      </div>

         </div>
    
    

  
  
        <div class="form-group col-md-2">
           <input type="text" class="form-control" id="parcela" placeholder="Quantas Parcelas">
        </div>
    
        <div class="form-group col-md-4">
                <select id="categoria" class="form-control" placeholder="Categoria">
                    <option selected>itau card.</option>
                    <option>...</option>
                </select>
        </div>
    
    
         <div class="form-group col-md-2">
              <input type="text" class="form-control" id="tipodespesa">
         </div>
    

    </div>
</div>
  </div>
  
  
  <div class="form-group">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="gridCheck">
        Clique em mim
      </label>
    </div>

  

  <div class="row g-3 align-items-center">
  <div class="col-auto">
    <label for="inputPassword6" class="col-form-label">Password</label>
  </div>
  <div class="col-auto">
    <input type="password" id="inputPassword6" class="form-control" aria-describedby="passwordHelpInline">
  </div>
  <div class="col-auto">
    <span id="passwordHelpInline" class="form-text">
      Must be 8-20 characters long.
    </span>
  </div>
</div>

 </div>








  
  <button type="submit" class="btn btn-primary">Entrar</button>
</form>



</div>



		<script type="text/javascript">
			$('#exemplo').datepicker({
				format: "dd/mm/yyyy",
				language: "pt-BR",
				startDate: '+0d',
				autoclose: true,

			});
		</script>


 		<script type="text/javascript">
			$('#exemplo2').datepicker({
				format: "mm/yyyy",
				language: "pt-BR",
				startDate: '+0d',
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
