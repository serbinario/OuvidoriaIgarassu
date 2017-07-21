$(document).ready(function(){

    $.ajax({
        url: "/index.php/seracademico/ouvidoria/graficos/caracteristicasAjax",
        type: 'POST',
        dataType: 'JSON',
        success: function (json) {
        grafico(json)
    }
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
        url: "/index.php/seracademico/ouvidoria/graficos/caracteristicasAjax",
        type: 'POST',
        dataType: 'JSON',
        data: dados,
        success: function (json) {
        grafico(json)
    }
});

});

// gerar gráfico
function grafico(json) {
    $(function () {
        Highcharts.chart('container', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Quantidade de manifestações por característica'
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
                    text: 'Características',
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
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -40,
                y: 80,
                floating: true,
                borderWidth: 1,
                backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
                shadow: true
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