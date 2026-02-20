<?
require ("config.php");
require ("functions.inc");

// echo "<pre>";
//     var_dump($_POST);
//     var_dump($_FILES);
// echo "</pre>";

$indice = ($_POST["id_despesa"]);

$ocorrencia = ($_POST["ocorrencia"]);
$despesa = ($_POST["despesa"]);
$parcela = ($_POST["parcela"]);
$ocorrencia = ($_POST["ocorrencia"]);
$data = ($_POST["data"]);
$vencimento = ($_POST["vencimento"]);
$pago = ($_POST["pago"]);
$valor = ($_POST["valor"]);
$valor_casa = ($_POST["valor_casa"]);
$pago = ($_POST["pago"]);
$id_descricao = ($_POST["id_descricao"]);
$obs = ($_POST["obs"]);
$categoria = ($_POST["categoria"]);
$valido = ($_POST["valido"]);


// Conexão com o banco
//Função que conecta ao banco, já definida em seu config.php
$conn=conectar();

// Verifica se houve erro na conexão
if ($conn->connect_error) {  die("Erro na conexão: " . $conn->connect_error);  }


// Query SQL para UPDATE
$stmtA = $conn->prepare("UPDATE despesa 
SET despesa = ?, data = ?, valor = ?, valor_casa = ?, ocorrencia = ?, parcela = ?, 
id_descricao = ?, vencimento = ?, pago = ?, obs = ?, categoria = ?, valido = ? 
WHERE id_despesa = ?");


// 🚨 Se a preparação falhou, exibir erro
if (!$stmtA) {
    die("Erro ao preparar o INSERT: " . $conn->error);
}

// Associar os parâmetros corretamente
$stmtA->bind_param("ssddssisssisi",
    $despesa,  
    $data, 
    $valor,  
    $valor_casa, 
    $ocorrencia, 
    $parcela,
    $id_descricao, 
    $vencimento,
    $pago, 
    $obs, 
    $categoria,
    $valido,
    $indice  // <- necessário para WHERE id_despesa = ?
);


// executa a consulta
if ($stmtA->execute()) {
    // Sucesso no upload do PDF
} else {
    echo "Erro ao Salvar: " . $stmtA->error;
}
$stmtA->close();
/////////////////////////////////////////////////////////////////////um novo update fim ///////////////////////////



/////////////////////////////////////////////////////incluir um novo pdf inicio /////////////////////////////
if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
    $nome = $_FILES['pdf']['name'];
    $tipo = $_FILES['pdf']['type'];
    $tamanho = $_FILES['pdf']['size'];
    $conteudo = file_get_contents($_FILES['pdf']['tmp_name']);
    
    // Verifique se já existe registro na tabela_imagens para essa despesa.
    // Se sim, pode fazer um UPDATE; se não, um INSERT.
    // Exemplo simples: usar INSERT com ON DUPLICATE KEY UPDATE,
    // supondo que o campo id_despesa_imagem seja UNIQUE.
    
    $stmtB = $conn->prepare("INSERT INTO tabela_imagens (id_despesa_imagem, nome_imagem, tipo_imagem, tamanho_imagem, imagem)
                             VALUES (?, ?, ?, ?, ?)
                             ON DUPLICATE KEY UPDATE nome_imagem = VALUES(nome_imagem), 
                             tipo_imagem = VALUES(tipo_imagem), 
                             tamanho_imagem = VALUES(tamanho_imagem), 
                             imagem = VALUES(imagem)");

                             if (!$stmtB) { die("Erro ao preparar o INSERT: " . $conn->error); }
                             
                             // O tipo para o campo de imagem deve ser 'b' para indicar Blob
                             $null = NULL;
                             $stmtB->bind_param("sssib", $indice, $nome, $tipo, $tamanho, $null);
                             $stmtB->send_long_data(4, $conteudo);
                             
                             if ($stmtB->execute()) {
                                // Sucesso no upload do PDF

                                echo "Sucesso ao inserir o PDF: ";
                            } else {
                                echo "Erro ao inserir o PDF: " . $stmtB->error;
                            }
                        $stmtB->close();
    }
        else {echo "Salvo!: ";
                
            }
 //////////////////////////////////////////////////////// incluir um novo pdf termino ///////////////////////////////////////
?>



