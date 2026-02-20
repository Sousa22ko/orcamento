<?php
// index.php
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editor de Estrutura de Tabelas</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body class="container">
<h2 class="text-primary">Editor de Estrutura de Tabelas (MySQL)</h2>
<hr>

<?php
$mysqli = new mysqli("localhost", "orcamento", "orcamento", "orcantigo");
if ($mysqli->connect_errno) {
    die("<div class='alert alert-danger'>Erro na conexão: " . $mysqli->connect_error . "</div>");
}

if (!isset($_GET['tabela'])) {
    $resultado = $mysqli->query("SHOW TABLES");
    echo "<form method='GET' class='form-inline'>";
    echo "<div class='form-group'>";
    echo "<label>Escolha uma tabela: </label> ";
    echo "<select name='tabela' class='form-control'>";
    while ($linha = $resultado->fetch_array()) {
        echo "<option value='{$linha[0]}'>{$linha[0]}</option>";
    }
    echo "</select> ";
    echo "<button type='submit' class='btn btn-primary'>Editar</button>";
    echo "</div></form>";
} else {
    $tabela = $_GET['tabela'];
    $resultado = $mysqli->query("DESCRIBE `$tabela`");
    echo "<form method='POST' action='atualizar.php'>";
    echo "<input type='hidden' name='tabela' value='$tabela'>";
    echo "<h4>Tabela: <strong>$tabela</strong></h4>";
    echo "<table class='table table-bordered table-striped'>";
    echo "<thead><tr class='info'>
            <th>Campo</th><th>Tipo</th><th>Nulo</th><th>Chave</th>
            <th>Padrão</th><th>Extra</th><th>Excluir</th>
        </tr></thead><tbody>";

    $tipos_comuns = ['INT', 'VARCHAR(100)', 'DECIMAL(10,2)', 'DATE', 'CHAR(1)', 'TEXT', 'TINYINT(1)', 'FLOAT', 'DOUBLE', 'BLOB'];

    while ($col = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td>
            <input name='field_name[]' value='{$col['Field']}' class='form-control'>
            <input type='hidden' name='original_field_name[]' value='{$col['Field']}'>
        </td>";

        echo "<td><select name='field_type[]' class='form-control'>";
        $achou = false;
        foreach ($tipos_comuns as $tipo) {
            $selected = strtolower($col['Type']) == strtolower($tipo) ? "selected" : "";
            if ($selected) $achou = true;
            echo "<option value='$tipo' $selected>$tipo</option>";
        }
        if (!$achou) {
            echo "<option value='{$col['Type']}' selected>{$col['Type']} (custom)</option>";
        }
        echo "</select></td>";

        echo "<td><input name='field_null[]' value='{$col['Null']}' class='form-control'></td>";
        echo "<td><input name='field_key[]' value='{$col['Key']}' class='form-control'></td>";
        echo "<td><input name='field_default[]' value='{$col['Default']}' class='form-control'></td>";
        echo "<td><input name='field_extra[]' value='{$col['Extra']}' class='form-control'></td>";
        echo "<td class='text-center'><input type='checkbox' name='delete[]' value='{$col['Field']}'></td>";
        echo "</tr>";
    }

    echo "</tbody></table>";
    echo '<button type="button" class="btn btn-success" onclick="adicionarCampo()">Adicionar novo campo</button>'; 
    echo "<br><br><button type='submit' class='btn btn-primary'>Aplicar Alterações</button>";
    echo "</form>";
}
?>

<script>
function adicionarCampo() {
    var tabela = document.querySelector("table tbody");
    var linha = document.createElement("tr");
    linha.innerHTML = `
        <td><input name="new_field_name[]" placeholder="Novo campo" class="form-control"></td>
        <td>
            <select name="new_field_type[]" class="form-control">
                <option value="INT">INT</option>
                <option value="VARCHAR(100)">VARCHAR(100)</option>
                <option value="DECIMAL(10,2)">DECIMAL(10,2)</option>
                <option value="DATE">DATE</option>
                <option value="CHAR(1)">CHAR(1)</option>
                <option value="TEXT">TEXT</option>
                <option value="TINYINT(1)">TINYINT(1)</option>
                <option value="FLOAT">FLOAT</option>
                <option value="DOUBLE">DOUBLE</option>
                <option value="BLOB">BLOB</option>
            </select>
        </td>
        <td><input name="new_field_null[]" value="YES" class="form-control"></td>
        <td><input name="new_field_key[]" value="" class="form-control"></td>
        <td><input name="new_field_default[]" value="" class="form-control"></td>
        <td><input name="new_field_extra[]" value="" class="form-control"></td>
        <td>--</td>
    `;
    tabela.appendChild(linha);
}
</script>
</body>
</html>
