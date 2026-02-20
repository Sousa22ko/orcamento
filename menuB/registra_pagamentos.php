<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Modal PHP Bootstrap</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="p-5">
  
<?php
header("Content-Type: text/html; charset=UTF-8", true);
require_once("config.php");
require("functions.inc");

// verifica se as variaveis vieram realmente de um formulario anteriormente enviado. messe caso por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
// Variáveis do formulário
$data = $_POST["data"];
$ocorrencia = $_POST["ocorrencia"];
$id_descricao = $_POST["id_descricao"];

$n_ocorrencia = substr($ocorrencia, 5, 2) . substr($ocorrencia, 0, 2);
$novadata = dateFormat1($data);
}

// Conecta ao banco
$conn = conectar();

if ($conn->connect_error) {
  $mensagem = "Erro de conexão: " . $conn->connect_error;
  $tipo = "danger";
  echo modal($mensagem, $tipo);
} else {
  $query = "UPDATE despesa SET pago=? WHERE ocorrencia=? AND id_descricao=?";
  $stmtA = $conn->prepare($query);
  
  if (!$stmtA) {
        $mensagem = "Erro ao preparar a query: " . $conn->error;
        $tipo = "danger";
        echo modal($mensagem, $tipo);
    } else {
        $stmtA->bind_param("ssi", $novadata, $n_ocorrencia, $id_descricao);
        if ($stmtA->execute()) {  
          //$mensagem = "A alteração foi realizada com sucesso!";
         // $tipo = "success";
         // echo modal($mensagem, $tipo);
           echo modal("A alteração foi realizada com sucesso!", "success");//primeiro param: $mensagem segundo param: $tipo
      }          
        else {
          echo modal("A alteração **não** foi realizada com sucesso!", "danger");//primeiro param: $mensagem segundo param: $tipo
        }
        $stmtA->close();
      }
      
      $conn->close();
    }
    ?>


<!-- Bootstrap (usado internamente, sem escrever JS) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
