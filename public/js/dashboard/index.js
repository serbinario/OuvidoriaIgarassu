$(document).ready(function () {

    jQuery.ajax({
        type: 'POST',
        url: "/index.php/seracademico/ouvidoria/graficos/statusAjax",
        datatype: 'json'
    }).done(function (json) {
        grafico1(json)
    });

    jQuery.ajax({
        type: 'POST',
        url: "/index.php/seracademico/ouvidoria/graficos/informacaoAjax",
        datatype: 'json'
    }).done(function (json) {
        grafico2(json['dados'])
        $('.title-2').text(' (' + json['qtdTotal'] + '}')
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
function grafico1(json) {
    Highcharts.chart('container-1', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'MANIFESTAÇÃO POR STATUS'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}% ({point.qtd})</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} % ({point.qtd})',
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

// Função para carregar a pizza
function grafico2(json) {
    Highcharts.chart('container-2', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'MANIFESTAÇÃO POR CLASSIFICAÇÃO DAS MANIFESTAÇÕES <span class="title-2"></span>'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}% ({point.qtd})</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} % ({point.qtd})',
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