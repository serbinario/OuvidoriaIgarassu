/**
 * Created by fabio_000 on 29/06/2017.
 */

$(document).ready(function(){

    $('#msg-sigilo').hide();

    // Exibi a mensagem de informação para caso da opção de "Deseja sigilo" esta marcada
    $('#sigilo-2, #sigilo-1').on('click', function(){
        if($("#sigilo-2").prop( "checked")) {
            $('#msg-sigilo').show();
        } else if ($("#sigilo-1").prop( "checked")) {
            $('#msg-sigilo').hide();
        }
    });

});

//Carregando os bairros
$(document).on('change', "#cidade", function () {
    //Removendo as Bairros
    $('#bairro option').remove();

    //Recuperando a cidade
    var cidade = $(this).val();

    if (cidade !== "") {
        var dados = {
            'table' : 'bairros',
            'field_search' : 'cidades_id',
            'value_search': cidade,
        }

        jQuery.ajax({
            type: 'POST',
            url: "/index.php/seracademico/util/search",
            headers: {
            'X-CSRF-TOKEN': '{{  csrf_token() }}'
        },
        data: dados,
            datatype: 'json'
    }).done(function (json) {
        var option = "";

        option += '<option value="">Selecione um bairro</option>';
        for (var i = 0; i < json.length; i++) {
            option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
        }

        $('#bairro option').remove();
        $('#bairro').append(option);
    });
}
});