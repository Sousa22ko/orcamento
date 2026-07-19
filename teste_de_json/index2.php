<?php
session_start();
$_SESSION['userr_id'] = 1;
$arraySelect = [];
$arrayCategoria = [];
?>

<!DOCTYPE html>
<html lang="pt-br">


<head>
<meta charset="UTF-8">
<title>Teste AJAX</title>

<!-- jQuery (já está ok, pode manter o seu) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css">

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js"></script>

<!-- Bootstrap Datepicker -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<!-- Idioma PT-BR -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.pt-BR.min.js"></script>


<head>
<style>
/* (mantive seu CSS original) */
body {
    font-family: Arial, sans-serif;
    background: #e4fccb;
}


.balao {
    background: #d7e7b9;
    border: 1px solid #000;
    border-radius: 14px;
    padding: 14px;
    margin-bottom: 20px;
    box-shadow: 4px 4px 0 #000;
}

.balao-titulo {
    font-size: 18px;
    font-weight: bold;
    border-bottom: 1px solid #000;
    padding-bottom: 6px;
    margin-bottom: 10px;
}


.balao-linha {
    display: grid;
    grid-template-columns:
        300px
        30px
        110px
        110px
        110px
        150px
        140px
        100px
        80px;
    gap: 6px;
    padding: 6px 0;
    border-bottom: 1px dotted #999;
    align-items: center;
    text-align: center;
}

.balao-linha2 {
    display: grid;
      grid-template-columns:
      3.5fr 1.5fr 3.5fr 1.5fr ;
      gap: 6px;
    padding: 6px 0px;
    border-bottom: 1px dotted #999;
    align-items: center;
    text-align: left;
}

.balao-linha3 {
    display: grid;
    grid-template-columns:
        2.5fr 0.5fr 1fr 1fr 1fr 1fr 1.5fr 1.5fr 1fr 1fr;
    gap: 10px;
    padding: 6px 0;
    border-bottom: 1px dotted #999;
    align-items: center;
    text-align: center;
}

.balao-linha3old {
    display: grid;
    grid-template-columns:
        400px
        100px
        400px
        100px
        1px
        7px
        1px
        1px
        8px;
    gap: 50px;
    padding: 6px 0;
    border-bottom: 1px dotted #999;
    align-items: center;
    text-align: left;
}


.balao-linha:last-child {
    border-bottom: none;
    align-items: right;
}

.balao-total {
    margin-top: 10px;
    padding-top: 8px;
    border-top: 1px solid #000;
    font-weight: bold;
    text-align: right;
}

.balao-total_Brasilia {
    margin-top: 10px;
    padding-top: 8px;
    border-top: 1px solid #000;
    font-weight: bold;   
    text-align: left;
}


.despesa { text-align: left; font: 1.0em sans-serif; }
.valor { text-align: right; font: 1.0em sans-serif; }
.pago { color: green; font-weight: bold; }
.nao-pago { color: red; font-weight: bold; }

/* Estilo para o input que ativa o datepicker */
#exemplo4 {
    font-family: 'Roboto', sans-serif;
    font-size: 15px;
    border-radius: 8px;
    border: 1px solid #ccc;
    padding: 8px 12px;
}


.diferenca-positiva {
    color: green;
    font-weight: bold;
}

.diferenca-negativa {
    color: red;
    font-weight: bold;
}

.btn-editar {
    padding: 4px 8px;
    border-radius: 6px;
    border: 1px solid #000;
    background: #ddd;
    cursor: pointer;
}

#totalMarcado {
    position: fixed;
    bottom: 450px;
    right: 1080px;
    background-color: #886161;
    color: white;
    padding: 6px 18px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: bold;
    box-shadow: 0 4px 6px rgba(0,0,0,.2);
}

/* Estilo do campo flutuante fixo */
#campo-flutuante {
    position: fixed;
    bottom: 450px;
    right: 1160px;
    background-color: rgb(66, 38, 0);
    color: white;
    padding: 5px 20px;
    border-radius: 8px;
    font-size: 17px;
    font-weight: bold;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}

.parcela-destaque {
    color: red;
    font-weight: bold;
}

    .com-espaco {
        margin-top: 10px; /* Cria 50px de espaço acima desta div */
    }


</style>
</head>



<body>
    
    
    
    <h2>Buscar despesas</h2>
    <div class="container">
        <div class="row">
            <div class="col-sm-2 col-sm-offset-1">
                <div class="input-group date">
                    <input type="text" class="form-control datepicker" id="ocorrencia" name="ocorrencia" placeholder="Selecione o mês e ano">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
        </div>
        
        <div id='user_id' style='display:none;'>   
            
        <input type="hidden"
       id="userr_id"
       name="userr_id"
       value="<?php echo $_SESSION['userr_id']; ?>">



<!--

            //<input type="hidden" id="userr_id" name="userr_id" value=2>  Substitua '1' pelo ID do usuário real -->
        </div>
        
        
        <!--<button onclick="buscar()">Buscar</button>  --><!-- (removi o botão, pois a busca agora é automática ao selecionar a data) -->
        <!-- Resultado da busca -->
        <div id="resultado"></div>
        
        <div id='campo-flutuante'>
            <span id='total'>Total: R$ 0,00</span>
        </div>


</div>



<script> 
    
    <!-- 🔹 CONFIGURAÇÃO DO DATEPICKER PARA SELEÇÃO DE MÊS/ANO -->
    $(document).ready(function(){
        
        $('#ocorrencia').datepicker({
            format: 'yymm',
            language: 'pt-BR',
            autoclose: true,
            todayHighlight: true,
            minViewMode: 1
        }).on('changeDate', function(e) {
            // pega o valor escolhido
            let ocorrencia = $('#ocorrencia').val().replace('-', '');
            console.log("Selecionado:", ocorrencia); 
            let userr_id = $('#userr_id').val();           
            // chama a busca automaticamente
            buscar();
        });
        
    });
    

    
    
    chrome.runtime.onMessage.addListener((message, sender, sendResponse) => {
      if (message.type === 'GET_DATA') {
        handleAsyncData(message).then(data => {
          sendResponse({ success: true, data });
        }).catch(error => {
          sendResponse({ success: false, error: error.message });
        });
        return true; // Keep channel open for the async sendResponse above
      }
      // Return false (default) if you don't intend to send a response
    });
    



function converterDataParaMySQL(dataBR) {
    if (!dataBR) return '';

    let partes = dataBR.split('/');
    return partes[2] + '-' + partes[1] + '-' + partes[0];
}




function buscar() {

    let ocorrencia = $('#ocorrencia').val();
    let userr_id = $('#userr_id').val();

    console.log("ocorrencia:", ocorrencia);
    console.log("userr_id:", userr_id);

    let ano = ocorrencia.substring(0,2);
    let mes = ocorrencia.substring(2,4);

    let html = '';
    let descricaoAtual = null;
    let descricaoNome  = '';
    let subtotalDescricao = 0;

    let totalBrasilia = 0;
    let totalVA = 0;
    let totalNatal = 0;
    let totalGeral = 0;
    let restapagarBR = 0;
    let restapagar = 0;

    let idsIgnorados = [34,35,36,37]; // IDs de descrição que representam despesas de Brasília que não são VA
    
    let meses = {
        "01": "Janeiro","02": "Fevereiro","03": "Março","04": "Abril",
        "05": "Maio","06": "Junho","07": "Julho","08": "Agosto",
        "09": "Setembro","10": "Outubro","11": "Novembro","12": "Dezembro"
    };

    <!-- 🔹 LIMPA TOTAL ANTERIOR -->
    $('#total').text("Total: R$ 0,00");
    <!-- 🔹 REQUISIÇÃO AJAX PARA BUSCAR DADOS -->
    $.ajax({
        url: 'buscar_dados2.php',
        type: 'GET',
           data: {
            ocorrencia: ocorrencia,
            userr_id: userr_id

        },
        dataType: 'json',

        success: function(response) {

            if (!response.sucesso) {
                $('#resultado').html('Erro ao buscar dados');
                return;
            }

            let salario = parseFloat(response.salario) || 0;

            response.dados.forEach(function(item){

                
                let id = parseInt(item.id_descricao) || 0;
                let valor = parseFloat(item.valor) || 0;
                let ignorar = idsIgnorados.includes(id);
                let usuario = item.user_name || 'Desconecido';             
          



                // 🔹 FECHA grupo anterior
                if (descricaoAtual !== null && descricaoAtual != id) {
                    html += `
                        <div class="balao-total">
                            Total ${descricaoNome} → R$ ${subtotalDescricao.toFixed(2)}
                        </div>
                    </div>`;
                    subtotalDescricao = 0;
                }

                // 🔹 ABRE novo grupo
                if (descricaoAtual != id) {
                    html += `             
 
                    <div class="balao">                    

                        <div class="balao-titulo">
                            ${item.descricao_abreviada}
                        </div>

                        <div class="balao-linha3">
                            <div class='despesa' style='text-align: left;'><strong>Despesa</strong></div>
                            <div style='text-align: center'><strong>Check</strong></div>
                            <div style='text-align: left;'><strong>Valor</strong></div>
                            <div style='text-align: left;'><strong>Val.Total</strong></div>
                            <div><strong>Data</strong></div>
                            <div><strong>Parcela</strong></div>
                            <div class='despesa' style='text-align: left;'><strong>Categoria</strong></div>
                            <div style='text-align: left;'><strong>Vence</strong></div>
                            <div style='text-align: left;><strong>Status</strong></div>
                            <div style='text-align: left;><strong>Ação</strong></div>
                        </div> 
                    `;
                    descricaoAtual = id;
                    descricaoNome = item.descricao_abreviada;
                }

                // 🔹 SOMATÓRIOS
                if (ignorar) {
                    totalBrasilia += valor;
                    if (item.pago === '2001-01-01') {
                        restapagarBR += valor;
                    }
                }

                if (id === 33) {
                    totalVA += valor;
                }

                if (!ignorar) {
                    totalGeral += valor;
                }

                if (id <= 32) {
                    totalNatal += valor;
                    if (item.pago === '2001-01-01') {
                        restapagar += valor;
                    }
                }

                // 🔹 LINHA
                html += `
                <div class="balao-linha3">
                    
                    <div class="despesa" style='text-align: left'>${item.despesa}</div>
                    <div class="despesa" style='text-align: left'><input type="checkbox" class="check" data-valor="${valor}"></div>
                    <div class="valor" style='text-align: center'>R$ ${formatarMoeda(valor)}</div>
                    <div class="valor" style='text-align: center'>R$ ${formatarMoeda(item.valor_casa)}</div>
                    <div class="despesa">${formatarData(item.data)}</div>
                    <div class="despesa" style='text-align: center'>${parcela_func(item.parcela)}</div>
                    <div class="despesa">${item.nome_categoria}</div>
                    <div class="despesa">${formatarData(item.vencimento)}</div>
                    <div class="despesa">${status(item)}</div>
                    <div class="despesa">
                         <button type="button" class="btn btn-xs btn-primary btn-editar" data-id="${item.id_despesa}">Editar</button>
                    </div> 
                    

                </div>
                `;

                subtotalDescricao += valor;
            });

            // 🔹 FECHA ÚLTIMO GRUPO
            if (descricaoAtual !== null) {
                html += `
                    <div class="balao-total">
                        Total ${descricaoNome} → R$ ${subtotalDescricao.toFixed(2)}
                    </div>
                </div>`;
            }
            
            let tdifVA = totalBrasilia - totalVA;


            <!-- 🔹 RESUMO FINAL  TOTAIS FINAIS -->            
            html += `  
                <div class="balao">
                    <div class="balao-titulo">Referente ao mês de ${meses[mes]} de 20${ano}</div>

                    <div class="balao-linha2">
                        <div><strong>BRASILIA</strong></div>
                        <div class='despesa' style='text-align: right;'><strong>Valor</strong></div>    
                        <div><strong>NATAL</strong></div>
                        <div class='despesa' style='text-align: right;'><strong>Valor</strong></div>
                    </div>

                    <div class="balao-linha2">
                        <div>Resta pagar →</div>
                        <div class='despesa' style='text-align: right;'><strong>R$ ${formatarMoeda(restapagarBR)}</strong></div>   
                        <div>Resta pagar →</div>
                        <div class='despesa' style='text-align: right;'><strong>R$ ${formatarMoeda(restapagar)}</strong></div>       
                    </div>

                    <div class="balao-linha2">
                        <div>Total Despesa → (Aluguel + Cond + Luz + Agua)</div>
                        <div class='despesa' style='text-align: right;'><strong>R$ ${formatarMoeda(totalBrasilia)}</strong></div>
                        <div>Total Despesa → Desp Natal + VA</div>
                        <div class='despesa' style='text-align: right;'><strong>R$ ${formatarMoeda(totalGeral)}</strong></div>       
                    </div>

                    <div class="balao-linha2">
                        <div>Gastos com VA em Natal →</div>
                        <div class='despesa' style='text-align: right;'><strong>R$ ${formatarMoeda(totalVA)}</strong></div>
                        <div>Salário mês →</div>
                        <div class='despesa' style='text-align: right;'><strong>R$ ${formatarMoeda(salario)}</strong></div>       
                    </div>
                    

                    <div class="balao-linha2">                    
                        <!-- -------- STATUS DE CREDITO/DEBITO DE BRASILIA -------- 
                        // calcula a diferença entre o que VA gastou em Natal e o que foi gasto em Brasília (desconsiderando os itens de Brasília que não são VA)-->
                        <div>TDif VA - DespBR → ${formatarMoeda(totalBrasilia)}-${formatarMoeda(totalVA)}</div>
                        <div class='despesa' style='text-align: right;'><strong>${dif(totalBrasilia, totalVA)}</strong></div>
                        <div>Saldo →</div>
                        <div class='despesa' style='text-align: right;'><strong>${dif(salario, totalGeral)}</strong></div>      
                    </div>       
                </div>   
                       
            `;

            $('#resultado').html(html);
        }
    });
}


<!-- 🔹 FUNÇÃO PARA CALCULAR DIFERENÇA E FORMATAR COM COR VERDE/VERMELHO -->
function dif(valor1, valor2) {
    let diferenca = (parseFloat(valor1) || 0) - (parseFloat(valor2) || 0);
    let valorFormatado = diferenca.toLocaleString('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
    return diferenca < 0
        ? `<span class="diferenca-negativa">R$ ${valorFormatado}</span>`
        : `<span class="diferenca-positiva">R$ ${valorFormatado}</span>`;
}

<!-- 🔹 FUNÇÃO PARA FORMATAR VALOR NO INPUT (CORRETO PARA AJAX) -->
function formatarMoeda(valor) {
    return (parseFloat(valor) || 0).toLocaleString('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

<!-- 🔹 FUNÇÃO PARA TRATAR VALOR DO INPUT (CORRETO PARA AJAX) -->
function moedaParaBanco(valor) {
    if (!valor) return 0;

    return valor
        .replace(/\./g, '')   // remove milhar
        .replace(',', '.');   // decimal
}

<!-- 🔹 FUNÇÃO PARA FORMATAR VALOR VINDO DO BANCO PARA EXIBIÇÃO (CORRETO PARA AJAX) -->
function formatarMoedaBancoParaTela(valor) {
    return parseFloat(valor || 0).toLocaleString('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}



<!-- 🔹 FUNÇÃO PARA FORMATAR DATA (CORRETO PARA AJAX) -->
function formatarData(data) {
    if (!data || data === '0000-00-00' || data === '2001-01-01') return '';

    let partes = data.split('-');
    return partes[2] + '/' + partes[1] + '/' + partes[0];
}

<!-- 🔹 FUNÇÃO PARA EXIBIR STATUS DE PAGAMENTO (CORRETO PARA AJAX) -->
function status(item) {
    return (!item.pago || item.pago === '2001-01-01')
        ? "<span class='nao-pago'>N Pago</span>"
        : "<span class='pago'>Pago</span>";
}

<!-- 🔹 FUNÇÃO PARA FORMATAR VALOR NO INPUT (CORRETO PARA AJAX) -->
function formatarMoedaInput(input) {

    let valor = input.value.replace(/\D/g, '');

    if (valor === '') {
        input.value = '';
        return;
    }

    valor = (parseInt(valor) / 100).toFixed(2);

    input.value = valor
        .replace('.', ',') // decimal
        .replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // milhar
}




<!-- 🔹 FUNÇÃO PARA FORMATAR VALOR NO INPUT (CORRETO PARA AJAX) -->
// ✔️ SOMA CHECKBOX (CORRETO PARA AJAX)
$(document).on('change', '.check', function(){

    let total = 0;

    $('.check:checked').each(function(){

        let valor = $(this).data('valor');

        // 🔥 garantia extra contra erro de formato
        if (typeof valor === 'string') {
            valor = valor.replace(',', '.');
        }

        total += parseFloat(valor) || 0;
    });

    $('#total').text(
        "Total: R$ " + total.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        })
    );
});




<!-- 🔹 FUNÇÃO PARA CARREGAR DESCRIÇÕES NO SELECT (CORRETO PARA AJAX) -->
function carregarDescricoes(idSelecionado) {

    $.getJSON('get_descricoes.php', function(lista){

        let html = '<select id="edit_descricao" class="form-control">';

        lista.forEach(function(item){

            let selected = (item.id_descricao == idSelecionado) ? 'selected' : '';

            html += `<option value="${item.id_descricao}" ${selected}>
                        ${item.descricao_abreviada}
                     </option>`;
        });

        html += '</select>';

        $('#editSelectDescricao').html(html);
    });
}

<!-- 🔹 FUNÇÃO PARA CARREGAR CATEGORIAS NO SELECT (CORRETO PARA AJAX) -->
function carregarCategorias(idSelecionado) {

    $.getJSON('get_categorias.php', function(lista){

        let html = '<select id="edit_categoria" class="form-control">';

        lista.forEach(function(item){

            let selected = (item.categoria == idSelecionado) ? 'selected' : '';

            html += `<option value="${item.categoria}" ${selected}>
                        ${item.nome_categoria}
                     </option>`;
        });

        html += '</select>';

        $('#editSelectCategoria').html(html);
    });
}






<!-- 🔹 FUNÇÃO PARA DESTACAR PARCELAS (CORRETO PARA AJAX) -->
function parcela_func(parc) {
    return (parc !== '01/01')
        ? `<span class="parcela-destaque">${parc}</span>`
        : parc;
}



<!-- 🔹 CLIQUE NO BOTÃO EDITAR (CORRETO PARA AJAX) -->
$(document).on('click', '.btn-editar', function(){

    let id = $(this).data('id');

    $.ajax({
        url: 'get_despesa.php',
        type: 'GET',
        data: { id: id },
        dataType: 'json',

        success: function(resp){

            let d = resp.dados;
            //let d = resp.dados[0];

            // 🔹 Preenche campos normais
            $('#edit_id').val(d.id_despesa);
            $('#edit_despesa').val(d.despesa);
            $('#edit_data').val(formatarData(d.data));
                        
            $('#edit_valor').val(formatarMoedaBancoParaTela(d.valor));
            $('#edit_valor_casa').val(formatarMoedaBancoParaTela(d.valor_casa));

            $('#edit_parcela').val(d.parcela);
            $('#edit_ocorrencia').val(d.ocorrencia);

            // 🔥 CARREGA SELECT DESCRIÇÃO
            $('#editSelectDescricao').load(
                'get_descricoes.php?id=' + d.id_descricao
            );

            // 🔥 CARREGA SELECT CATEGORIA
            $('#editSelectCategoria').load(
                'get_categorias.php?id=' + d.categoria
            );


            $('#edit_vencimento').val(formatarData(d.vencimento));

            $('#edit_pago').val(
                d.pago && d.pago !== '2001-01-01' ? formatarData(d.pago) : ''
            );


            $('#edit_obs').val(d.obs);
            $('#flexSwitchCheckDefault').prop('checked', d.valido === 'S');


            if (d.caminho) {
                $('#pdfViewer').attr('src', d.caminho);
            } else {
                $('#pdfViewer').attr('src', '');
            }



            $('#modalEditar').modal('show');
        }
    });
});




$(document).on('click', '#salvarEdicao', function(){

    let pagoBR = $('#edit_pago').val();

    let formData = new FormData();

    // 🔹 CAMPOS QUE VOCÊ JÁ TEM (mantidos)
    formData.append('id', $('#edit_id').val());
    formData.append('despesa', $('#edit_despesa').val());
    formData.append('data', converterDataParaMySQL($('#edit_data').val()));

    formData.append('valor', moedaParaBanco($('#edit_valor').val()));
    formData.append('valor_casa', moedaParaBanco($('#edit_valor_casa').val()));

    formData.append('parcela', $('#edit_parcela').val());
    formData.append('ocorrencia', $('#edit_ocorrencia').val());
    formData.append('descricao', $('#edit_descricao').val());
    formData.append('categoria', $('#edit_categoria').val());

    formData.append('vencimento', converterDataParaMySQL($('#edit_vencimento').val()));

    // 🔥 TRATAMENTO AQUI
    formData.append(
        'pago',
        $('#edit_pago').val()
            ? converterDataParaMySQL($('#edit_pago').val())
            : '2001-01-01'
    );


    formData.append('obs', $('#edit_obs').val());
    formData.append('valido', $('#flexSwitchCheckDefault').is(':checked') ? 'S' : 'N');

    // 🔥 NOVO: PDF
    let file = $('#pdfFile')[0].files[0];
    if (file) {
        formData.append('pdf', file);
    }

    $.ajax({
        url: 'update_despesa.php',
        type: 'POST',
        data: formData,
        processData: false,   // 🔥 obrigatório
        contentType: false,   // 🔥 obrigatório
        dataType: 'json',

        success: function(resp){
            if (resp.sucesso) {
                alert("Salvo com sucesso!");
                $('#modalEditar').modal('hide');
                buscar();
            } else {
                alert("Erro: " + resp.erro);
            }
        },

        error: function(){
            alert("Erro na comunicação com o servidor");
        }
    });
});

</script>





<div class="modal fade" id="modalEditar" tabindex="-1">
    
   <div class="modal-dialog modal-lg"> <!-- 👈 modal maior -->
    <div class="modal-content">
        <div class="com-espaco"></div>
        
    <div class="modal-header balao"> <!-- 👈 cabeçalho do modal com estilo de balao -->
        <h4 class="modal-title">Editar Despesa</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>

    <div class="modal-body balao"> <!-- 👈 corpo do modal com estilo de balao -->  
        <input type="hidden" id="edit_id">
        
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="edit_despesa">Despesa:</label>
                                    <input type="text" class="form-control" id="edit_despesa" name="despesa">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="edit_data">Data:</label>
                                    <input type="text" class="form-control" id="edit_data" name="data">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="edit_valor">Valor:</label>
                                    <input type="text" id="edit_valor" class="form-control" oninput="formatarMoedaInput(this)">
                                </div>        
                            </div> 

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="edit_valor_casa">Valor Total:</label>
                                    <input type="text" id="edit_valor_casa" class="form-control" oninput="formatarMoedaInput(this)">
                                </div>
                            </div> 
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="edit_parcela">Parcela:</label>
                                    <input type="text" class="form-control" id="edit_parcela" name="parcela">
                                </div>
                            </div>

                        </div>
        
                        <div class="row">                              
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="edit_ocorrencia">Ocorrencia:</label>
                                    <input type="text" class="form-control" id="edit_ocorrencia" name="ocorrencia">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <!-- 🔹 DESCRIÇÃO (SELECT DINÂMICO) -->
                                <div class="form-group">
                                    <label>Descrição</label>
                                    <div id="editSelectDescricao"></div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <!-- 🔹 CATEGORIA (SELECT DINÂMICO) -->
                                <div class="form-group">
                                    <label>Categoria</label>
                                    <div id="editSelectCategoria"></div>
                                </div>
                            </div>
            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Vencimento</label>
                                    <input type="text" id="edit_vencimento" class="form-control">
                                </div>
                            </div>
                    
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Pago</label>
                                    <input type="text" id="edit_pago" class="form-control">
                                </div>  
                            </div>  

                            <div class="col-md-1">
                                <div class="form-check form-switch">                                    
                                    <label class="form-check-label" for="flexSwitchCheckDefault">Ativo</label>                                
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                                </div>
                            </div>    

                        </div>  
                        
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="edit_obs">Observações:</label>
                                    <textarea class="form-control" id="edit_obs" name="obs" rows="1"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">    
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Selecionar PDF</label>
                                    <input type="file" id="pdfFile" accept="application/pdf">
                                </div> 
                            </div>
                        </div>

                        <div class="row"> 
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Visualização</label>
                                    <iframe id="pdfViewer" style="width:100%; height:700px;"></iframe>
                                </div>
                            </div>
                        </div>

    </div>

    <div class="modal-footer balao"> <!-- 👈 rodapé do modal com estilo de balao -->
        <button type="button" id="salvarEdicao" class="btn btn-primary">Salvar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
    </div>

    </div>
  </div>
</div>

   
</body>
</html>