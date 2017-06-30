
//Carregando os bairros
$(document).on('change', "#secretaria", function () {
    //Removendo as assuntos
    $('#destinatario_id option').remove();

    //Recuperando a secretaria
    var secretaria = $(this).val();

    if (secretaria !== "") {

        var dados = {
            'table': 'ouv_destinatario',
            'field_search': 'area_id',
            'value_search': secretaria,
        };

        jQuery.ajax({
            type: 'POST',
            url: "/seracademico/util/search",
            data: dados,
            datatype: 'json'
        }).done(function (json) {
            var option = "";

            option += '<option value="">Selecione</option>';
            for (var i = 0; i < json.length; i++) {
                option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
            }

            $('#destinatario_id option').remove();
            $('#destinatario_id').append(option);
        });
    }
});

// Funcção para carregar os assunto
function loadAssuntos(dados) {

    //Removendo as assuntos
    $('#assunto_id option').remove();

    jQuery.ajax({
        type: 'POST',
        url: "/seracademico/util/search",
        headers: {
            'X-CSRF-TOKEN': '{{  csrf_token() }}'
        },
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

//Carregando os assuntos
$(document).on('change', "#secretaria", function () {

    //Recuperando a secretaria
    var secretaria = $(this).val();

    if (secretaria !== "") {

        var dados = {
            'table': 'ouv_assunto',
            'field_search': 'area_id',
            'value_search': secretaria,
        };

        loadAssuntos(dados);
    }
});


// Função para carregar os subassuntos
function loadSubassuntos(dados) {

    //Removendo as Bairros
    $('#subassunto_id option').remove();

    jQuery.ajax({
        type: 'POST',
        url: "/seracademico/util/search",
        headers: {
            'X-CSRF-TOKEN': '{{  csrf_token() }}'
        },
        data: dados,
        datatype: 'json'
    }).done(function (json) {
        var option = "";

        option += '<option value="">Selecione um subassunto</option>';
        for (var i = 0; i < json.length; i++) {
            option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
        }

        $('#subassunto_id option').remove();
        $('#subassunto_id').append(option);
    });

}

//Carregando os subassunto
$(document).on('change', "#assunto_id", function () {

    //Recuperando a cidade
    var assunto = $(this).val();

    if (assunto !== "") {
        var dados = {
            'table': 'ouv_subassunto',
            'field_search': 'assunto_id',
            'value_search': assunto
        };

        loadSubassuntos(dados);
    }
});

//Carregando os bairros
$(document).on('change', "#cidade", function () {
    //Removendo as Bairros
    $('#bairro option').remove();

    //Recuperando a cidade
    var cidade = $(this).val();

    if (cidade !== "") {
        var dados = {
            'table': 'bairros',
            'field_search': 'cidades_id',
            'value_search': cidade
        }

        jQuery.ajax({
            type: 'POST',
            url: "/seracademico/util/search",
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