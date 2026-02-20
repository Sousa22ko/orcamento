<?php
$caminhoImagem = "uploads/imagem_tratada.png";
$arquivoTemporario = "uploads/temp_ocr";

// Executa o Tesseract (sem extensão no arquivo de saída)
exec("tesseract " . escapeshellarg($caminhoImagem) . " " . escapeshellarg($arquivoTemporario) . " -l por");

// Lê o conteúdo que o Tesseract gerou
$resultadoOCR = file_get_contents($arquivoTemporario . ".txt");

// Salva no resultado final
file_put_contents("resultado.txt", $resultadoOCR);

?>
