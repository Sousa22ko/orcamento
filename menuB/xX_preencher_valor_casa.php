<?php
// Configurações de conexão
$host = 'localhost'; // ou o seu host
$username = 'root';
$password = '';
$dbname = 'orcamento';
$contador='1';
$inicio='1';


// Criar conexão
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consulta para buscar todos os registros
$sql = "SELECT * FROM despesa WHERE valido='S'";
$result = $conn->query($sql);

// Verificar se há resultados
if ($result->num_rows > 0) {                                
    // Saída de cada linha
    while ($row = $result->fetch_assoc()) {
       
            $id_desp= $row['id_despesa'];  


            if ($row['id_descricao'] =='9' or $row['id_descricao'] =='17' or $row['id_descricao'] =='20' or $row['id_descricao'] =='25' or $row['id_descricao'] =='27')
            {$novo_valor= ($row["valor"]); }                 
           else
            {
                $novo_valor= (($row["valor"])*(substr($row['parcela'],3,2)));
            } 


            // Consulta para atualizar o registro
            $sql2 = "UPDATE despesa SET valor_casa='$novo_valor' WHERE id_despesa = $id_desp";

                if ($conn->query($sql2) === TRUE) {
                    echo "Despesa: " . $row["id_descricao"] . " - Valor casa: " . $novo_valor . " - Valor: " . $row["valor"] . " - Parcela: " . $row['parcela'] =(substr($row['parcela'],3,2)) ." - valido: " . $row["valido"] ."<br>";

                    // echo "Registro atualizado com sucesso!";


                    } else {
                      echo "Erro ao atualizar registro: " . $conn->error;
                 }
       
        }
       
        $contador++;
     
         
       
       
        // Adicione mais campos conforme necessário
    }
 else {
    echo "0 resultados";
}

// Fechar conexão
$conn->close();
?>
