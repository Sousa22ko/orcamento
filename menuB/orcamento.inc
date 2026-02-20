     
<?
     //header("Content-Type: text/html; charset=ISO-8859-1",true) ;

// Conecta-se com o MySQL
$host="localhost";
$user="orcamento";
$senha="orcamento";
$dbname="orcamento";

// Cria uma nova conexão
$mysqli_connection = new mysqli($host, $user, $senha, $dbname);

// Verifica se a conexão foi bem-sucedida
if ($mysqli_connection->connect_error) {
    die('Conexão falhou: ' . $mysqli_connection->connect_error);
}

// echo 'Conexão bem-sucedidaaaaa!';

// Fecha a conexão
//$mysqli_connection->close();






// banco de dados auxiliar //
$host="localhost";
$user_aux = "orcamento";
$password_aux = "orcamento";
$dbname_aux = "orcamento";

$link_aux = new MySQLi($host, $user, $senha, $dbname_aux);

if($link_aux->connect_error){
  echo "n�o conectou aux! Erro: " . $link_aux->connect_error;}

 // echo 'Conexão  auxiliar bem-sucedidaaaaa!';

$today = getdate();
$hoje = (date("d/m/Y", mktime (0,0,0,$today['mon'],$today['mday'],$today['year'])));
$ano = substr($hoje,8,4);
$mes = substr($hoje,3,2);
$dia = substr($hoje,0,2);
$valor_data=$dia.'/'.$mes.'/20'.$ano;
//print "oi, hoje � dia : ". $valor_data;



?>
