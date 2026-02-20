<?php
require("config.php");
require("functions.inc");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    //Função que conecta ao banco, já definida em seu config.php
    $conn = conectar();
  
    // Verifica se houve erro na conexão
    if ($conn->connect_error) {  die("Erro na conexão: " . $conn->connect_error);  }

    // Preparando a query com placeholders para evitar SQL Injection
    $query = "
        SELECT 
            despesa.*,
            descricao.*,
            tabela_imagens.*
        FROM 
            despesa
        JOIN descricao 
            ON despesa.id_descricao = descricao.id_descricao
        LEFT JOIN tabela_imagens 
            ON despesa.id_despesa = tabela_imagens.id_despesa_imagem
        WHERE despesa.valido = 'S'
            AND despesa.id_despesa = ?
    ";

    // Query SQL para SELECT
    $stmtA = $conn->prepare($query);

    if (!$stmtA) {
        die("Erro ao preparar a query: " . $conn->error);
    }

    // Bind do parâmetro id (inteiro)
    $stmtA->bind_param("i", $id);

    // Executar a consulta
    if ($stmtA->execute()) {
        
        // Usa get_result para obter os dados
        $result = $stmtA->get_result();
        
        // se a $result tiver encontrado algum valor ele roda este IF
        if ($result->num_rows > 0) {
            $despesas = $result->fetch_all(MYSQLI_ASSOC); //lista o array $despesas e coloca o nome do campo junto para listagem
            
            // Converte imagem para base64 se houver
            if (!empty($despesas[0]['imagem'])) {
                $despesas[0]['imagem'] = base64_encode($despesas[0]['imagem']);
            }

            echo json_encode($despesas[0]);
        } else {
            echo json_encode(["erro" => "Despesa não encontrada."]);
        }
    } else {
        echo "Erro ao executar: " . $stmtA->error;
    }

    $stmtA->close();
    $conn->close();
} else {
    echo json_encode(["erro" => "ID não fornecido."]);
}
?>


