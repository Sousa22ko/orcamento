<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>OCR Encomendas</title>
</head>
<body>
    <h2>Enviar imagem para OCR</h2>

    <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="imagem" accept="image/*" capture="environment" required><br><br>
        <input type="submit" value="Enviar imagem">
    </form>
</body>
</html>
