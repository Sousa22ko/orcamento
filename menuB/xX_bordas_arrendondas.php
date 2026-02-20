<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório com Bootstrap</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .rounded-report {
            border-radius: 15px;
            border: 1px solid #dee2e6;
            padding: 20px;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>

<div class="container mt-2">
    <div class="rounded-report">
        <h2 class="text-center">Relatório de Vendas</h2>
        <p>Data: 29 de setembro de 2024</p>

        <table class="table table-bordered">

            <thead class="bg-secondary">
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Preço Unitário</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>Produto A</td>
                    <td>10</td>
                    <td>R$ 20,00</td>
                    <td>R$ 200,00</td>
                </tr>
                <tr>
                    <td>Produto B</td>
                    <td>5</td>
                    <td>R$ 50,00</td>
                    <td>R$ 250,00</td>
                </tr>
                <tr>
                    <td>Produto C</td>
                    <td>2</td>
                    <td>R$ 100,00</td>
                    <td>R$ 200,00</td>
                </tr>          
            </tbody>

        </table>

        <h4 class="text-right">Total Geral: R$ 650,00</h4>
    </div>
</div>





<div class="container mt-2">
    <div class="rounded-report">
        <h2 class="text-center">Relatório de Vendas</h2>
        <p>Data: 29 de setembro de 2024</p>

        <table class="table table-bordered">

            <thead class="thead-light">
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Preço Unitário</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>Produto A</td>
                    <td>10</td>
                    <td>R$ 20,00</td>
                    <td>R$ 200,00</td>
                </tr>
                <tr>
                    <td>Produto B</td>
                    <td>5</td>
                    <td>R$ 50,00</td>
                    <td>R$ 250,00</td>
                </tr>
                <tr>
                    <td>Produto C</td>
                    <td>2</td>
                    <td>R$ 100,00</td>
                    <td>R$ 200,00</td>
                </tr>          
            </tbody>

        </table>

        <h4 class="text-right">Total Geral: R$ 650,00</h4>
    </div>
</div>


</div>




<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
