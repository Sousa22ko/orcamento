<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relat�rio com Bootstrap</title>
    <!-- Incluindo Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        /* Estilo para letras pequenas */
        .small-font {
            font-size: small;
        }
        /* Reduzindo espa�amento entre linhas e c�lulas da tabela */
        .custom-table {
            border-collapse: collapse;
            border-spacing: 0;
        }
    </style>
    
    
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Relat�rio</h2>

        <!-- Tabela utilizando Bootstrap -->
        <div class="row">
            <div class="col">
                <table class="table table-bordered table-sm custom-table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Coluna 1</th>
                            <th scope="col">Coluna 2</th>
                            <th scope="col">Coluna 3</th>
                            <th scope="col">Coluna 4</th>
                            <th scope="col">Coluna 5</th>
                        </tr>
                    </thead>
                    <tbody>
                    

                        <?php
                        // Loop para criar 3 linhas
                        for ($i = 1; $i <= 3; $i++) {
                            echo '<tr>';
                            // Loop para criar 5 colunas
                            for ($j = 1; $j <= 5; $j++) {
                                echo '<td class="small-font">Linha ' . $i . ', Coluna ' . $j . '</td>';
                            }
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Incluindo Bootstrap JS (opcional) para funcionalidades extras -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

