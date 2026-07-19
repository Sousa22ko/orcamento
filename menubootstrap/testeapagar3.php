<?php
// 📌 1. Configuração do banco de dados
$host = "localhost";
$banco = "orcamento";
$usuario = "orcamento";
$senha = "orcamento";

try {
    // 📌 2. Criando a conexão com PDO
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8", $usuario, $senha, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Ativa erros do PDO
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Retorna arrays associativos
    ]);

    // 📌 3. Definição do parâmetro
    $ocorrencia = '2501';

    // 📌 4. Preparação e execução da consulta
    $sql = "SELECT despesa, valor FROM despesa WHERE ocorrencia = :ocorrencia";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':ocorrencia', $ocorrencia, PDO::PARAM_STR);
    $stmt->execute();

    // 📌 5. Obtendo os resultados
    $despesas = $stmt->fetchAll(); // Retorna um array associativo
} catch (PDOException $e) {
    die("Erro ao conectar: " . $e->getMessage());
}




?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Despesas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Alternância de cores */
        .table-striped tbody tr:nth-of-type(odd) {
            background-color:rgb(174, 174, 61) !important;
        }
        .table-striped tbody tr:nth-of-type(even) {
            background-color: #ffffff !important;
        }
        .thead-bege {
            background-color:rgb(166, 129, 81) !important;
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
