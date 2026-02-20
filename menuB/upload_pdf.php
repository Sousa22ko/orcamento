<?php
require_once("config.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli("localhost", "orcamento", "orcamento", "orcamento");
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    // Verifica se foi enviado um arquivo
    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
        $nome = $_FILES['pdf']['name'];
        $tipo = $_FILES['pdf']['type'];
        $tamanho = $_FILES['pdf']['size'];
        $conteudo = file_get_contents($_FILES['pdf']['tmp_name']);

        // Prepare e execute a query
        $stmt = $conn->prepare("INSERT INTO tabela_imagens (nome_imagem, tipo_imagem, tamanho_imagem, imagem) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $nome, $tipo, $tamanho, $conteudo);

        if ($stmt->execute()) {
            echo "PDF enviado com sucesso!";
        } else {
            echo "Erro ao inserir: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Erro ao enviar o arquivo.";
    }

    $conn->close();
}
?>
