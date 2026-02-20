<?php

// aponta para o arquivo config.php onde está a conexao com o Banco de Dados
Include ('config.php');
// Faz uma chamada a function conectar que está em config.php e traz o resultado ou nao da conexao
$conn=conectar();


// Pegando a ocorrência (exemplo vindo de uma variavel de formulario anteriormente executado)
//$ocorrencia = $_GET['mesAno'];
// Ou Pegando a ocorrência (exemplo fixo, ajustar conforme necessário)
$ocorrencia = '2501';

// Prepara a consulta para buscar despesas pela ocorrência
$sql = "SELECT despesa, valor FROM despesa WHERE ocorrencia = ?";
$stmt = $conn->prepare($sql);

// 🚨 Se a preparação falhar, exibir erro
if (!$stmt) {die("Erro ao preparar o SELECT: " . $conn->error);}

// Associa o parâmetro e executa a consulta
$stmt->bind_param("s", $ocorrencia);
$stmt->execute();

// Obtém o resultado da consulta
$result = $stmt->get_result();

// Converte os dados para um array associativo (compatível com foreach)
$despesas = $result->fetch_all(MYSQLI_ASSOC);

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Despesas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .table-striped tbody tr:nth-of-type(odd) {
            background-color:rgb(187, 187, 91) !important; /* Bege */
        }
        
        .table-striped tbody tr:nth-of-type(even) {
            background-color: #ffffff !important; /* Branco */
        }

        .thead-bege {
             background-color:rgb(91, 99, 59) !important; /* Bege escuro (Tons de "Tan") */
            color: white !important; /* Cor do texto */
        }
    </style>



</head>
<body>

<div class="container mt-4">
    <h2 class="text-center">Relatório de Despesas</h2>
    <table class="table table-bordered table-striped">
    <thead class="thead-bege">
            <tr>
                <th>Despesa</th>
                <th>Valor (R$)</th>
            </tr>
        </thead>
        <tbody>
        <!-- Verifica se existem dados encontrados-->
            <?php if (!empty($despesas)): ?>
                <!-- Separa o array $despesas em subarrays em $despesa no seguinte formato: $despesa['despesa']-->
                <!-- onde ['despesas'] é o nome do campo a ser impresso (array associativo) -->
                <!-- foreach separa o array principal e subdivide em arrays associativos-->
                <?php foreach ($despesas as $despesa): ?>
                    <tr>
                        <!-- echo imprime e formata os arrays associativos-->
                        <td><?php echo htmlspecialchars($despesa['despesa']); ?></td>
                        <td><?php echo number_format($despesa['valor'], 2, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2" class="text-center">Nenhuma despesa encontrada.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Fecha a conexão com o banco de dados
$stmt->close();
$conn->close();
?>
