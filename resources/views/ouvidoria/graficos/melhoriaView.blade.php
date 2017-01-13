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
                <h4><i class="material-icons">find_in_page</i> GRÁFICO DE DEMANDA POR RECLAMAÇÃO X MELHORIA</h4>
            </div>
            <div class="col-sm-6 col-md-3">
            </div>
        </div>

        <div class="ibox-content">
            <div class="row">
                {!! Form::open(['method' => "POST"]) !!}
                <div class="col-md-12">
                    <div class="col-md-2">
                        <div class="form-group">
                            <?php $data = new \DateTime('now') ?>
                            {!! Form::label('data_inicio', 'Início') !!}
                            {!! Form::text('data_inicio', null , array('class' => 'form-control date datepicker')) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('data_fim', 'Fim') !!}
                            {!! Form::text('data_fim', null , array('class' => 'form-control date datepicker')) !!}
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <button type="button" style="margin-top: 22px" id="search" class="btn-primary btn input-sm">Consultar</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div><br />
            <div class="row">
                <div id="container" style=" margin: 0 auto"></div>
            </div>
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
                url: '{{route('seracademico.ouvidoria.graficos.melhoriaAjax')}}',
                datatype: 'json'
            }).done(function (json) {
                grafico(json)
            });
        });

        $(document).on('click', '#search', function(){

            var data_inicio = $('input[name=data_inicio]').val();
            var data_fim    = $('input[name=data_fim]').val();

            var dados = {
                'data_inicio': data_inicio,
                'data_fim': data_fim
            };

            $.ajax({
                url: '{{route('seracademico.ouvidoria.graficos.melhoriaAjax')}}',
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
        function grafico (json) {
            Highcharts.chart('container', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'DEMANDA POR RECLAMAÇÃO x MELHORIA'
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

    </script>
@stop