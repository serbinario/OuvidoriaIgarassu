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
            {!! Form::open(['method' => "POST", 'route'=>'seracademico.ouvidoria.tabelas.melhorias',]) !!}

            <div class="block-header">
                <h2>TABELA POR MELHORIAS</h2>
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

                                <div class="form-group col-md-2">
                                    <div class="fg-line">
                                        <div class="fg-line">
                                            <?php $data = new \DateTime('now') ?>
                                            <?php $dataInicio =  isset($request['data_inicio']) ? $request['data_inicio'] : ""; ?>
                                            <label for="data_inicio">Início</label>
                                            {!! Form::text('data_inicio', $dataInicio , array('class' => 'form-control date ')) !!}
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
                                            <button class="btn btn-primary btn-sm m-t-10">Consultar</button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table compact">
                                    <thead>
                                    <tr style="background-color: #f1f3f2">
                                        <th style="text-align: center">Melhoria</th>
                                        <th style="text-align: center">Total</th>
                                        <th style="text-align: center">%</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($melhorias as $melhoria)
                                        <tr>
                                            <td>{{$melhoria->nome}} </td>
                                            <td>
                                                @foreach($rows as $row)
                                                    @if($row->melhoria == $melhoria->id)
                                                        {{$row->qtd}}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach($rows as $row)
                                                    @if($row->melhoria == $melhoria->id)
                                                        <?php
                                                        $valor = $row->qtd / $totalMelhorias;
                                                        $porcentagem = $valor * 100;
                                                        echo number_format($porcentagem, 2, ',', '.') . "%";
                                                        ?>
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr style="background-color: #f1f3f2">
                                        <td>Total geral</td>
                                        <td>{{$totalMelhorias}}</td>
                                        <td>100%</td>
                                    </tr>
                                    </tfoot>
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