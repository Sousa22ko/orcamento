<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campo Flutuante Sempre Visível</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Estilo do campo flutuante fixo */
        #campo-flutuante {
            position: fixed; /* Mantém fixo na tela */
            bottom: 20px;  /* Distância do fundo */
            right: 20px;   /* Distância da direita */
            background-color: #007bff; /* Azul chamativo */
            color: white;
            padding: 15px 25px;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000; /* Mantém sobre outros elementos */
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h2>Soma Automática</h2>
    
    <div class="mb-3">
        <label for="valor1" class="form-label">Valor 1</label>
        <input type="number" id="valor1" class="form-control" placeholder="Digite um número">
    </div>

    <div class="mb-3">
        <label for="valor2" class="form-label">Valor 2</label>
        <input type="number" id="valor2" class="form-control" placeholder="Digite outro número">
    </div>

    <!-- Espaço para testar a rolagem -->
    <div style="height: 2000px;"></div>
</div>

<!-- Campo Flutuante FIXO -->
<div id="campo-flutuante">Total: R$ 0.00</div>

<script>
$(document).ready(function() {
    function calcularSoma() {
        let v1 = parseFloat($('#valor1').val()) || 0;
        let v2 = parseFloat($('#valor2').val()) || 0;
        let total = (v1 + v2).toFixed(2);
        
        $('#campo-flutuante').text(`Total: R$ ${total}`);
    }

    // Atualiza sempre que digitar nos inputs
    $('#valor1, #valor2').on('input', calcularSoma);
});
</script>

</body>
</html>
