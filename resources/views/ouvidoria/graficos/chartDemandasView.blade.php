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
        table, tr, td {
            font-size: small;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <section id="content">
            {{-- Mensagem de alerta quando os dados não atendem as regras de validação que foramd efinidas no servidor --}}
            <div class="ibox-content">
            </div>
            {{-- Fim mensagem de alerta --}}
            {{--Formulario--}}
            {!! Form::open(['method' => "POST"]) !!}

            <div class="block-header">
                <h2>GRÁFICO DE MANIFESTAÇÕES</h2>
            </div>
            <div class="card">
                <div class="card-body card-padding">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">

                                <div class="form-group col-md-4">
                                    <div class="fg-line">
                                        <div class="fg-line">
                                            <label for="secretaria">Secretaria *</label>
                                            {!! Form::select('secretaria',(["" => "Selecione uma secretaria"] + $loadFields['ouvidoria\secretaria']->toArray()), Session::getOldInput('secretaria'), array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-2">
                                    <div class="fg-line">
                                        <div class="fg-line">
                                            <?php $data = new \DateTime('now') ?>
                                            <label for="data_inicio">Início</label>
                                            {!! Form::text('data_inicio', null , array('class' => 'form-control date ')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <div class="fg-line">
                                        <div class="fg-line">
                                            <?php $dataFinal =  isset($request['data_fim']) ? $request['data_fim'] : ""; ?>
                                            <label for="data_fim">Fim</label>
                                            {!! Form::text('data_fim', $dataFinal , array('class' => 'form-control date ')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div style="margin-top: 22px" class="form-group col-md-2">
                                    <div class="fg-line">
                                        <div class="fg-line">
                                            <button id="search" class="btn btn-primary btn-sm m-t-10">Consultar</button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="col-12-md">
                            <div id="container" style=" margin: 0 auto"></div>
                        </div>
                    </div>
                </div>
            </div>

            {!! Form::close() !!}
            {{--Fim formulario--}}
        </section>
    </div>
@stop

@section('javascript')
    <script src="{{ asset('/js/plugins/highcharts.js')  }}"></script>
    <script src="{{ asset('/js/plugins/exporting.js')  }}"></script>
    <script type="text/javascript">

        $(document).ready(function(){

            $.ajax({
                url: '{{route('seracademico.ouvidoria.graficos.demandasAjax')}}',
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
                url: '{{route('seracademico.ouvidoria.graficos.demandasAjax')}}',
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
                        text: 'Quantidade de manifestações'
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

    </script>
@stop