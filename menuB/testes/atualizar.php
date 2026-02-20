<?php
// atualizar.php
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Atualiza Estrutura</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body class="container">
<h3 class="text-primary">Resultado da Alteração da Tabela</h3>
<hr>
<?php
$mysqli = new mysqli("localhost", "orcamento", "orcamento", "orcantigo");
if ($mysqli->connect_errno) {
    die("<div class='alert alert-danger'>Erro na conexão: " . $mysqli->connect_error . "</div>");
}

$tabela = $_POST['tabela'];
$nomes = $_POST['field_name'];
$originais = $_POST['original_field_name'];
$tipos = $_POST['field_type'];
$deletes = isset($_POST['delete']) ? $_POST['delete'] : [];

foreach ($nomes as $i => $novo_nome) {
    $tipo = trim($tipos[$i]);
    $original = trim($originais[$i]);

    if ($novo_nome === '' || $tipo === '') continue;

    if (in_array($original, $deletes)) {
        $sql = "ALTER TABLE `$tabela` DROP COLUMN `$original`";
    } elseif ($original !== $novo_nome) {
        $sql = "ALTER TABLE `$tabela` CHANGE COLUMN `$original` `$novo_nome` $tipo";
    } else {
        $sql = "ALTER TABLE `$tabela` MODIFY COLUMN `$novo_nome` $tipo";
    }

    if (!$mysqli->query($sql)) {
        echo "<pre class='bg-danger text-danger'>$sql\n" . $mysqli->error . "</pre>";
    } else {
        echo "<pre class='bg-success text-success'>$sql</pre>";
    }
}

if (isset($_POST['new_field_name'])) {
    $new_names = $_POST['new_field_name'];
    $new_types = $_POST['new_field_type'];
    $new_nulls = $_POST['new_field_null'];
    $new_defaults = $_POST['new_field_default'];
    $new_extras = $_POST['new_field_extra'];

    foreach ($new_names as $i => $new_name) {
        if (trim($new_name) === '' || trim($new_types[$i]) === '') continue;

        $new_type = $new_types[$i];
        $new_null = strtoupper(trim($new_nulls[$i])) === 'NO' ? 'NOT NULL' : 'NULL';

        $default_val = trim($new_defaults[$i]);
        $new_default = $default_val !== ''
            ? "DEFAULT '" . $mysqli->real_escape_string($default_val) . "'"
            : '';

        $new_extra = trim($new_extras[$i]);

        $sql = "ALTER TABLE `$tabela` ADD COLUMN `$new_name` $new_type $new_null $new_default $new_extra";

        if (!$mysqli->query($sql)) {
            echo "<pre class='bg-danger text-danger'>$sql\n" . $mysqli->error . "</pre>";
        } else {
            echo "<pre class='bg-success text-success'>$sql</pre>";
        }
    }
}
?>
<br>
<a href="index.php" class="btn btn-default">&larr; Voltar</a>
</body>
</html>
