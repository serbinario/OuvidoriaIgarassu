$(document).on('click', '#search', function(event){

    event.preventDefault();

    var data_inicio = $('input[name=data_inicio]').val();
    var data_fim    = $('input[name=data_fim]').val();
    var assunto    = $('select[name=assunto] option:selected').val();

    var dados = {
        'data_inicio': data_inicio,
        'data_fim': data_fim,
        'assunto' : assunto
    };

    $.ajax({
        url: "/seracademico/ouvidoria/graficos/subassuntoAjax",
        type: 'POST',
        dataType: 'JSON',
        data: dados,
        success: function (json) {
        grafico(json)
    }
});

});

function grafico (json) {
    $(function () {
        Highcharts.chart('container', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Quantidade de manifestações por subassunto'
            },
            xAxis: {
                categories: json[0],
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Subassunto',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ''
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Quantidade',
                data: json[1]
            }]
        });
    });
}

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

        $('#assunto option').remove();
        $('#assunto').append(option);
    });
}
});