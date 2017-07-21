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
        url: "/index.php/seracademico/ouvidoria/graficos/assuntoAjax",
        type: 'POST',
        dataType: 'JSON',
        data: dados,
        success: function (json) {
        grafico(json)
    }
});

});

function grafico(json) {

    $(function () {
        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Quantidade de manifestações por assunto'
            },
            xAxis: {
                categories: json[0]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total de manifestações'
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },
            tooltip: {
                headerFormat: '<b>{point.x}</b><br/>',
                pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: false,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                    }
                }
            },
            series: [{
                name: 'Quantidade',
                data: json[1]
            }]
        });
    });
}