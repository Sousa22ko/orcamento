<?php

// definine a variavel ocorrencia para filtrar junto com a query $consulta
$today = getdate();
$hoje = (date("d/m/Y", mktime(0, 0, 0, $today['mon'], $today['mday'], $today['year'])));
$mes = substr($hoje, 3, 2);
$ano = substr($hoje, 8, 2);
$ocorrencia = ($ano . $mes);

function diffToday($data)
{
    $hoje = new DateTime();
    $diferenca = $hoje->diff($data);
    return ($diferenca->format('%r%a dias'));
}
