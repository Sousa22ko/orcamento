<?php
header('Content-Type: application/json');
//////////////////

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "config.php";
require_once "functions.inc";

setlocale(LC_TIME, 'pt_BR.UTF-8');

$ocorrencia = $_GET['ocorrencia'] ?? null;
$user_id = $_GET['userr_id'] ?? null; // ID do usuário vindo da requisição

//$ocorrencia='2606';
//$user_id=3;






if (!$ocorrencia || !$user_id) {
    echo json_encode(["erro" => "Parâmetros não informados"]);
    exit;
}




if (!$ocorrencia) {
    echo json_encode(["erro" => "Ocorrência não informada"]);
    exit;
}

$conn = conectar();
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}






/* =====================================================
   BUSCA RECEITA
=====================================================*/ 
$salario = 0;

$sqlReceita = "SELECT receita FROM receita WHERE ocorrencia = ? AND user_id_receita = ?";
$stmt = $conn->prepare($sqlReceita);
$stmt->bind_param("si", $ocorrencia, $user_id);
$stmt->execute();
$res = $stmt->get_result();

if ($row = $res->fetch_assoc()) {
    $salario = $row['receita'];
}

$stmt->close();




/* =====================================================
BUSCA DESPESAS
=====================================================*/
$sql =  "SELECT 
    despesa.*,
    descricao.*,
    categoria.*,
    usuarios.*
FROM despesa
JOIN descricao ON despesa.id_descricao = descricao.id_descricao
JOIN categoria ON despesa.categoria = categoria.categoria
JOIN usuarios ON despesa.user_id = usuarios.user_id
WHERE despesa.ocorrencia = ?
  AND despesa.valido = 'S'
  AND despesa.user_id = ?
ORDER BY despesa.id_descricao ASC, despesa.valor DESC , despesa.data ASC
";


$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $ocorrencia, $user_id);
$stmt->execute();
$result = $stmt->get_result();

//echo "Total registros: " . $result->num_rows;

$dados = [];
while ($row = $result->fetch_assoc()) {
    $dados[] = $row;
}

/**/
echo json_encode([
    "sucesso" => true,
    "dados" => $dados,
    "salario" => $salario
]);




$stmt->close();
$conn->close();




