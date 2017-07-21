//Carregando os assuntos
$(document).on('change', "#secretaria", function () {
    //Removendo as assuntos
    $('#assunto option').remove();

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

        $('#assunto option').remove();
        $('#assunto').append(option);
    });
}
});