<?php

// aponta para o arquivo config.php onde está a conexao com o Banco de Dados
Include ('config.php');
// Faz uma chamada a function conectar que está em config.php e traz o resultado ou nao da conexao
$conn=conectar();



// 📌 4. Definição do parâmetro da consulta
$ocorrencia = '2504';


// 4.1 📌 Nome da tabela a ser usada 
$tabela='despesa';

// 4.2 📌Montando a consulta
$consulta= "SELECT $tabela.* FROM $tabela WHERE ocorrencia = ?";


// 📌 5. Preparação da consulta SQL com placeholder "?"
// o SELECT já entra dentro do parenteses de prepare(como argumentos), tudo na mesma linha////
$stmt = $conn->prepare("$consulta");

// 📌 6. Verifica se a preparação falhou
if (!$stmt) {
    die("Erro ao preparar a consulta: " . $conn->error);
}

// 📌 7. Associação do parâmetro e execução
$stmt->bind_param("s", $ocorrencia);
$stmt->execute();

// 📌 8. Obtendo os resultados
$result = $stmt->get_result();

// 📌 9. Convertendo os resultados para array associativo
$despesas = $result->fetch_all(MYSQLI_ASSOC);


if (!empty($despesas)): 
    foreach ($despesas as $despesa):

    echo "despesa: " . $despesa['despesa'] . " | valor: " . $despesa['valor'] ."<br>"; 

    
    endforeach;
endif;









?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Despesas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
   
<style>
          /* Cores alternadas bege e branco */
          .table-striped tbody tr:nth-of-type(odd) {
            background-color: #7e9d6f !important; /* Bege claro */
        }
        .table-striped tbody tr:nth-of-type(even) {
            background-color: #ffffff !important; /* Branco */
        }
        /* Cabeçalho da tabela em bege escuro */
        .thead-bege {
            background-color: #047624 !important;
            color: white !important;
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
            <?php if (!empty($despesas)): ?>
                <?php foreach ($despesas as $despesa): ?>
                    <tr>
                        <td><?php echo $despesa['despesa']; ?></td>
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
// 📌 10. Fechando recursos
$stmt->close();
$conn->close();
?>
