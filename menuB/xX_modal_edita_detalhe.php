<?php
require ("orcamento.inc");
require ("functions.inc");
if (isset($_GET['id'])) {
    // Mocking data
    $id = $_GET['id'];

    $query = "SELECT $dbname.despesa.*,$dbname_aux.descricao.*
          FROM $dbname.despesa ,$dbname_aux.descricao
          WHERE $dbname.despesa.valido='S'
          AND $dbname.despesa.id_descricao=$dbname_aux.descricao.id_descricao
          AND $dbname.despesa.id_despesa=" . $id;


    // print $query;
    // Executa a primeira query sql
    
    $result = mysqli_query($mysqli_connection, $query);
    $despesas = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    // Example mocked data
    // $despesas = [
    //     1 => ["id" => 1, "descricao" => "Aluguel", "valor" => "1500.00"],
    //     2 => ["id" => 2, "descricao" => "Internet", "valor" => "100.00"],
    //     3 => ["id" => 3, "descricao" => "Energia", "valor" => "200.00"]
    // ];
    $despesas['valido']='S';

    if (isset($despesas)) {
        echo json_encode($despesas[0]);
        } else {
        echo json_encode(["erro" => "Despesa não encontrada."]);
       }
}

?>



