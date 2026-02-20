<?php
// Configurações do banco de dados
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "orcamento";

// Conecta ao banco de dados
$conn = new mysqli($servidor, $usuario, $senha, $banco);

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Inicializa variáveis
$id_descricao = "";
$resultado = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém o valor do campo ID do formulário
    $id_descricao = $_POST['id_descricao'];
    
    // Prepara e executa a consulta SQL
    $stmt = $conn->prepare("SELECT * FROM  descricao WHERE id_descricao = ?");
    $stmt->bind_param("id_descricao", $id_descricao);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    // Verifica se encontrou algum resultado
    if ($resultado->num_rows > 0) {
        $dados = $resultado->fetch_assoc();
    } else {
        $dados = null;
    }
    
    $stmt->close();
}

// Fecha a conexão com o banco de dados
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Usuário</title>
</head>
<body>
    <h1>Consulta de Usuário</h1>
    <form method="post" action="">
        <label for="id_descricao">ID da descricao:</label>
        <input type="number" id="id_descricao" name="id_descricao" required>
        <input type="submit" value="Consultar">
    </form>
    
    <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <h2>Resultado da Consulta:</h2>
        <?php if ($dados): ?>
            <p><strong>ID:</strong> <?php echo htmlspecialchars($dados['id_descricao']); ?></p>
            <p><strong>descricao:</strong> <?php echo htmlspecialchars($dados['descricao']); ?></p>
            <p><strong>descricao abreviada:</strong> <?php echo htmlspecialchars($dados['descricao_abreviada']); ?></p>
        <?php else: ?>
            <p>Nenhum usuário encontrado com o ID fornecido.</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
