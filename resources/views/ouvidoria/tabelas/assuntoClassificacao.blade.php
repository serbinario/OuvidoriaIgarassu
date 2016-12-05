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
                <h4><i class="material-icons">find_in_page</i> TABELA DE ASSUNTO POR CLASSIFICAÇÃO</h4>
            </div>
            <div class="col-sm-6 col-md-3">
                {{--<a href="{{ route('seracademico.ouvidoria.graficos.assunto') }}" target="_blank" class="btn-sm btn-primary pull-right">Imprimir</a>--}}
            </div>
        </div>

        <div class="ibox-content">
            <table class="table">
                <thead>
                <tr>
                    <th colspan="1"></th>
                    <th colspan="5" style="text-align: center;background-color: #e7ebe9">Classificação</th>
                </tr>
                <tr style="background-color: #f1f3f2">
                    <th>Assunto</th>
                    <th>Denuncia</th>
                    <th>Elogio</th>
                    <th>Informação</th>
                    <th>Reclamação</th>
                    <th>Solicitação</th>
                    <th>Sugestão</th>
                    <th>Total Geral</th>
                    <th>%</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($array as $item)
                        <tr>
                            <td>{{$item['assunto']}}</td>
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
                            if(isset($i['Denúncia'])) {
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
                            if(isset($i['Elogio'])) {
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
                            if(isset($i['Informação'])) {
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
                            if(isset($i['Reclamação'])) {
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
                            if(isset($i['Solicitação'])) {
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
                            if(isset($i['Sugestão'])) {
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
            </table>
        </div>
    </div>
@stop

@section('javascript')
@stop