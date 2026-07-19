<?php
require_once "config.php";

$conn = conectar();

// 🔹 função para tratar moeda
function tratarValor($valor) {
    return str_replace(',', '.', str_replace('.', '', $valor));
}

// 🔹 dados
$id            = $_POST['id'];
$despesa       = $_POST['despesa'];
$data          = $_POST['data'];
$valor         = $_POST['valor'];
//$valor         = tratarValor($_POST['valor']);
$valor_casa    = $_POST['valor_casa'];
$parcela       = $_POST['parcela'];
$ocorrencia    = $_POST['ocorrencia'];
$id_descricao  = $_POST['descricao'];
$categoria     = $_POST['categoria'];
$vencimento    = $_POST['vencimento'];
$pago          = $_POST['pago'];

if (empty($pago) || $pago === '0000-00-00') {
    $pago = '2001-01-01';
}

$obs           = $_POST['obs'];
$valido        = $_POST['valido'];

// 🔹 UPDATE
$sql = "UPDATE despesa SET 
            despesa = ?, 
            data = ?, 
            valor = ?, 
            valor_casa = ?, 
            parcela = ?, 
            ocorrencia = ?, 
            id_descricao = ?, 
            categoria = ?, 
            vencimento = ?, 
            pago = ?, 
            obs = ?, 
            valido = ?
        WHERE id_despesa = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ssddssiissssi",
    $despesa,
    $data,
    $valor,
    $valor_casa,
    $parcela,
    $ocorrencia,
    $id_descricao,
    $categoria,
    $vencimento,
    $pago,
    $obs,
    $valido,
    $id
);

$stmt->execute();


// 🔥 UPLOAD PDF (NOVO)
if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] == 0) {

    $arquivo = $_FILES['pdf'];

    // valida PDF
    if ($arquivo['type'] == 'application/pdf') {

        $nomeOriginal = $arquivo['name'];
        $tmp = $arquivo['tmp_name'];

        $novoNome = time() . "_" . $nomeOriginal;
        $destino = "uploads/" . $novoNome;

        if (move_uploaded_file($tmp, $destino)) {

            $sql2 = "INSERT INTO anexo (id_despesa, nome_anexo, caminho)
                     VALUES (?, ?, ?)
                        ON DUPLICATE KEY UPDATE
                            nome_anexo = VALUES(nome_anexo),
                            caminho = VALUES(caminho)
                     ";

            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("iss", $id, $nomeOriginal, $destino);
            $stmt2->execute();
        }
    }
}

echo json_encode(["sucesso" => true]);

$stmt->close();
$conn->close();

