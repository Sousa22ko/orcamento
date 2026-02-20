<?php
require_once("config.php");
require("functions.inc");

$conn = conectar();

// Recebe dados (simulados ou vindos do formulário real)
$despesa    = $_POST['despesa'] ?? 'Desp002';
$novadata   = $_POST['data'] ?? '2025-05-21';
$valor      = $_POST['valor'] ?? 130.21;
$ocorrencia = $_POST['ocorrencia'] ?? '2506';
$confirmado = $_POST['confirmado'] ?? '';
/*$despesa    =  'Desp002';
$novadata   =  '2025-05-21';
$valor      =  130.21;
$ocorrencia =  '2506';
$confirmado =  '';
*/


//if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($confirmado === '') {
        // Passo 1: verifica duplicidade
        $sql = "SELECT * FROM despesa WHERE despesa = ? AND data = ? AND valor_casa = ? AND ocorrencia = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssds", $despesa, $novadata, $valor, $ocorrencia);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Encontrou duplicidade: pergunta ao usuário
            ?>
            <script>
              window.onload = function () {
            if (confirm("Já existe uma despesa com os mesmos dados. Deseja continuar?")) {
                // Reenvia ao mesmo arquivo com confirmado = 1
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = 'teste_incluir.php';

                var dados = {
                    despesa: <?= json_encode($despesa) ?>,
                    data: <?= json_encode($novadata) ?>,
                    valor: <?= json_encode($valor) ?>,
                    ocorrencia: <?= json_encode($ocorrencia) ?>,
                    confirmado: '1'
                };

                for (var k in dados) {
                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = k;
                    input.value = dados[k];
                    form.appendChild(input);
                }

                console.log(form)
                console.log(document)
                document.body.appendChild(form);

                // document.body.appendChild(form);
                //document.forms['form'].submit();
                form.submit();
            } else {
                alert("Operação cancelada pelo usuário.");
                window.location.href = 'formulario.php'; // Ou qualquer página de volta
            }
          }
            </script>
            <?php
            exit;
           
        }
    }

    // Se não encontrou duplicidade ou já foi confirmado:
    if ($confirmado === '1' || $stmt->num_rows === 0) {
        // Executa o INSERT
        $sql = "INSERT INTO despesa (despesa, data, valor_casa, ocorrencia) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssds", $despesa, $novadata, $valor, $ocorrencia);
        if ($stmt->execute()) {
            echo "<p>Despesa inserida com sucesso!</p>";
        } else {
            echo "<p>Erro ao inserir despesa: " . $stmt->error . "</p>";
        }
 //   }
}
?>
