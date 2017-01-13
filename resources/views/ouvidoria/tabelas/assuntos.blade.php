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
                <h4><i class="material-icons">find_in_page</i> TABELA DE ASSUNTO E SUBASSUNTOS</h4>
            </div>
            <div class="col-sm-6 col-md-3">
                {{--<a href="{{ route('seracademico.ouvidoria.graficos.assunto') }}" target="_blank" class="btn-sm btn-primary pull-right">Imprimir</a>--}}
            </div>
        </div>

        <div class="ibox-content">
            {!! Form::open(['route'=>'seracademico.ouvidoria.tabelas.assuntos', 'method' => "POST", 'id'=> 'formDemanda' ]) !!}
            <div class="row">
                <div class="col-md-8 col-md-offset-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="assunto">Assuntos</label>
                            <select name="assunto" class="form-control" id="assunto">
                                @foreach($assuntos as $assunto)
                                    <option value="{{$assunto->id}}">{{$assunto->nome}}</option>
                                @endforeach
                            </select>
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
                    <div class="col-md-3">
                        <div class="btn-group">
                            <input type="submit" value="Pesquisar" style="margin-top: 20px; margin-left: -15px"
                                   class="btn btn-primary btn-small">
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <table class="table">
                        <thead>
                        <tr style="background-color: #e7ebe9">
                            <th colspan="3" style="text-align: center">
                                Assunto: @if(isset($assuntosFirst)) {{$assuntosFirst->nome}} @endif</th>
                        </tr>
                        <tr style="background-color: #f1f3f2">
                            <th style="text-align: center">Subassunto</th>
                            <th style="text-align: center">Total</th>
                            <th style="text-align: center">%</th>
                        </tr>
                        </thead>
                        @if(isset($rows))
                            <tbody>
                            <?php
                            $demandas = 0;
                            foreach ($rows as $row) {
                                $demandas += $row->qtd;
                            }
                            ?>
                            @foreach($subassuntos as $subassunto)
                                <tr>
                                    <td>{{$subassunto->nome}} </td>
                                    <td>
                                        @foreach($rows as $row)
                                            @if($row->subassunto == $subassunto->id)
                                                {{$row->qtd}}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($rows as $row)
                                            @if($row->subassunto == $subassunto->id)
                                                <?php
                                                $valor = $row->qtd / $demandas;
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
                                <td></td>
                                <td>{{$demandas}}</td>
                                <td>100%</td>
                            </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
@stop