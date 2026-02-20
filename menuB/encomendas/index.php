<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Leitor de Etiquetas - OCR</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/tesseract.js@4.0.2/dist/tesseract.min.js"></script>
 
 <style>
    video, canvas, img {
      max-width: 100%;
      border: 1px solid #ccc;
      margin-bottom: 15px;
    }
  </style>
  
</head>
<body class="container">
  <h2 class="text-center">Captura de Etiqueta</h2>

  <div class="row">
    <div class="col-md-6">
      <!-- <video id="video" width="100%" autoplay></video> -->
      <input type='file' aaccept='image/*' capture='environment' onchange='handleFile(this)' class="btn btn-primary btn-block">
      <!-- <button class="btn btn-primary btn-block" onclick="tirarFoto()">Capturar Foto</button> -->
    </div>
    <div class="col-md-6">
      <canvas id="canvas" width="400" height="300" style="display: none;"></canvas>
      <img id="preview" alt="Prévia da imagem">
    </div>
  </div>

  <div class="form-group">
    <label for="resultado">Texto reconhecido (OCR):</label>
    <textarea id="resultado" class="form-control" rows="6"></textarea>
  </div>

  <h4>Dados extraídos</h4>
  <form id="formDados" action="salvar.php" method="post">
    <div class="form-group">
      <label>Nome:</label>
      <input type="text" name="nome" id="nome" class="form-control">
    </div>
    <div class="form-group">
      <label>Endereço:</label>
      <input type="text" name="endereco" id="endereco" class="form-control">
    </div>
    <div class="form-group">
      <label>Número da casa:</label>
      <input type="text" name="casa" id="casa" class="form-control">
    </div>
    <div class="form-group">
      <label>Remetente:</label>
      <input type="text" name="remetente" id="remetente" class="form-control">
    </div>
    <div class="form-group">
      <label>Código de Pedido:</label>
      <input type="text" name="codigo" id="codigo" class="form-control">
    </div>
    <button type="submit" class="btn btn-success">Salvar dados</button>
  </form>

  <script>
    // Iniciar câmera
    // const video = document.getElementById('video');
    // console.log(navigator);
    // navigator.mediaDevices.getUserMedia({ video: true })
    //   .then(stream => video.srcObject = stream)
    //   .catch(err => alert('Erro ao acessar a câmera'));

    function handleFile(file) {
      Tesseract.recognize(URL.createObjectURL(file.files[0]), 'por', { logger: m => console.log(m) })
        .then(({ data: { text } }) => {
          alert('sucesso')
          document.getElementById('resultado').value = text;
          extrairCampos(text);
        }).catch(err => { alert(err)});
    }

    // Tirar foto e processar com OCR
    // function tirarFoto() {
    //   const canvas = document.getElementById('canvas');
    //   const context = canvas.getContext('2d');
    //   context.drawImage(video, 0, 0, canvas.width, canvas.height);

    //   const imgData = canvas.toDataURL('image/png');
    //   document.getElementById('preview').src = imgData;

    //   Tesseract.recognize(imgData, 'por', { logger: m => console.log(m) })
    //     .then(({ data: { text } }) => {
    //       document.getElementById('resultado').value = text;
    //       extrairCampos(text);
    //     });
    // }

    // Regex simples para extrair dados do texto
    function extrairCampos(texto) {
      const nome = texto.match(/(?:Destinat[áa]rio[:\s]*)?([A-ZÀ-Ü\s]{5,})/i);
      const endereco = texto.match(/(Rua|R\.|Av|Trav)[^\n]{5,40}/i);
      const codigo = texto.match(/[A-Z]{2}[0-9]{9}[A-Z]{2}/i) || texto.match(/\d{10,}/);

      document.getElementById('nome').value = nome ? nome[1].trim() : '';
      document.getElementById('endereco').value = endereco ? endereco[0].trim() : '';

      const casa = endereco ? endereco[0].match(/\d{1,5}/) : null;
      document.getElementById('casa').value = casa ? casa[0] : '';

      document.getElementById('codigo').value = codigo ? codigo[0] : '';

      // Remetente simples: primeira palavra grande
      const remetente = texto.split('\n')[0].trim();
      document.getElementById('remetente').value = remetente;
    }
  </script>
</body>
</html>
