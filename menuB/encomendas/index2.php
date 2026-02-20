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
    #loading {
      display: none;
      font-weight: bold;
      color: #337ab7;
    }
  </style>
</head>
<body class="container">
  <h2 class="text-center">Captura de Etiqueta</h2>

  <div class="row">
    <div class="col-md-6">
      <input type="file" accept="image/*" capture="environment" onchange="handleFile(this)" class="btn btn-primary btn-block">
    </div>
    <div class="col-md-6">
      <canvas id="canvas" width="400" height="300" style="display: none;"></canvas>
      <img id="preview" alt="Prévia da imagem processada">
    </div>
  </div>

  <div id="loading" class="text-center">🕐 Processando imagem, por favor aguarde...</div>

  <div class="form-group">
    <label for="resultado">Texto reconhecido (OCR):</label>
    <textarea id="resultado" class="form-control" rows="6" readonly></textarea>
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
    function handleFile(input) {
      const file = input.files[0];
      if (!file) return;

      document.getElementById('loading').style.display = 'block';

      const img = new Image();
      img.src = URL.createObjectURL(file);
      img.onload = () => {
        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');

        // Ajustar o tamanho do canvas para a imagem
        canvas.width = img.width;
        canvas.height = img.height;
        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

        // Obter dados da imagem e aplicar pré-processamento
        const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
        const data = imageData.data;

        for (let i = 0; i < data.length; i += 4) {
          const r = data[i];
          const g = data[i + 1];
          const b = data[i + 2];
          const avg = (r + g + b) / 3;
          const bin = avg > 140 ? 255 : 0; // binarização simples (threshold)
          data[i] = data[i + 1] = data[i + 2] = bin;
        }

        ctx.putImageData(imageData, 0, 0);

        // Mostrar a imagem processada
        const imgDataURL = canvas.toDataURL('image/png');
        document.getElementById('preview').src = imgDataURL;

        // OCR
        Tesseract.recognize(imgDataURL, 'por', {
          logger: m => console.log(m)
        })
        .then(({ data: { text } }) => {
          document.getElementById('loading').style.display = 'none';
          document.getElementById('resultado').value = text;
          extrairCampos(text);
        })
        .catch(err => {
          document.getElementById('loading').style.display = 'none';
          alert('Erro ao reconhecer texto: ' + err);
        });
      };
    }

    function extrairCampos(texto) {
      const nome = texto.match(/(?:Destinat[áa]rio[:\s]*)?([A-ZÀ-Ü\s]{5,})/i);
      const endereco = texto.match(/(Rua|R\.|Av|Trav)[^\n]{5,40}/i);
      const codigo = texto.match(/[A-Z]{2}[0-9]{9}[A-Z]{2}/i) || texto.match(/\d{10,}/);

      document.getElementById('nome').value = nome ? nome[1].trim() : '';
      document.getElementById('endereco').value = endereco ? endereco[0].trim() : '';

      const casa = endereco ? endereco[0].match(/\d{1,5}/) : null;
      document.getElementById('casa').value = casa ? casa[0] : '';

      document.getElementById('codigo').value = codigo ? codigo[0] : '';

      const remetente = texto.split('\n').filter(l => l.trim().length > 5)[0] || '';
      document.getElementById('remetente').value = remetente.trim();
    }
  </script>
</body>
</html>
