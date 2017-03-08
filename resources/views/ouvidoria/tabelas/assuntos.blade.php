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

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: small;
        }

        th {
            background-color:#CCC;
            font-size: 12px;
            color:#484848;
            padding-left:4px;
            padding-right:4px;
            border-bottom:solid 1px #CCC;
            height:26px;
            padding-right:5px;

        }
        tr:nth-child(odd) {
            background-color:#F3F3F3;
        }

        tr:nth-child(even) {
            background-color:#FFF;

        }

        tr, td {
            height:26px;
            padding-left:4px;
            padding-right:2px;
            font-family:Verdana, Geneva, sans-serif;
            font-size:12px;
            white-space:nowrap;
            border-bottom:solid 1px #E1E1E1;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <section id="content">
            {{-- Mensagem de alerta quando os dados não atendem as regras de validação que foramd efinidas no servidor --}}
            <div class="ibox-content">
                @if(Session::has('message'))
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <em> {!! session('message') !!}</em>
                    </div>
                @endif

                @if(Session::has('errors'))
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
            </div>
            {{-- Fim mensagem de alerta --}}
            {{--Formulario--}}
            {!! Form::open(['route'=>'seracademico.ouvidoria.tabelas.assuntos', 'method' => "POST", 'id'=> 'formDemanda' ]) !!}

            <div class="block-header">
                <h2>TABELA DE ASSUNTO E SUBASSUNTOS</h2>
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
                                            {!! Form::select('secretaria',$loadFields['ouvidoria\secretaria']->toArray(), Session::getOldInput('secretaria'), array('class' => 'form-control', 'id' => 'secretaria')) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <div class="fg-line">
                                        <div class="fg-line">
                                            <label for="assunto">Assuntos</label>
                                            <select name="assunto" class="form-control" id="assunto">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <div class="fg-line">
                                        <div class="fg-line">
                                            <?php $data = new \DateTime('now') ?>
                                            <?php $dataInicio =  isset($request['data_inicio']) ? $request['data_inicio'] : ""; ?>
                                            <label for="data_inicio">Início</label>
                                            {!! Form::text('data_inicio', $dataInicio , array('class' => 'form-control date')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <div class="fg-line">
                                        <div class="fg-line">
                                            <?php $dataFinal =  isset($request['data_fim']) ? $request['data_fim'] : ""; ?>
                                            <label for="data_fim">Fim</label>
                                            {!! Form::text('data_fim', $dataFinal , array('class' => 'form-control date')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div style="margin-top: 22px" class="form-group col-md-2">
                                    <div class="fg-line">
                                        <div class="fg-line">
                                            <button class="btn btn-primary btn-sm m-t-10">Consultar</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table compact table-condensed">
                                    <thead>
                                    <tr style="background-color: #e7ebe9">
                                        <th colspan="9"  style="text-align: center">
                                            Assunto: @if(isset($assuntosFirst)) {{$assuntosFirst->nome}} @endif</th>
                                    </tr>
                                    <tr>
                                        <th colspan="1"></th>
                                        <th colspan="6" style="text-align: center;background-color: #e7ebe9">Classificação</th>
                                    </tr>
                                    <tr class="info">
                                        <th>Subassunto</th>
                                        <th>Denúncia</th>
                                        <th>Elogio</th>
                                        <th>Informação</th>
                                        <th>Reclamação</th>
                                        <th>Solicitação</th>
                                        <th>Sugestão</th>
                                        <th>Total Geral</th>
                                        <th>%</th>
                                    </tr>
                                    </thead>
                                    @if(isset($array))
                                        <tbody>
                                        @foreach($array as $item)
                                            <tr>
                                                <td>{{$item['subassunto']}}</td>
                                                <td>
                                                    @if(isset($item['Denúncia']))
                                                        {{$item['Denúncia']}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($item['Elogio']))
                                                        {{$item['Elogio']}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($item['Informação']))
                                                        {{$item['Informação']}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($item['Reclamação']))
                                                        {{$item['Reclamação']}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($item['Solicitação']))
                                                        {{$item['Solicitação']}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($item['Sugestão']))
                                                        {{$item['Sugestão']}}
                                                    @endif
                                                </td>
                                                <td>
                                                    {{$item['totalGeral']}}
                                                </td>
                                                <td>
                                                    <?php
                                                    $valor = $item['totalGeral'] / $totalDemandas;
                                                    $porcentagem = $valor * 100;
                                                    echo number_format($porcentagem, 2, ',', '.') . "%";
                                                    ?>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr style="background-color: #f1f3f2">
                                            <th></th>
                                            <th>
                                                <?php
                                                $denuncia = 0;
                                                foreach ($array as $i) {
                                                    if (isset($i['Denúncia'])) {
                                                        $denuncia += $i['Denúncia'];
                                                    }
                                                }
                                                echo $denuncia;
                                                ?>
                                            </th>
                                            <th>
                                                <?php
                                                $elogio = 0;
                                                foreach ($array as $i) {
                                                    if (isset($i['Elogio'])) {
                                                        $elogio += $i['Elogio'];
                                                    }
                                                }
                                                echo $elogio;
                                                ?>
                                            </th>
                                            <th>
                                                <?php
                                                $informacao = 0;
                                                foreach ($array as $i) {
                                                    if (isset($i['Informação'])) {
                                                        $informacao += $i['Informação'];
                                                    }
                                                }
                                                echo $informacao;
                                                ?>
                                            </th>
                                            <th>
                                                <?php
                                                $reclamacao = 0;
                                                foreach ($array as $i) {
                                                    if (isset($i['Reclamação'])) {
                                                        $reclamacao += $i['Reclamação'];
                                                    }
                                                }
                                                echo $reclamacao;
                                                ?>
                                            </th>
                                            <th>
                                                <?php
                                                $solicitacao = 0;
                                                foreach ($array as $i) {
                                                    if (isset($i['Solicitação'])) {
                                                        $solicitacao += $i['Solicitação'];
                                                    }
                                                }
                                                echo $solicitacao;
                                                ?>
                                            </th>
                                            <th>
                                                <?php
                                                $sugestao = 0;
                                                foreach ($array as $i) {
                                                    if (isset($i['Sugestão'])) {
                                                        $sugestao += $i['Sugestão'];
                                                    }
                                                }
                                                echo $sugestao;
                                                ?>
                                            </th>
                                            <th>
                                                {{$totalDemandas}}
                                            </th>
                                            <th>
                                                100%
                                            </th>
                                        </tr>
                                        </tfoot>
                                    @endif
                                </table>
                            </div>
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
    <script type="text/javascript">
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
                    url: '{{ route('seracademico.util.search')  }}',
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
    </script>
@stop