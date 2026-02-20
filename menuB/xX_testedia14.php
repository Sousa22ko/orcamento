<HTML>
<HEAD>
 <TITLE>New Document</TITLE>
</HEAD>
<BODY>


  <?php
// Conexão com o banco de dados (exemplo básico)

$servername = "localhost";
$username = "orcamento";
$password = "orcamento";
$dbname = "orcamento";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
  die("Erro na conexão: " . $conn->connect_error);
}
// Query SQL
$sql = "SELECT despesa.* FROM despesa";
$result = $conn->query($sql);

// Verifica se a query retornou resultados
if ($result->num_rows > 0) {
    // Array para armazenar os resultados
    $dados = array();

    // Contador inicial
    $contador = 1;




while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))      // executa enquanto houver resultados
 //   {     print ("<tr><td> ".$row["despesa"]."</font></td><p>");   }






{
        // Armazena no array associativo
        $dados[] = array(
            'contador' => $contador,
            'id' => $row['id_despesa'],
            // Adicione outros campos conforme necessário
        );

        // Incrementa o contador
        $contador++;
    }

}

    // Exemplo de como usar os dados
    foreach ($dados as $item) {
        echo "Contador: " . $item['contador'] . ", ID: " . $item['id'] . "<br>";}



                                                                                       // Fecha a conexão
$conn->close();
?>


</BODY>
</HTML>
