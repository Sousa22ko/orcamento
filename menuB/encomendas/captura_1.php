<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Foto para o servidor</title>
</head>
<body>
    <h2>Tirar foto e enviar para o servidor</h2>

    <form action="upload_1.php" method="post" enctype="multipart/form-data">
        <label for="imagem">Clique para tirar foto:</label><br><br>
        <input type="file" name="imagem" accept="image/*" capture="environment" required><br><br>

        <input type="submit" value="Enviar imagem">
    </form>
</body>
</html>
