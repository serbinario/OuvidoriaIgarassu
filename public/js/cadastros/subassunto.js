//Carregando os bairros
$(document).on('change', "#secretaria", function () {
    //Removendo as assuntos
    $('#assunto_id option').remove();

    //Recuperando a secretaria
    var secretaria = $(this).val();

    if (secretaria !== "") {
        var dados = {
            'table' : 'ouv_assunto',
            'field_search' : 'area_id',
            'value_search': secretaria,
        };

        jQuery.ajax({
            type: 'POST',
            url: "/index.php/seracademico/util/search",
        data: dados,
            datatype: 'json'
    }).done(function (json) {
        var option = "";

        option += '<option value="">Selecione um assunto</option>';
        for (var i = 0; i < json.length; i++) {
            option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
        }

        $('#assunto_id option').remove();
        $('#assunto_id').append(option);
    });
}
});