// Iniciando biblioteca
var resize = new window.resize();
resize.init();

// Declarando variáveis
var imagens;
var imagem_atual;

// Quando carregado a página
$(function ($) {

    // Quando selecionado as imagens
    $('#imagem').on('change', function () {
        enviar();
    });

});

/*
 Envia os arquivos selecionados
 */
function enviar()
{
    // Verificando se o navegador tem suporte aos recursos para redimensionamento
    if (!window.File || !window.FileReader || !window.FileList || !window.Blob) {
        alert('O navegador não suporta os recursos utilizados pelo aplicativo');
        return;
    }

    // Alocando imagens selecionadas
    imagens = $('#imagem')[0].files;

    // Se selecionado pelo menos uma imagem
    if (imagens.length > 0)
    {
        // Definindo progresso de carregamento
        $('#progresso').attr('aria-valuenow', 0).css('width', '0%');

        // Escondendo campo de imagem
        $('#imagem').hide();

        // Iniciando redimensionamento
        imagem_atual = 0;
        redimensionar();
    }
}
/*
 Redimensiona uma imagem e passa para a próxima recursivamente
*/
function redimensionar()
{
    // Se redimensionado todas as imagens
    if (imagem_atual > imagens.length)
    {
        // Definindo progresso de finalizado
        $('#progresso').html('Imagen(s) enviada(s) com sucesso');

        // Limpando imagens
        limpar();

        // Exibindo campo de imagem
        $('#imagem').show();

        // Finalizando
        return;
    }

    // Se não for um arquivo válido
    if ((typeof imagens[imagem_atual] !== 'object') || (imagens[imagem_atual] == null))
    {
        // Passa para a próxima imagem
        imagem_atual++;
        redimensionar();
        return;
    }

    // Redimensionando
    resize.photo(imagens[imagem_atual], 800, 'dataURL', function (imagem) {

        // Salvando imagem no servidor
        var id = atob(atob($("#progresso").attr("data-id")));
        $.post(BASE_URL+'/home/salvarFoto', {id:id, imagem: imagem}, function(get_retorno) {

            // Definindo porcentagem
            var porcentagem = (imagem_atual + 1) / imagens.length * 100;

            // Atualizando barra de progresso
            $('#progresso').text(Math.round(porcentagem) + '%').attr('aria-valuenow', porcentagem).css('width', porcentagem + '%');

            // Aplica delay de 1 segundo
            // Apenas para evitar sobrecarga de requisições
            // e ficar visualmente melhor o progresso
            complete:
                if(get_retorno == "1") {
                    setTimeout(function () {
                        // Passa para a próxima imagem
                        imagem_atual++;
                        redimensionar();
                    }, 1000);
                }
        });

    });
}

function limpar()
{
    var input = $("#imagem");
    input.replaceWith(input.val('').clone(true));
    location.reload();
}

function validar(){
    msg = '<ul class="list-group">';
    if(validaForm() == -1){
        $("#retorno").slideDown().html(msg);
        return false;
    }else{
        return true;
    }
}

function validaForm(){
    var input = $('input');
    var primeiro = 0;
    for(i = 0; i < input.length; i++){
        var text = input[i];
        if(text.getAttribute('data-ob') == "1" && text.value == ''){
            msg = msg+'<li class="list-group-item">O campo ' + text.getAttribute('data-alt') + ' é obrigatório</li>';
            primeiro = 1;
        }
    }
    if($("#email").val() != null && $("#email").val() != ''){
        if(validaEmail($("#email").val())){
            msg = msg+'<li class="list-group-item">E-mail inválido</li>';
            primeiro = 1;
        }
    }

    msg = msg+'</ul>';
    if (primeiro == 1){
        return -1;
    } else{
        return 0;
    }
}

function validaEmail(text) {
    usuario = text.substring(0, text.indexOf("@"));
    dominio = text.substring(text.indexOf("@")+ 1, text.length);

    if ((usuario.length >=1) &&
        (dominio.length >=3) &&
        (usuario.search("@")==-1) &&
        (dominio.search("@")==-1) &&
        (usuario.search(" ")==-1) &&
        (dominio.search(" ")==-1) &&
        (dominio.search(".")!=-1) &&
        (dominio.indexOf(".") >=1)&&
        (dominio.lastIndexOf(".") < dominio.length - 1)) {
        return 0;
    }
    else{
        return -1;
    }
}