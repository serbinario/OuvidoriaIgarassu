@extends('menu')

@section('css')
    <style type="text/css" class="init">
        td.details-control {
            background: url({{asset("/imagemgrid/icone-produto-plus.png")}}) no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url({{asset("/imagemgrid/icone-produto-minus.png")}}) no-repeat center center;
        }


        a.visualizar {
            background: url({{asset("/imagemgrid/impressao.png")}}) no-repeat 0 0;
            width: 23px;
        }

        td.bt {
            padding: 10px 0;
            width: 126px;
        }

        td.bt a {
            float: left;
            height: 22px;
            margin: 0 10px;
        }
        .highlight {
            background-color: #FE8E8E;
        }
    </style>
@endsection

@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4><i class="material-icons">find_in_page</i> Detalhe do encaminhamento</h4>
            </div>
        </div>
        <div class="ibox-content">

            @if(Session::has('error'))
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <em> {!! session('message') !!}</em>
                    </div>
                @endif

                @if(Session::has('message'))
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <em> {!! session('message') !!}</em>
                    </div>
                @endif

                <div class="row">
                    <div class="col-lg-12 animated fadeInRight">
                        <div class="mail-box-header">
                            <div class="pull-right tooltip-demo">
                                <button type="button" class="btn btn-white btn-sm"
                                   data-placement="top" title="Reply" data-toggle="modal" data-target="#modal_responder_encaminhamento"><i class="fa fa-reply"></i> Responder</button>
                            </div>
                            <h2>
                                View Message
                            </h2>
                            <div class="mail-tools tooltip-demo m-t-md">
                                <h3>
                                    <span class="font-noraml">Subject: </span>Aldus PageMaker including versions of
                                    Lorem
                                    Ipsum.
                                </h3>
                                <h5>
                                    <span class="pull-right font-noraml">10:15AM 02 FEB 2014</span>
                                    <span class="font-noraml">From: </span>alex.smith@corporation.com
                                </h5>
                            </div>
                        </div>
                        <div class="mail-box">
                            <div class="mail-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table id="encaminhamento-grid" class="display table compact table-bordered" cellspacing="0" width="100%">
                                                <tbody>
                                                <tr>
                                                    <td style="width: 16%; background-color: #cecece">Código</td>
                                                    <td>{{$detalheEncaminhamento->codigo}}</td>
                                                </tr>
                                                <tr>
                                                    <td  style="background-color: #cecece">Data</td>
                                                    <td>{{$detalheEncaminhamento->data}}</td>
                                                </tr>
                                                <tr>
                                                    <td  style="background-color: #cecece">Previsão</td>
                                                    <td>{{$detalheEncaminhamento->previsao}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="background-color: #cecece">Prioridade</td>
                                                    <td>{{$detalheEncaminhamento->prioridade}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="background-color: #cecece">Secretaria</td>
                                                    <td>{{$detalheEncaminhamento->area}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="background-color: #cecece">Departamento/Destinatário</td>
                                                    <td>{{$detalheEncaminhamento->destinatario}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="background-color: #cecece">Encaminhado</td>
                                                    <td>{{$detalheEncaminhamento->encaminhado}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="background-color: #cecece">Parecer</td>
                                                    <td>{{$detalheEncaminhamento->parecer}}</td>
                                                </tr>
                                                @if($detalheEncaminhamento->resposta)
                                                    <tr>
                                                        <td style="background-color: #cecece">Resposta</td>
                                                        <td>{{$detalheEncaminhamento->resposta}}</td>
                                                    </tr>
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mail-body text-right tooltip-demo">
                                <button class="btn btn-sm btn-white" type="button" data-toggle="modal" data-target="#modal_responder_encaminhamento"><i class="fa fa-reply"></i> Responder</button>
                                <a class="btn btn-sm btn-white" href="{!! route('seracademico.ouvidoria.encaminhamento.historico', ['id' => $detalheEncaminhamento->demanda_id]) !!}">
                                    <i class="fa fa-arrow-right"></i> Histórico do encaminhamento</a>
                                @if($detalheEncaminhamento->status == '4')
                                    <a href="{!! route('seracademico.ouvidoria.encaminhamento.reencaminar', ['id' => $detalheEncaminhamento->id]) !!}"
                                       data-placement="top"  class="btn btn-sm btn-white"><i class="fa fa-print"></i> Reenchaminhar</a>
                                    <a href="{!! route('seracademico.ouvidoria.encaminhamento.encaminhar', ['id' => $detalheEncaminhamento->id]) !!}" title="" data-placement="top" class="btn btn-sm btn-white">
                                        <i class="fa fa-trash-o"></i> Encaminhar
                                    </a>
                                @endif
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            @include('encaminhamento.modal_responder_encaminhamento')
        </div>
    </div>
@stop

@section('javascript')
    <script type="text/javascript">

    </script>
@stop