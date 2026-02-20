<?php
$diretorio = "uploads/";

if (!file_exists($diretorio)) {
    mkdir($diretorio, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['imagem'])) {
    $arquivo = $_FILES['imagem'];

    if ($arquivo['error'] !== UPLOAD_ERR_OK) {
        echo "Erro no upload: " . $arquivo['error'];
        exit;
    }

    $nomeTemporario = $arquivo['tmp_name'];
    $nomeOriginal = basename($arquivo['name']);
    $caminhoCompleto = $diretorio . time() . "_" . $nomeOriginal;

    if (move_uploaded_file($nomeTemporario, $caminhoCompleto)) {
        echo "Imagem enviada com sucesso!<br>";
        echo "<img src='$caminhoCompleto' style='max-width:300px;'><br>";
    } else {
        echo "Falha ao mover a imagem.";
    }
} else {
    echo "Nenhuma imagem recebida.";
}
