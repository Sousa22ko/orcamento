<?php

/*
$dataVencimento = new DateTime($vencido['vencimento']);
echo dif($dataVencimento);



function dif($dataVencimento){    
    $hoje = new DateTime(); // Pega a data de hoje    
    // Calcula a diferença
    $diferenca = $hoje->diff($dataVencimento);   
    // Exibe a quantidade de dias (positivo ou negativo)
    // Ex: "+120 dias" ou "-5 dias"
   // retorna o valor da diferença entre o dia de hoje e o dia do vencimento 
   return($diferenca->format('%r%a dias'));

}
*/






$vencido['vencimento'] = '2025-05-06';

// Define a data atual com fuso UTC, forçando a hora para meia-noite
$DataEntrada = new DateTime('now', new DateTimeZone('UTC'));
$DataEntrada->setTime(0, 0, 0);

// Define a data de vencimento, também forçando a hora para meia-noite
$vencimento = new DateTime($vencido['vencimento'], new DateTimeZone('UTC'));
$vencimento->setTime(0, 0, 0);

// Calcula a diferença
$intervalo = $DataEntrada->diff($vencimento);

// Exibe o número de dias
echo $intervalo->format('%r%a dias');




?>