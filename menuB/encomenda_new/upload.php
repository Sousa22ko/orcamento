<?php
$diretorio = "uploads/";

if (!file_exists($diretorio)) {
    mkdir($diretorio, 0777, true);
}


echo "<pre>";
exec("where python", $saida);
print_r($saida);
echo "</pre>";




if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['imagem'])) {
    $arquivo = $_FILES['imagem'];

    if ($arquivo['error'] === UPLOAD_ERR_OK) {
        $nomeTemporario = $arquivo['tmp_name'];
        $nomeOriginal = "imagem_recebida.jpg";
        $caminhoImagem = $diretorio . $nomeOriginal;

        if (move_uploaded_file($nomeTemporario, $caminhoImagem)) {
            // Chama o Python
            #$comando = "python melhora_imagem.py 2>&1"; // redireciona stderr para stdout
            #$comando = "C:/Python313/python.exe melhora_imagem.py 2>&1";
            $comando = "C:/Users/manom/AppData/Local/Programs/Python/Python312/python.exe melhora_imagem.py 2>&1";

            exec($comando, $saida, $retorno);

            // Exibe tudo (para debug)
            echo "<pre>Saída do Python:\n" . implode("\n", $saida) . "\nCódigo de retorno: $retorno</pre>";







            if ($retorno === 0 && file_exists("resultado.txt")) {
                $textoExtraido = file_get_contents("resultado.txt");
                echo "<h2>Texto extraído da imagem:</h2>";
                echo "<pre>$textoExtraido</pre>";
            } else {
                echo "Erro ao executar o script Python.";
            }
        } else {
            echo "Falha ao mover a imagem.";
        }
    } else {
        echo "Erro no upload: " . $arquivo['error'];
    }
} else {
    echo "Nenhuma imagem recebida.";
}
?>
