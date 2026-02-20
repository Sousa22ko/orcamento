<!-- includes/scripts.php -->

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<!-- Bootstrap 3 JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- Datepicker JS -->
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="js/bootstrap-datepicker.pt-BR.min.js" charset="UTF-8"></script>

<!--Este script formata a ocorrencia, capturando o mes/ano para submeter este valor para salvamento em grava_receitas_new.php. 
     Ele está associado com o id="exemplo2" do input acima-->

<!-- Inicialização do datepicker -->
<script type="text/javascript">
      $('#exemplo').datepicker({
        format: "dd/mm/yyyy",
        language: "pt-BR",
        startDate: '-30d',
        autoclose: true,

      });
</script>

<script>
  $(document).ready(function () {
    $('#exemplo2').datepicker({
      format: "mm/yyyy",
      language: "pt-BR",
      startDate: '+0d',
      startView: 'months',
      minViewMode: 'months',
      autoclose: true
    });
  });
</script>

<script>
$(document).ready(function() {
    $('#exemplo4').datepicker({
        format: "mm/yyyy",
        startView: "months",
        minViewMode: "months",
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true
    });
});
</script>






<script type="text/javascript">
			$('#exemplo3').datepicker({
				format: "dd/mm/yyyy",
				language: "pt-BR",
				startDate: '-30d',
				autoclose: true,

			});
</script>



<script>
  $(document).ready(function(){
    $('#datepicker').datepicker({
      format: "mm/yyyy",
      startView: "months", 
      minViewMode: "months",
      language: "pt-BR",
      autoclose: true
    }).on('changeDate', function(e) {
      // Quando o usuário escolhe uma data, o formulário é enviado automaticamente
      $('#meuFormulario').submit();
    });
  });
</script>



        <!--Este script formata o valor colocando duas casas decimais no numero digitado. Ele está associado com o id="valor" do input acima-->
        <script>
                $(document).ready(function () {
                    $('#valor').on('input', function () {
                        let valor = $(this).val().replace(/[^0-9]/g, ''); // Remove tudo que não for número
                        
                        // Converte a string para um número e adiciona duas casas decimais
                        if (valor.length > 0) {
                            let numeroFormatado = (parseFloat(valor) / 100).toFixed(2);
                            $(this).val(numeroFormatado);
                        }
                    });
                });
        </script>