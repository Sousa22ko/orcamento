$('#buscar').click(function(){

    $.ajax({

        url: 'buscar_dados.php',
        type: 'GET',

        success: function(resposta){

            var dados = JSON.parse(resposta);

            $('#resultado').html(
                "Nome: " + dados.nome + "<br>" +
                "Idade: " + dados.idade
            );

        }

    });

});