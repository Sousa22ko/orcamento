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

function parcela_func($parc)
{
    if ($parc <> '01/01') {
        $resp = ('<font color="#FF0000">' . $parc . '</font>');
    } else {
        $resp = ($parc);
    }
    return $resp;
}

function pago_func($pg)
{
    if ($pg == '2001-01-01') {
        $resp = ('<strong><font color="#FF0000">N Pago</font></strong>');
    } else {
        $resp = (date("d/m/Y", (strtotime($pg))));
    }
    return $resp;
}

function obtem_dados_aux($tablename, $coluna, $ordem)
{
    $conn = getDBConnection();

    if ($conn->errorCode()) {
        echo "não conectou aux! Erro: " . $conn->errorInfo();
    }

    $query = "select * from $tablename order by $coluna $ordem";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
}