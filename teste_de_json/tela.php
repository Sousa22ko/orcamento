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
                    
<!-- Modal -->
<div class="modal fade" id="modalEditar" tabindex="-1">
                 
      
                                            
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
                                    <label for="edit_despesa">Despesa:</label>
                                    <input type="text" class="form-control" id="edit_despesa" name="despesa">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="edit_data">Data:</label>
                                    <input type="text" class="form-control" id="edit_data" name="data">
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="edit_valor">Valor:</label>
                                    <input type="text" class="form-control" id="edit_valor" name="valor" oninput="formatarValor(this)">
                                </div>        
                            </div> 
                            <div class="col">
                                <div class="form-group">
                                    <label for="edit_valor_casa">Valor Total:</label>
                                    <input type="text" class="form-control" id="edit_valor_casa" name="valor_casa" oninput="formatarValor(this)">
                                </div>
                            </div>                 
                            <div class="col">
                                <div class="form-group">
                                    <label for="edit_parcela">Parcela:</label>
                                    <input type="text" class="form-control" id="edit_parcela" name="parcela">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="edit_ocorrencia">Ocorrencia:</label>
                                    <input type="text" class="form-control" id="edit_ocorrencia" name="ocorrencia">
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="editSelectDescricao">Descrição:</label>
                                    <div id="editSelectDescricao"></div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="editSelectCategoria">Categoria:</label>
                                    <div id="editSelectCategoria"></div>
                                </div>
                            </div> 
                            <div class="col">
                                <div class="form-group">
                                    <label for="edit_vencimento">Vencimento:</label>
                                    <input type="text" class="form-control" id="edit_vencimento" name="vencimento">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="edit_pago">Pago:</label>
                                    <input type="text" class="form-control" id="edit_pago" name="pago">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="edit_obs">Observação:</label>
                                    <input type="text" class="form-control" id="edit_obs" name="obs">
                                </div>
                            </div>
                        </div>

<!--

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
                        
                        
                            <div class="col-2">
                                <input type="hidden" id="edit_id" name="edit_id">
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="imagem">Arquivo PDF:</label>
-->   <!-- <img id='img'> -->
                                  <!--  <iframe id="pdfViewer" style="width:100%; height:500px;"></iframe>
                                </div>
                            </div> 
                        </div>
 -->


                    </div>
                  <!--  </form> -->
                </div>
            </div>
        </div>
      </div> <!---->



                    </body>
                    </html>