<?php
require "../api/dbConnection.php";
require "../pages/generic.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $index = $_GET['index'];

    //Função que conecta ao banco, já definida em seu config.php
    $conn = getDBConnection();

    // Verifica se houve erro na conexão
    if ($conn->errorCode() != '') {
        die("Erro na conexão: " . $conn->errorInfo());
    }

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
        die("Erro ao preparar a query: " . $conn->errorInfo());
    }

    // Executar a consulta
    if ($stmtA->execute([$id])) {

        // se a $result tiver encontrado algum valor ele roda este IF
        $despesas = $stmtA->fetchAll(PDO::FETCH_ASSOC);
        if (count($despesas) > 0) {

            // Converte imagem para base64 se houver
            if (!empty($despesas[0]['imagem'])) {
                $despesas[0]['imagem'] = base64_encode($despesas[0]['imagem']);
            }

            $descricoes = obtem_dados_aux("descricao", "descricao_abreviada", "ASC");
            $categorias = obtem_dados_aux("categoria", "nome_categoria", "ASC");

            echo json_encode([
                "despesa" => $despesas[0],
                "descricoes" => $descricoes,
                "categorias" => $categorias
            ]);
        } else {
            echo json_encode(["erro" => "Despesa não encontrada."]);
        }
    } else {
        echo "Erro ao executar: " . $stmtA->errorInfo();
    }

    $stmtA->closeCursor();
} else {
    echo json_encode(["erro" => "ID não fornecido."]);
}
?>