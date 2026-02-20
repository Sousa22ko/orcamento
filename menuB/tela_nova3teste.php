<?php header("Content-Type: text/html; charset=UTF-8", true);

require_once("functions.inc");
require_once("config.php");

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecionar Mês e Ano</title>

    <!-- jQuery ok -->    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <!-- Bootstrap 3 CSS ok -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Bootstrap 3 JS ok -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Bootstrap Datepicker CSS ok -->
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
        
    <!-- Datepicker JS -->
    <script src="js/bootstrap-datepicker.min.js"></script>
    <script src="js/bootstrap-datepicker.pt-BR.min.js" charset="UTF-8"></script>

    <!-- Seu CSS (opcional) ok -->
    <link rel="stylesheet" href="./styles.css">

    <style>
        body {
            overflow-y: auto;
        }


        .small-font {
            font-size: 42px;
        }
      
        </style>




</head>
<body>


<div class="container" style="margin-top: 10px;">

    <div class="form-group">
        <label for="exemplo4" class="font-size: 38px;">Selecionar Mês e Ano:</label>
        <div class="input-group date col-sm-3">
            <input type="text" class="form-control" id="mesAno" name="mesAno" placeholder="Selecione o mês e ano">
            <div class="input-group-addon">
                <span class="glyphicon glyphicon-th col-sm-2"></span>
            </div>
        </div>
    </div>






        <div id="tabelaDespesas" class="mt-4"> 
            <!-- A tabela de despesas será carregada aqui -->
        </div>
        <div class="total">
            <div class="container totalContainer">
            </div>
        </div>
    </div>






    <!-- Modal 
    <div class="modal fade" id="editDespesaModal" tabindex="-1" role="dialog" aria-labelledby="editDespesaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDespesaModalLabel">Editar Despesa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editDespesaForm">

                        <div class="form-group">
                            <label for="editDescricao">Despesa:</label>
                            <input type="text" class="form-control" id="editDescricao" name="descricao">
                        </div>

                        <div class="form-group">
                            <label for="editValor">Valor:</label>
                            <input type="text" class="form-control" id="editValor" name="valor">
                        </div>


                        <div class="form-group">
                            <label for="editData">Data:</label>
                            <input type="text" class="form-control" id="editData" name="data">
                        </div>

                        <div class="form-group">
                            <label for="editParcela">Parcela:</label>
                            <input type="text" class="form-control" id="editParcela" name="parcela">
                        </div>

                        
                        <div class="form-group">
                            <label for="editSelectDescricao">Descrição:</label>
                          
                            <input type="text" class="form-control" id="editSelectDescricao" name="descricao"> 
                            <div id="editSelectDescricao"></div>
                        </div>


                        <div class="form-group">
                            <label for="editSelectCategoria">Categoria:</label>
                             <input type="text" class="form-control" id="editSelectCategoria" name="categoria"> 
                            <div id="editSelectCategoria"></div>
                        </div>


                        <div class="form-group">
                            <label for="editVencimento">Vencimento:</label>
                            <input type="text" class="form-control" id="editVencimento" name="vencimento">
                        </div>

                        <div class="form-group">
                            <label for="editPago">Pago:</label>
                            <input type="text" class="form-control" id="editPago" name="pago">
                        </div>


                        <div class="form-group">
                            <label for="editObs">Obs:</label>
                            <input type="text" class="form-control" id="editObs" name="obs">
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" >
                            <label class="form-check-label" for="flexSwitchCheckDefault">Ativo</label>
                        </div>



                        <input type="hidden" id="despesaId" name="despesaId">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    
    
    
    <script>
        var id_despesa = undefined;
        var ocorrencia = undefined;
        
        $(document).ready(function(){
            $('#mesAno').datepicker({
                format: "mm/yyyy",
                startView: "months",
                minViewMode: "months",
                language: "pt-BR",
                autoclose: true,
                todayHighlight: true
            }).on('changeDate', function(e) {
                var selectedDate = $('#mesAno').val();

                let temp = selectedDate.split('/');
                selectedDate = "" + temp[1].substring(2) + "" + temp[0];
                ocorrencia = selectedDate;
                
                let dataNova = "" + temp[1].substring(2) + "" + temp[0];
                
                console.log(dataNova)
                
                $.ajax({
                    url: 'get_despesas3.php',
                    type: 'GET',
                    data: { mesAno: selectedDate },
                    success: function(response) {
                        var resp = JSON.parse(response);
                        console.log(resp)

                        let totais = resp.subtotal;
                        let totaisNomeAbv = resp.nomeAbv;
                        // for(let total in totais) {
                            //     let row = document.createElement('div');
                            //     row.classList.add('row')
                            //     let div = document.createElement('div');
                            //     div.classList.add('col-3');
                            //     div.appendChild(document.createTextNode(totaisNomeAbv[total] != undefined? totaisNomeAbv[total] : 'Total'));
                            //     let div2 = document.createElement('div');
                            //     div2.classList.add('col-9');
                            //     div2.appendChild(document.createTextNode(totais[total]));
                            
                            //     row.appendChild(div);
                            //     row.appendChild(div2)
                            
                            //     $('.totalContainer').append(row);
                            //     // $('.totalrow').append(div);
                            //     // $('.totalrow').append(div2);
                            //}
                            
                            
                            $('#tabelaDespesas').html(resp.tabela);
                            // Adicionar o evento de clique para os botões de editar
                            $('.btn-edit').on('click', function() {
                            var despesaId = $(this).data('id');
                            var index = $(this).data('index');
                            id_despesa = despesaId;
                            // Aqui fazemos a requisição para obter os dados da despesa
                            $.ajax({
                                url: 'get_despesa2.php',
                                type: 'GET',
                                data: { id: despesaId },
                                success: function(data) {
                                    var despesa = JSON.parse(data);
                                    console.log(despesa)
                                    $('#editDescricao').val(despesa.despesa);
                                    $('#editValor').val(despesa.valor);
                                    $('#despesaId').val(despesa.id_despesa);
                                    $('#editParcela').val(despesa.parcela);
                                    $('#editSelectDescricao').html(resp.select[index]);
                                    $('#editSelectCategoria').html(resp.categoria[index]);
                                    $('#editData').val(dateFormat(despesa.data)); 
                                    $('#editValor').val(despesa.valor);
                                    $('#editParcela').val(despesa.parcela);
                                    $('#editVencimento').val(dateFormat(despesa.vencimento));
                                    $('#editPago').val(dateFormat(despesa.pago));
                                    $('#editObs').val(despesa.obs);
                                    $('#flexSwitchCheckDefault').prop('checked' , despesa.valido == "S")
                                    
                                    $('#editDespesaModal').modal('show');
                                }
                            });
                        });
                    },
                    error: function() {
                        $('#tabelaDespesas').html('<p>Ocorreu um erro ao carregar as despesas.</p>');
                    }
                });
            });
            
            $('#editDespesaForm').on('submit', (event) => {
                event.preventDefault();
                var despesa = {};

                despesa.id_despesa =  id_despesa;
                despesa.despesa = event.target[0].value;
                despesa.valor = event.target[1].value;
                
                despesa.ocorrencia = ocorrencia;
                despesa.data = dateDesformat(event.target[2].value);
                despesa.parcela = event.target[3].value;
                despesa.id_descricao = event.target[4].value;
                despesa.categoria = event.target[5].value;
                despesa.vencimento = dateDesformat(event.target[6].value);
                despesa.pago = dateDesformat(event.target[7].value);
                despesa.obs = event.target[8].value;
                
                despesa.valor_casa = '';
                despesa.valido = event.target[9].checked ? 'S' : 'N';
                
                console.log('despesa', despesa);
                
                $.ajax({
                    url: 'save_despesa2.php',
                    type: 'POST',
                    data: despesa,
                    success: (result) => {
                        console.log(result)
                        alert(result);
                        $('#editDespesaModal').modal('hide');
                        $('#mesAno').datepicker('update');
                    },
                    error: () => {
                        
                }
            })
        })
    });
    
    function dateFormat(date) {
        let datasplit = date.split('-')
        return `${datasplit[2]}/${datasplit[1]}/${datasplit[0]}`;
    }
    
    function dateDesformat(date) {
        let datasplit = date.split('/');
        return `${datasplit[2]}-${datasplit[1]}-${datasplit[0]}`;
    }
    
</script>

-->








  <!-- Scripts agrupados -->
  <?php include("includes/scripts.php"); ?>

</body>
</html>