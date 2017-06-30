
//Carregando os bairros
$(document).on('change', "#secretaria", function () {
    //Removendo as assuntos
    $('#destinatario_id option').remove();

    //Recuperando a secretaria
    var secretaria = $(this).val();

    // Habilitando e desabilitando ao selecionar "Não Encaminhar"
    if(secretaria == '1') {
        $('#respManifestacaoAjax').prop('disabled', false);
    } else {
        $('#respManifestacaoAjax').prop('disabled', true);
    }

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

            //option += '<option value="">Selecione</option>';
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

// Cadastrar manifestacao via ajax
$(document).on('click', "#respManifestacaoAjax", function () {

    var secretaria = $("#secretaria").val();
    var destino    = $("#destinatario_id").val();
    var prioridade = $("#prioridade").val();
    var assunto    = $("#assunto_id").val();
    var subassunto = $("#subassunto_id").val();
    var comentario = $("#parecer").val();
    var demanda_id = $("#demanda_id").val();
    var encaminhamento_id = $("#id").val();

    if (secretaria && destino && prioridade && parecer) {

        var dados = {
            'secretaria' : secretaria,
            'destinatario_id': destino,
            'prioridade_id': prioridade,
            'assunto_id': assunto,
            'subassunto_id': subassunto,
            'comentario': comentario,
            'demanda_id': demanda_id,
            'id': encaminhamento_id
        };

        jQuery.ajax({
            type: 'POST',
            url: "/seracademico/ouvidoria/encaminhamento/encaminharAjax",
            data: dados,
            datatype: 'json'
        }).done(function (json) {

            if (json['success']) {
                swal("Ok!", "Manifestação respondida com sucesso!", "success");

                setTimeout(function () {    //  Chama a função a cada 3 segundos
                    location.href = "/seracademico/ouvidoria/demanda/index";
                }, 2000);
            }

        });

    } else {
        swal("Ops!", "Há campo obrigatórios que não foram preenchidos!", "warning");
    }

});
