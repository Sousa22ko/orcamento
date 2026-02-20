<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orcamento</title>

  <!-- Bootstrap 3 CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">      

  <!-- Datepicker CSS -->
  <link href="css/bootstrap-datepicker.css" rel="stylesheet">

  <!-- Seu estilo -->
  <link rel="stylesheet" href="./styles.css">

  <style>
    .container {
      margin: 15px;
      margin-top: 90px;
    }
  </style>
</head>
<body>

<?php header("Content-Type: text/html; charset=UTF-8", true);

require_once("functions.inc");
require_once("config.php");

// Conecta ao banco
$conn = conectar();

// trazendo as variaveis do formulario inclui_despesa.php //////////////////////////
$ocorrencia=($_POST["ocorrencia"]);
$ocorrencia= (substr($ocorrencia,5,2).substr($ocorrencia,0,2));
$valor=($_POST["valor"]);

///////////// SUBMETE A VARIAVEL ID_DESCRI��O VINDO DO FORMULARIO, A FUN��O VER_DATA PARA ESTABELECER QUAL SERA A NOVA DATA DO VENCIMENTO.

////////////////////////////////////////////////////////////////////////novo //////////////////////////////////
// Verifica se já existe
$sql = "SELECT receita.* FROM receita WHERE ocorrencia = ?";
$stmt = $conn->prepare($sql);

// 🚨 Se a preparação falhou, exibir erro
if (!$stmt) {
    die("Erro ao preparar o SELECT: " . $conn->error);
}

$stmt->bind_param("s",$ocorrencia);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo modal("Registro ja existe!", "danger");//primeiro param: $mensagem segundo param: $tipo

} else {
    $stmt->close(); // Fechar primeiro statement antes de criar outro

    $query = "INSERT INTO receita (receita, ocorrencia) 
            VALUES (?, ?)";
    $stmtA = $conn->prepare($query);

    if (!$stmtA) {
        $mensagem = "Erro ao preparar a query: " . $conn->error;
        $tipo = "danger";
        echo modal($mensagem, $tipo);
    } else {
        $stmtA->bind_param("ds", 
        $valor,  
        $ocorrencia
    );

    if ($stmtA->execute()) {  
         echo modal("A alteração foi realizada com sucesso! Receita de R$ $valor, do Ano/Mes  $ocorrencia", "success");//primeiro param: $mensagem segundo param: $tipo
         }       
        else {
             echo modal("A alteração **não** foi realizada com sucesso!", "danger");//primeiro param: $mensagem segundo param: $tipo
                }
        $stmtA->close();
    }
    $conn->close();
}

?>

  <!-- Scripts agrupados -->
  <?php include("includes/scripts.php"); ?>
</body>
</html>
