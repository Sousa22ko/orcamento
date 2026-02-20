<?php
include('config.php');
$conn = conectar();

// Certifique-se de receber os dados corretamente
if (isset($_POST['valor1'], $_POST['valor2'])) {
    $valor1 = (int) $_POST['valor1'];
    $valor2 = (int) $_POST['valor2'];

    // Atualize a linha do módulo popup_vencimento
    $stmt = $conn->prepare("UPDATE configuracao SET valor1 = ?, valor2 = ? WHERE modulo = 'popup_vencimento'");
    $stmt->bind_param("ii", $valor1, $valor2);

    if ($stmt->execute()) {
        echo "Atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar.";
    }
} else {
    echo "Dados incompletos.";
}
?>
