<?php
require("orcamento.inc");
require("functions.inc");
if (isset($_POST['buscaPHP'])) {

$busca=($_POST["buscaPHP"]);

$query="SELECT $dbname.despesa.*,$dbname_aux.descricao.*
        FROM $dbname.despesa,$dbname_aux.descricao
        WHERE $dbname.despesa.ocorrencia = '$busca'
        AND $dbname.despesa.id_descricao=$dbname_aux.descricao.id_descricao
        AND $dbname.despesa.valido='S'
        ORDER BY $dbname.despesa.id_descricao,$dbname.despesa.valor  DESC";

        //print $query;
$result = mysqli_query($mysqli_connection, $query);


    // Gera o HTML da tabela
    echo '<table class="table table-bordered">';
    echo '<thead><tr><th>descricao</th><th>Despesa</th></tr></thead><tbody>';
    foreach($result as $row)  {
        echo '<tr>';
        echo '<td>' .($row["id_descricao"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["despesa"]) . '</td>';
        echo '</tr>';
    }
    echo '</tbody></table>';
}
?>



