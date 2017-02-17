@extends('menu')

@section('css')
    <style type="text/css" class="init">

        body {
            font-family: arial;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        table , tr , td {
            font-size: small;
        }
    </style>
@endsection

@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4><i class="material-icons">find_in_page</i> GRÁFICO DE DEMANDA POR MEIO DE ATENDIMENTO</h4>
            </div>
            <div class="col-sm-6 col-md-3">
            </div>
        </div>

        <div class="ibox-content">
            <div id="container" style=" margin: 0 auto"></div>
        </div>
    </div>
@stop

@section('javascript')
    <script src="{{ asset('/js/plugins/highcharts.js')  }}"></script>
    <script src="{{ asset('/js/plugins/exporting.js')  }}"></script>
    <script type="text/javascript">

        $(document).ready(function(){

            jQuery.ajax({
                type: 'POST',
                url: '{{route('seracademico.ouvidoria.graficos.atendimentoAjax')}}',
                datatype: 'json'
            }).done(function (json) {

                $(function () {

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

                    Highcharts.chart('container', {
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie'
                        },
                        title: {
                            text: 'DEMANDA POR MEIO DE ATENDIMENTO'
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
                });

            });
        });

    </script>
@stop