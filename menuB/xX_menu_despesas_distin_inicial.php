<?php
echo("

<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Menu Despesas (Sem Duplicatas)</title>
</head>
<body>

    <h2>Selecione uma Despesa</h2>
<!-- Inclui o menu gerado dinamicamente em PHP -->
    
 ");
 
include 'menu_despesas_distinct.php'; 
    echo("</body></html>");
    ?>



