$(document).ready(function(){

    jQuery.ajax({
        type: 'POST',
        url: "/seracademico/ouvidoria/graficos/atendimentoAjax",
        datatype: 'json'
}).done(function (json) {
    grafico(json)
});

});

$(document).on('click', '#search', function(event){

    event.preventDefault();

    var data_inicio = $('input[name=data_inicio]').val();
    var data_fim    = $('input[name=data_fim]').val();
    var secretaria    = $('select[name=secretaria] option:selected').val();

    var dados = {
        'data_inicio': data_inicio,
        'data_fim': data_fim,
        'secretaria' : secretaria
    };

    $.ajax({
        url: "/seracademico/ouvidoria/graficos/atendimentoAjax",
        type: 'POST',
        dataType: 'json',
        data: dados
}).done(function (json) {
    grafico(json)
});

});

// Radialize the colors
Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
    return {
        radialGradient: {
            cx: 0.5,
            cy: 0.3,
            r: 0.7
        },
        stops: [
            [0, color],
            [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
        ]
    };
});

// Função para carregar a pizza
function  grafico (json) {
    Highcharts.chart('container', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'MANIFESTAÇÕES POR MEIO DE REGISTRO'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Percentual',
            colorByPoint: true,
            data: json
        }]
    });
}