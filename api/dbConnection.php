<?php
function getDBConnection()
{
    // 📌 1. Configuração do banco de dados
    if (file_exists(__DIR__ . "/../database.db")) {
        $driver = 'sqlite';
    } else {
        $driver = 'mysql';
    }

    echo $driver;

    try {
        if ($driver == 'sqlite') {
            // 📌 2. Criando a conexão com Sqlite3
            $caminho = __DIR__ . "/../database.db";
            $dsn = "sqlite:$caminho";

            echo $caminho;
            echo $dsn;

            $conn = new PDO($dsn);

            } else if ($driver == 'mysql') {
            // 📌 2. Criando a conexão com MySQLi
            $host = "localhost";
            $usuario = "orcamento";
            $senha = "orcamento";
            $banco = "orcamento";

            $dsn = "mysql:host=$host;dbname=$banco;charset=utf8";
            $conn = new PDO($dsn, $usuario, $senha);
        } else
            return null;


    }catch (PDOException $e) {
        die("Falha na conexão: ". $e->getMessage());
    }
    // Retorna o valor da $conn com a autenticação da conexao
    return $conn;
}

function getRangeDatas()
{
    $conn = getDBConnection();

    $consulta = "SELECT * FROM configuracao WHERE modulo = 'popup_vencimento'";
    $stmt = $conn->prepare($consulta);

    if (!$stmt) {
        die("Erro ao preparar a consulta: " . $conn->error);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $valores_MinMax = $result->fetch_assoc();

    if (!$valores_MinMax) {
        die("Nenhum valor encontrado.");
    }

    // Data atual em UTC, zerando o horário
    $hoje = new DateTime('now', new DateTimeZone('UTC'));
    $hoje->setTime(0, 0, 0);

    // Calcula datas com base nos valores retornados
    $data_inicio = clone $hoje;
    $data_inicio->modify($valores_MinMax['valor1'] . ' days');

    $data_fim = clone $hoje;
    $data_fim->modify($valores_MinMax['valor2'] . ' days');

    return [
        'data_inicio' => $data_inicio->format('Y-m-d'),
        'data_fim' => $data_fim->format('Y-m-d')
    ];
}