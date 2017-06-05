@extends('menu')

@section('content')

    <section id="content">
        <div class="container">

            <div class="mini-charts">
                <div class="row">
                    <div class="col-sm-6 col-md-3">
                        <a href="{{route('seracademico.ouvidoria.demanda.index', ['status' => '1' ])}}">
                            <div class="mini-charts-item bgm-cyan ">
                                <div class="clearfix">
                                    <div class=""></div>
                                    <div class="count">
                                        <small>Manifestações a serem analisadas</small>
                                        <h2>{{$novas->novas}}</h2>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <a href="{{route('seracademico.ouvidoria.demanda.index', ['status' => '2' ])}}">
                            <div class="mini-charts-item bgm-orange">
                                <div class="clearfix">
                                    <div class=""></div>
                                    <div class="count">
                                        <small>Manifestações em análise</small>
                                        <h2>{{$analises->analises}}</h2>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <a href="{{route('seracademico.ouvidoria.demanda.index', ['status' => '3' ])}}">
                            <div class="mini-charts-item bgm-lightgreen">
                                <div class="clearfix">
                                    <div class=""></div>
                                    <div class="count">
                                        <small>Manifestações concluídas</small>
                                        <h2>{{$concluidas->concluidas}}</h2>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <a href="{{route('seracademico.ouvidoria.demanda.index', ['status' => '6' ])}}">
                            <div class="mini-charts-item bgm-red">
                                <div class="clearfix">
                                    <div class=""></div>
                                    <div class="count">
                                        <small>Manifestações atrasadas</small>
                                        <h2>{{$atrasadas->atrasadas}}</h2>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body card-padding">
                            <div class="row">
                                <div class="col-6-md">
                                    <div id="container-1" style=" margin: 0 auto"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body card-padding">
                            <div class="row">
                                <div class="col-6-md">
                                    <div id="container-2" style=" margin: 0 auto"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@stop

@section('javascript')
    <script src="{{ asset('/js/plugins/highcharts.js')  }}"></script>
    <script src="{{ asset('/js/plugins/exporting.js')  }}"></script>
    <script type="text/javascript">

        $(document).ready(function(){

            jQuery.ajax({
                type: 'POST',
                url: '{{route('seracademico.ouvidoria.graficos.statusAjax')}}',
                datatype: 'json'
            }).done(function (json) {
                grafico1(json)
            });

            jQuery.ajax({
                type: 'POST',
                url: '{{route('seracademico.ouvidoria.graficos.informacaoAjax')}}',
                datatype: 'json'
            }).done(function (json) {
                grafico2(json)
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
        function grafico1 (json) {
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

        // Função para carregar a pizza
        function grafico2 (json) {
            Highcharts.chart('container-2', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'MANIFESTAÇÃO POR CLASSIFICAÇÃO DAS MANIFESTAÇÕES'
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