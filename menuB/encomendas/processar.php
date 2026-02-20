<?php
if (isset($_FILES['imagem'])) {
    var_dump($_FILES);
    $arquivo = $_FILES['imagem']['tmp_name'];
    $nomeDestino = 'imagens/uploads/temporaria.png';

    // Move o arquivo enviado para a pasta uploads
    move_uploaded_file($arquivo, $nomeDestino);

    // Executa o Tesseract OCR no arquivo salvo
    exec("tesseract $nomeDestino output.txt -l por", $saida, $retorno);

if ($retorno === 0 && file_exists($outputFile)) {
    $texto = file_get_contents($outputFile);
    echo "<h3>Texto extraído:</h3><pre>" . htmlspecialchars($texto) . "</pre>";
} else {
    echo "<p>Erro ao executar o OCR ou arquivo não foi criado.</p>";
    echo "<p>Código de saída: $retorno</p>";
}
}
?>
