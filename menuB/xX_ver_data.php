<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>data</title>

     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
     <link href="http://localhost/menubootstrap/css/bootstrap-datepicker.css" rel="stylesheet">
     <script src="hhttp://localhost/menubootstrap/js/bootstrap-datepicker.min.js"></script>
      <script src="http://localhost/menubootstrap/js/bootstrap-datepicker.pt-BR.min.js"></script>
     
     
     
  </head>
  <body>

<div class="container">

  <form>
  <fieldset disabled>
    <legend>datapicker</legend>
    
    <div class="mb-3">
      <label for="disabledTextInput" class="form-label">data</label>


      <div class="input-group date" data-provide="datepicker">
      <input >
            <input type="text" class="form-control" id="exemplo">

           <div class="input-group-addon">
              <span class="glyphicon glyphicon-th"></span>
             </div>
    
       </div>
      
    </div>
    

    <button type="submit" class="btn btn-primary">enviar</button>
  </fieldset>
</form>

</div>

    <script type="text/javascript">
     $('#exemplo').datepicker({
    format: 'dd/mm/yyyy'
});
  </script>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

















  </body>
</html>

