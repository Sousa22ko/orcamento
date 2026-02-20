<?php
// Coloque aqui o caminho completo do python.exe da versão 3.12
//$python = "C:/Users/seu_usuario/AppData/Local/Programs/Python/Python312/python.exe";
$python = "c:/Users/manom/AppData/Local/Programs/Python/Python312/python.exe";

// Comando completo para rodar o script de instalação dos módulos
$comando = "$python instala_modulos.py 2>&1";

exec($comando, $saida, $retorno);

echo "<pre>" . implode("\n", $saida) . "\nCódigo de retorno: $retorno</pre>";
?>
