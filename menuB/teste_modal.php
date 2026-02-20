<?php
// Exemplo: após o envio de um formulário
$mensagem = "";
$mostrar_modal = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Simule o resultado do salvamento (pode ser uma query real)
    $salvou = true; // ou false, dependendo do seu processo

    if ($salvou) {
        $mensagem = "Registro salvo com sucesso!";
    } else {
        $mensagem = "Erro ao salvar o registro!";
    }
    $mostrar_modal = true;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Modal PHP Bootstrap</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="p-5">

<!-- Formulário simples -->
<form method="POST">
  <button type="submit" class="btn btn-success">Salvar</button>
</form>

<!-- Modal de Mensagem -->
 
<div class="modal fade <?php if ($mostrar_modal) echo 'show d-block'; ?>" 
id="alertaModal" tabindex="-1" role="dialog" 
aria-hidden="<?php echo $mostrar_modal ? 'false' : 'true'; ?>" 
style="<?php echo $mostrar_modal ? 'background-color: rgba(0,0,0,0.5);' : ''; ?>">

  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title">Aviso</h5>
      </div>
      <div class="modal-body text-center">
        <?php echo $mensagem; ?>
      </div>
      <div class="modal-footer justify-content-center">
        <a href="" class="btn btn-secondary">Fechar</a>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap (usado internamente, sem escrever JS) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
