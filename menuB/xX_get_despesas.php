<?php
require ("orcamento.inc");
require ("functions.inc");
if (isset($_GET['mesAno'])) {
    // Mocking data
    $mesAno = $_GET['mesAno'];

    $query = "SELECT $dbname.despesa.*,$dbname_aux.descricao.*
        FROM $dbname.despesa,$dbname_aux.descricao
        WHERE $dbname.despesa.ocorrencia = '$mesAno'
        AND $dbname.despesa.id_descricao=$dbname_aux.descricao.id_descricao
        AND $dbname.despesa.valido='S'
        ORDER BY $dbname.despesa.id_descricao,$dbname.despesa.valor  DESC";

    $result = mysqli_query($mysqli_connection, $query);

    // Example mocked data
    // $despesas = [
    //     ["id" => 1, "descricao" => "Aluguel", "valor" => "1500.00"],
    //     ["id" => 2, "descricao" => "Internet", "valor" => "100.00"],
    //     ["id" => 3, "descricao" => "Energia", "valor" => "200.00"]
    // ];
    $despesas = mysqli_fetch_all($result, MYSQLI_ASSOC);

    echo '<table class="table table-bordered">';
    echo '<thead>';
    echo '<tr><th>Descrição</th><th>Valor</th><th>Ações</th></tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($despesas as $despesa) {
        echo '<tr>';
        echo '<td>' . $despesa["despesa"] . '</td>';
        echo '<td>' . $despesa["valor"] . '</td>';
        echo '<td><button class="btn btn-warning btn-sm btn-edit" data-id="' . $despesa["id_despesa"] . '">Editar</button></td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
}
?>
