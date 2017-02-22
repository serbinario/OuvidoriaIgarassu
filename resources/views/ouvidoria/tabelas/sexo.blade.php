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
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4><i class="material-icons">find_in_page</i> TABELA POR SEXO</h4>
            </div>
            <div class="col-sm-6 col-md-3">
                {{--<a href="{{ route('seracademico.ouvidoria.graficos.assunto') }}" target="_blank" class="btn-sm btn-primary pull-right">Imprimir</a>--}}
            </div>
        </div>

        <div class="ibox-content">

            <div class="row">
                <div class="col-md-12 col-md-offset-2" >
                    {!! Form::open(['method' => "POST", 'route'=>'seracademico.ouvidoria.tabelas.sexo',]) !!}
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('secretaria', 'Secretaria *') !!}
                            {!! Form::select('secretaria',$loadFields['ouvidoria\secretaria']->toArray(), Session::getOldInput('secretaria'), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <?php $data = new \DateTime('now') ?>
                            <?php $dataInicio =  isset($request['data_inicio']) ? $request['data_inicio'] : ""; ?>
                            {!! Form::label('data_inicio', 'Início') !!}
                            {!! Form::text('data_inicio', $dataInicio , array('class' => 'form-control date datepicker')) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <?php $dataFinal =  isset($request['data_fim']) ? $request['data_fim'] : ""; ?>
                            {!! Form::label('data_fim', 'Fim') !!}
                            {!! Form::text('data_fim', $dataFinal , array('class' => 'form-control date datepicker')) !!}
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" style="margin-top: 22px" id="search" class="btn-primary btn input-sm">
                            Consultar
                        </button>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="col-md-6 col-md-offset-3">
                    <table class="table">
                        <thead>
                        <tr style="background-color: #f1f3f2">
                            <th style="text-align: center">Sexo</th>
                            <th style="text-align: center">Total</th>
                            <th style="text-align: center">%</th>
                        </tr>
                        </thead>
                            <tbody>
                            @foreach($rows as $row)
                                <tr>
                                    <td>{{$row->sexo}} </td>
                                    <td>
                                        {{$row->qtd}}
                                    </td>
                                    <td>
                                        <?php
                                            $valor = $row->qtd / $totalDemandas;
                                            $porcentagem = $valor * 100;
                                            echo number_format($porcentagem, 2, ',', '.') . "%";
                                        ?>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr style="background-color: #f1f3f2">
                                <td>Total geral</td>
                                <td>{{$totalDemandas}}</td>
                                <td>100%</td>
                            </tr>
                            </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
@stop