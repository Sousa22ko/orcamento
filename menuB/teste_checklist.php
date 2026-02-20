<?php
print ('
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checklist com Soma Dinâmica</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .container { max-width: 400px; margin: 20px auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
        .item { display: flex; justify-content: space-between; padding: 5px; }
        .total { font-size: 20px; font-weight: bold; margin-top: 10px; }
    </style>
</head>
<body>

    <div class="container">
        <h2>Escolha os Itens</h2>
        <div class="item">
            <input type="checkbox" class="check" data-value="10"> Item 1 - R$10
        </div>
        <div class="item">
            <input type="checkbox" class="check" data-value="20"> Item 2 - R$20
        </div>
        <div class="item">
            <input type="checkbox" class="check" data-value="30"> Item 3 - R$30
        </div>

        <p class="total">Total: R$ <span id="total">0</span></p>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let totalElement = document.getElementById("total");
            let checkboxes = document.querySelectorAll(".check");
            let total = 0;

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener("change", function() {
                    let value = parseFloat(this.dataset.value);
                    
                    if (this.checked) {
                        total += value;  // Soma se marcado
                    } else {
                        total -= value;  // Subtrai se desmarcado
                    }

                    totalElement.textContent = total.toFixed(2);
                });
            });
        });
    </script>

</body>
</html>
');