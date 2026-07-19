<?php
session_start();


require_once "config.php";

$user_name = $_POST['user_name'] ?? '';
$senha = $_POST['senha'] ?? '';

$conn = conectar();

$sql = "SELECT * FROM usuarios
        WHERE user_name = ?
        AND senha = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("ss", $user_name, $senha);

$stmt->execute();

$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {

    $_SESSION['user_id'] = $row['user_id'];
    $_SESSION['user_name'] = $row['user_name'];

    header("Location: index2.php");
    exit;

} else {

    echo "Usuário ou senha inválidos";

}
?>