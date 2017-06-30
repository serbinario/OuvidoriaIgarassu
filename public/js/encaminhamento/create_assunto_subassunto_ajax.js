// Cadastrar assunto
$(document).on('click', "#salvar-assunto", function () {

    var nome = $("#nome-assunto").val();
    var area = $("#secretaria").val();

    if (nome && area) {

        var dados = {
            'nome': nome,
            'area_id': area
        };

        jQuery.ajax({
            type: 'POST',
            url: "/seracademico/ouvidoria/assunto/storeAjax",
            data: dados,
            datatype: 'json'
        }).done(function (json) {

            if (json['success']) {
                swal("Ops!", "Assunto cadastrado com sucesso!", "success");
                $('#modal_assunto').modal('toggle');
                $("#nome-assunto").val("");

                var dados = {
                    'table': 'ouv_assunto',
                    'field_search': 'area_id',
                    'value_search': area,
                };

                loadAssuntos(dados);
            }

        });

    } else {
        swal("Ops!", "Você deve ter selecionado uma secretaria e informa o nome do assunto!", "warning");
    }

});

// Cadastrar subassunto
$(document).on('click', "#salvar-subassunto", function () {

    var nome = $("#nome-subassunto").val();
    var assunto = $("#assunto_id").val();

    if (nome && assunto) {

        var dados = {
            'nome': nome,
            'assunto_id': assunto
        };

        jQuery.ajax({
            type: 'POST',
            url: "/seracademico/ouvidoria/subassunto/storeAjax",
            data: dados,
            datatype: 'json'
        }).done(function (json) {

            if (json['success']) {
                swal("Ops!", "Subassunto cadastrado com sucesso!", "success");
                $('#modal_subassunto').modal('toggle');
                $("#nome-subassunto").val("");

                var dados = {
                    'table': 'ouv_subassunto',
                    'field_search': 'assunto_id',
                    'value_search': assunto,
                };

                loadSubassuntos(dados);
            }

        });

    } else {
        swal("Ops!", "Você deve ter selecionado um assunto e informa o nome do subassunto!", "warning");
    }

});