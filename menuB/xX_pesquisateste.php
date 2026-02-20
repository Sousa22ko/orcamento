<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="css/bootstrap-datepicker.css" rel="stylesheet"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="js/bootstrap-datepicker.min.js"></script>
		<script src="js/bootstrap-datepicker.pt-BR.min.js" charset="UTF-8"></script>


  <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="ocorrencia">Ocorrencia</label>
                         <div class="input-group date">
		                	<input type="text" class="form-control" id="exemplo2" name="ocorrencia" >
				           <div class="input-group-addon">
                               <span class="glyphicon glyphicon-th"></span>
                           </div>
                      </div>
                    </div>
                </div>


   <div class="row" id="testePHP"> valor: </div>


<!--
<script type="text/javascript">
    const datepicker = document.querySelector('#exemplo2');
    datepicker.addEventListener('onClose', () => {
         console.log(datepicker.value);
    })
</script>
-->
  		<script type="text/javascript">
        var busca;
			$('#exemplo2').datepicker({
				format: "mm/yyyy",
				language: "pt-BR",
				startDate: '+0d',
				startView: 'months',
				minViewMode: 'months',
				autoclose: true,
			}).on('changeDate', (event) => {
			busca = event.format();
			let temp = busca.split('/');
            busca = "" +temp[1].substring(2)+""+ temp[0];
            $('#testePHP').load('pesquisateste.php', {"postPHP": busca})
               console.log(busca);
               $.ajax({
               url:'crud.php',
               type: 'POST',
               data: {
               buscaPHP: busca,
               action: 'process'
               }
               })
            });

		</script>

       <?php
         $data = $_POST['postPHP'];
         echo '<p>'.$data. '</P>' ;
       ?>

