<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Controle Condominial</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  
 <style>
    /* Estilo adicional para melhorar visual das abas */
    .nav-tabs .nav-link {
      border: none;
      padding: 0.5rem 1rem;
      font-size: 1.1rem;
      background-color: #f8f9fa; /* Cor de fundo */
      color: #343a40; /* Cor do texto */
      border-radius: 10px 10px 0 0; /* Cantos arredondados na parte superior */
      transition: background-color 0.3s ease;
    }

    .nav-tabs .nav-link.active {
      background-color: #007bff; /* Cor de fundo da aba ativa */
      color: #fff; /* Cor do texto da aba ativa */
    }

    .tab-content {
      padding: 1.5rem 0;
    }

    .tab-pane {
      border-radius: 0 10px 10px 10px; /* Cantos arredondados na parte inferior do conteúdo da aba */
      border: 1px solid #dee2e6; /* Adiciona uma borda fina para separar visualmente as abas do conteúdo */
      padding: 1rem;
      margin-top: -1px; /* Remove a margem superior para alinhar com a aba superior */
    }
  </style>
  
  
</head>
<body>
  <div class="container mt-4">
    <h2 class="mb-4">Controle Condominial</h2>

    <!-- Abas -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">Proprietario</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">Inquilino</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false">Veiculos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="tab4-tab" data-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="false">Visitantes Aut</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="tab5-tab" data-toggle="tab" href="#tab5" role="tab" aria-controls="tab5" aria-selected="false">Funcionarios</a>
      </li>



    </ul>

    <!-- Conteúdo das Abas -->
    <div class="tab-content mt-3" id="myTabContent">
      <!-- Aba 1 -->
      <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
        <h4>Conteúdo da Aba 1</h4>
        <?php
          // Exemplo de conteúdo dinâmico para a Aba 1
          echo "<p>Este é o conteúdo da Aba 1 gerado dinamicamente com PHP.</p>";
        ?>
      </div>

      <!-- Aba 2 -->
      <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
        <h4>Conteúdo da Aba 2</h4>
        <?php
          // Exemplo de conteúdo dinâmico para a Aba 2
          echo "<p>Este é o conteúdo da Aba 2 gerado dinamicamente com PHP.</p>";
        ?>
      </div>

      <!-- Aba 3 -->
      <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
        <h4>Conteúdo da Aba 3</h4>
        <?php
          // Exemplo de conteúdo dinâmico para a Aba 3
          echo "<p>Este é o conteúdo da Aba 3 gerado dinamicamente com PHP.</p>";
        ?>
      </div>

      <!-- Aba 4 -->
      <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab4-tab">
        <h4>Conteúdo da Aba 4</h4>
        <?php
          // Exemplo de conteúdo dinâmico para a Aba 4
          echo "<p>Este é o conteúdo da Aba 4 gerado dinamicamente com PHP.</p>";
        ?>
      </div>

      <!-- Aba 5 -->
      <div class="tab-pane fade" id="tab5" role="tabpanel" aria-labelledby="tab5-tab">
        <h4>Conteúdo da Aba 5</h4>
        <?php
          // Exemplo de conteúdo dinâmico para a Aba 5
          echo "<p>Este é o conteúdo da Aba 5 gerado dinamicamente com PHP.</p>";
        ?>
      </div>





    </div>

  </div>

  <!-- Bootstrap JS e dependências opcionais -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

