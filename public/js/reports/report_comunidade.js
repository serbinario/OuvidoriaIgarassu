//Carregando os bairros
$(document).on('change', "#cidade", function () {
    //Removendo as Bairros
    $('#bairro option').remove();

    //Recuperando a cidade
    var cidade = $(this).val();

    if (cidade !== "") {
        var dados = {
            'table' : 'gen_bairros',
            'field_search' : 'cidades_id',
            'value_search': cidade,
        }

        jQuery.ajax({
            type: 'POST',
            url: "/index.php/seracademico/util/search",
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