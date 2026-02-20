<?php
//require("orcamento.inc");
require("functions.inc");
//require_once("config.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecionar Mês e Ano</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.pt-BR.min.js"></script>
    <style>
        .modal-dialog{
            max-width: 60% !important;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="my-4"></h2>
        <div class="form-group">
            <label for="mesAno"><strong>Mês e Ano Selecionado:</strong></label>
            <input type="text" class="form-control font-weight-bold" id="mesAno" name="mesAno" placeholder="Selecione o mês e ano" value=<?php echo proximo_mes(); // função que pega o prox mes?> >
        </div>
        
        <div id="tabelaDespesas" class="mt-4">
            <!-- A tabela de despesas será carregada aqui -->
        </div>
    </div>



<script>carregarPagina('http://localhost/menubootstrap/fundo.html')</script>

    <!-- Modal -->
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
                    <!-- <form action=grava_despesas_new.php method="POST" enctype="multipart/form-data" id=formulario  name=formulario> -->

                    <form id="editDespesaForm" method="POST" enctype="multipart/form-data">
                    <div class="container">

                        <div class="row">
                            <div class="col-9">
                                <div class="form-group">
                                    <label for="editDescricao">Despesa:</label>
                                    <input type="text" class="form-control" id="editDescricao" name="descricao">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="editData">Data:</label>
                                    <input type="text" class="form-control" id="editData" name="data">
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="editValor">Valor:</label>
                                    <input type="text" class="form-control" id="editValor" name="valor" oninput="formatarValor(this)">
                                </div>        
                            </div> 
                            <div class="col">
                                <div class="form-group">
                                    <label for="editValor_casa">Valor Total:</label>
                                    <input type="text" class="form-control" id="editValor_casa" name="valor_casa" oninput="formatarValor(this)">
                                </div>
                            </div>                 
                            <div class="col">
                                <div class="form-group">
                                    <label for="editParcela">Parcela:</label>
                                    <input type="text" class="form-control" id="editParcela" name="parcela">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="editOcorrencia">Ocorrencia:</label>
                                    <input type="text" class="form-control" id="editOcorrencia" name="ocorrencia">
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="editSelectDescricao">Descrição:</label>
                                    <!-- <input type="text" class="form-control" id="editSelectDescricao" name="descricao"> -->
                                    <div id="editSelectDescricao"></div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="editSelectCategoria">Categoria:</label>
                                    <!-- <input type="text" class="form-control" id="editSelectCategoria" name="categoria"> -->
                                    <div id="editSelectCategoria"></div>
                                </div>
                            </div> 
                            <div class="col">
                                <div class="form-group">
                                    <label for="editVencimento">Vencimento:</label>
                                    <input type="text" class="form-control" id="editVencimento" name="vencimento">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="editPago">Pago:</label>
                                    <input type="text" class="form-control" id="editPago" name="pago">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="editObs">Observação:</label>
                                    <input type="text" class="form-control" id="editObs" name="obs">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-2">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" >
                                    <label class="form-check-label" for="flexSwitchCheckDefault">Ativo</label>
                                </div>
                            </div>   

                            <div class="col-6">
                                <div class="form-group">
                                    <div id="pdfUploadSection" style="display:none;">
                                    <label for="pdfFile">Incluir novo arquivo PDF:</label>
                                    <input type="file" id="pdfFile" name="pdfFile" accept="application/pdf">
                                </div>
                            </div>
                        </div>
                      <!--   -->
                        
                            <div class="col-2">
                                <input type="hidden" id="despesaId" name="despesaId">
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="imagem">Arquivo PDF:</label>
                                    <!-- <img id='img'> -->
                                    <iframe id="pdfViewer" style="width:100%; height:500px;"></iframe>
                                </div>
                            </div> 
                        </div>

                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>






    <script>
        var id_despesa = undefined;
        var ocorrencia = undefined;
        var valorTotalCheckbox = 0;

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
                //url: 'get_despesas4.php',
                $.ajax({
                    url: 'get_despesas4.php',
                    type: 'GET',
                    data: { mesAno: selectedDate },
                    success: function(response) {
                        var resp = JSON.parse(response);
                        console.log(resp.subtotal)
                        
                        let totais = resp.subtotal;
                        let totaisNomeAbv = resp.nomeAbv;
                        
                        
                        $('#tabelaDespesas script').remove();
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
                                    // console.log(data)
                                    var despesa = JSON.parse(data);
                                    console.log(despesa)
                                    $('#editDescricao').val(despesa.despesa);
                                    $('#editValor').val(despesa.valor);
                                    $('#despesaId').val(despesa.id_despesa);
                                    $('#editParcela').val(despesa.parcela);
                                    $('#editOcorrencia').val(despesa.ocorrencia);
                                    $('#editSelectDescricao').html(resp.select[index]);
                                    $('#editSelectCategoria').html(resp.categoria[index]);
                                    $('#editData').val(dateFormat(despesa.data)); 
                                    $('#editValor').val(despesa.valor);
                                    $('#editParcela').val(despesa.parcela);
                                    $('#editVencimento').val(dateFormat(despesa.vencimento));
                                    $('#editPago').val(dateFormat(despesa.pago));
                                    $('#editObs').val(despesa.obs);
                                    $('#imagem').val(despesa.nome_imagem); /////////// novo
                                    $('#flexSwitchCheckDefault').prop('checked' , true)//(despesa.valido == "S" || despesa.valido == "s"))
                                    $('#pdfViewer').attr('src', URL.createObjectURL(b64toBlob(despesa.imagem)));
                                    $('#editValor_casa').val(despesa.valor_casa);


                                    // Verifica se há um PDF associado
                                    if (despesa.imagem && despesa.imagem.trim() !== "") {
                                        // Se houver, exibe no visualizador
                                        $('#pdfViewer').attr('src', 'data:application/pdf;base64,' + despesa.imagem);
                                        // Esconde a seção de upload, pois já existe um arquivo
                                        $("#pdfUploadSection").hide();
                                    } else {
                                        // Se não houver, limpa o visualizador e exibe o campo de upload
                                        $('#pdfViewer').attr('src', '');
                                        $("#pdfUploadSection").show();
                                    }

/**/

                                    // Exibe o modal
                                    $('#editDespesaModal').modal('show');
                                  //  $('#editDespesaModal').modal('show'); 


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
                console.log(event)

                var formData = new FormData();
                formData.append('id_despesa',   id_despesa)
                formData.append('despesa',  event.target[0].value)
                formData.append('data',  dateDesformat(event.target[1].value))
                formData.append('valor',  event.target[2].value.replace(',','.'))
                formData.append('valor_casa',  event.target[3].value.replace(',','.'))
                formData.append('ocorrencia',  ocorrencia)
                formData.append('parcela',  event.target[4].value)
                formData.append('ocorrencia',  event.target[5].value)
                formData.append('id_descricao',  event.target[6].value)
                formData.append('categoria',  event.target[7].value)
                formData.append('vencimento',  dateDesformat(event.target[8].value))
                formData.append('pago',  dateDesformat(event.target[9].value))
                formData.append('obs',  event.target[10].value)
                formData.append('valido',  event.target[11].checked ? 'S' : 'N')
                if(event.target[12] && event.target[12]?.files && event.target[12]?.files[0])
                    formData.append('pdf',  event.target[12]?.files[0])

                for (let pair of formData.entries()) {
                    console.log(pair[0] + ':', pair[1]);
                }

                // var despesa = {};

                // despesa.id_despesa =  id_despesa;
                // despesa.despesa = event.target[0].value;
                // despesa.data = dateDesformat(event.target[1].value);
                // despesa.valor = event.target[2].value.replace(',','.');
                // despesa.valor_casa = event.target[3].value.replace(',','.');
                // despesa.ocorrencia = ocorrencia;
                // despesa.parcela = event.target[4].value;
                // despesa.ocorrencia = event.target[5].value;
                // despesa.id_descricao = event.target[6].value;
                // despesa.categoria = event.target[7].value;
                // despesa.vencimento = dateDesformat(event.target[8].value);
                // despesa.pago = dateDesformat(event.target[9].value);
                // despesa.obs = event.target[10].value;                
                // despesa.valido = event.target[11].checked ? 'S' : 'N';
                // despesa.pdf = event.target[12].files[0];
                // despesa.pdf.tmp_name = event.target[12].value
                

                // console.log('despesa', despesa);
            //    console.log(event)

                 $.ajax({
                     url: 'save_despesa2.php',
                     type: 'POST',
                     data: formData,
                     processData: false,
                     contentType: false,
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

        // converte base64 em blob
        function b64toBlob(b64Data, contentType = 'application/pdf', sliceSize = 512) {
            const byteCharacters = atob(b64Data);
            const byteArrays = [];

            for (let offset = 0; offset < byteCharacters.length; offset += sliceSize) {
                const slice = byteCharacters.slice(offset, offset + sliceSize);
                const byteNumbers = new Array(slice.length);
                for (let i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
                }
                byteArrays.push(new Uint8Array(byteNumbers));
            }

            return new Blob(byteArrays, { type: contentType });
            }

    </script>


<!-- script que coloca uma mascara no campo Valor, para colocar o "." na casa decimal-->
    <script>
        $(document).ready(function () {
            $('#editValor').on('input', function () {
                let valor = $(this).val().replace(/[^0-9]/g, ''); // Remove tudo que não for número
                
                // Converte a string para um número e adiciona duas casas decimais
                if (valor.length > 0) {
                    let numeroFormatado = (parseFloat(valor) / 100).toFixed(2);
                    $(this).val(numeroFormatado);
                }
            });
        });
    </script>




<!-- script que coloca uma mascara no campo Valor_casa, para colocar o "." na casa decimal-->
    <script>
        $(document).ready(function () {
            $('#editValor_casa').on('input', function () {
                let valor = $(this).val().replace(/[^0-9]/g, ''); // Remove tudo que não for número
                
                // Converte a string para um número e adiciona duas casas decimais
                if (valor.length > 0) {
                    let numeroFormatado = (parseFloat(valor) / 100).toFixed(2);
                    $(this).val(numeroFormatado);
                }
            });
        });
    </script>

   






</body>
</html>
