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
                <h4><i class="material-icons">find_in_page</i> GRÁFICO DE ASSUNTOS DA DEMANDA</h4>
            </div>
            {{--<div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.ouvidoria.graficos.assunto') }}" target="_blank" class="btn-sm btn-primary pull-right">Imprimir</a>
            </div>--}}
        </div>

        <div class="ibox-content">
            <div id="container" style="margin: 0 auto"></div>
        </div>
    </div>
@stop

@section('javascript')
    <script src="{{ asset('/js/plugins/highcharts.js')  }}"></script>
    <script src="{{ asset('/js/plugins/exporting.js')  }}"></script>
    <script type="text/javascript">

        $(document).ready(function(){

            $.ajax({
                url: '{{route('seracademico.ouvidoria.graficos.assuntoAjax')}}',
                type: 'POST',
                dataType: 'JSON',
                success: function (json) {


                    $(function () {
                        Highcharts.chart('container', {
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: 'Quantidade de demandas por assuntos'
                            },
                            xAxis: {
                                categories: json[0]
                            },
                            yAxis: {
                                min: 0,
                                title: {
                                    text: 'Total de demandas'
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
            });
        });

    </script>
@stop