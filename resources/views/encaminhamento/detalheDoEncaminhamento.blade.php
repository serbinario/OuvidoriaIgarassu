@extends('menu')

@section('css')
    <style type="text/css" class="init">
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
        .titulo {
            background-color: #e7e7e7;
            width: 16%;
        }
    </style>
@endsection

@section('content')
    <section id="content">
        <div class="container">
            <div class="block-header">
                <h2>Detalhe do encaminhamento</h2>
            </div>

            <div class="card material-table">
                <div class="card-header">
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

                        <div class="row">
                            <div class="col-lg-12 animated fadeInRight">
                                <div class="mail-box-header">
                                    <div class="pull-right tooltip-demo">
                                        <button type="button" class="btn btn-default btn-icon-text waves-effect" data-toggle="modal" data-target="#modal_responder_encaminhamento">
                                            <i class="zmdi zmdi-check"></i> Responder
                                        </button>
                                    </div>
                                    <h2>
                                        {{$detalheEncaminhamento->area}} - {{$detalheEncaminhamento->destinatario}}
                                    </h2>
                                    <div class="mail-tools tooltip-demo m-t-md">
                                        <h3>
                                            <span class="font-noraml">Assunto: </span>Demanda de número - {{$detalheEncaminhamento->codigo}}
                                        </h3>
                                        <h5>
                                            <span class="font-noraml">Status: </span>{{$detalheEncaminhamento->status}}
                                        </h5>
                                    </div>
                                </div><br />
                                <div class="mail-box">
                                    <div class="mail-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <div class="btn-group btn-group-justified" role="group" aria-label="...">
                                                        <div class="btn-group" role="group">
                                                            <a href="{!! route('seracademico.ouvidoria.encaminhamento.encaminhados') !!}" class="btn bgm-bluegray waves-effect">
                                                                <i class="zmdi zmdi-arrow-back"></i> Voltar</a>
                                                        </div>
                                                        <div class="btn-group" role="group">
                                                            <button type="button" data-toggle="modal" data-target="#modal_responder_encaminhamento" class="btn btn-primary">
                                                                <i class="zmdi zmdi-check"></i>  Responder</button>
                                                        </div>
                                                        <div class="btn-group" role="group">
                                                            <a href="{!! route('seracademico.ouvidoria.encaminhamento.historico', ['id' => $detalheEncaminhamento->demanda_id]) !!}"
                                                               class="btn btn-primary"><i class="zmdi zmdi-storage"></i> Histórico</a>
                                                        </div>
                                                        @role('ouvidoria|admin')
                                                            <div class="btn-group" role="group">
                                                                <a href="{!! route('seracademico.ouvidoria.encaminhamento.reencaminar', ['id' => $detalheEncaminhamento->id]) !!}"
                                                                   class="btn btn-primary"><i class="zmdi zmdi-mail-reply"></i> Reenchaminhar</a>
                                                            </div>
                                                            <div class="btn-group" role="group">
                                                                <a href="{!! route('seracademico.ouvidoria.encaminhamento.encaminhar', ['id' => $detalheEncaminhamento->id]) !!}"
                                                                   class="btn btn-primary"><i class="zmdi zmdi-mail-send"></i> Encaminhar</a>
                                                            </div>
                                                            <div class="btn-group" role="group">
                                                                <button type="button" id="finalizarDemanda" class="btn btn bgm-deeporange waves-effect">
                                                                    <i class="zmdi zmdi-close-circle-o"></i> Finalizar</button>
                                                            </div>
                                                        @endrole
                                                    </div>
                                                    <table id="encaminhamento-grid" class=" table compact table-bordered table-condensed" cellspacing="0" width="100%">
                                                        <tbody>
                                                        <tr>
                                                            <td class="titulo">Tipo da demanda</td>
                                                            <td>{{$detalheEncaminhamento->informacao}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="titulo">Código</td>
                                                            <td>{{$detalheEncaminhamento->codigo}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td  class="titulo">Data</td>
                                                            <td>{{$detalheEncaminhamento->data}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td  class="titulo">Previsão</td>
                                                            <td>{{$detalheEncaminhamento->previsao}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="titulo">Prioridade</td>
                                                            <td>{{$detalheEncaminhamento->prioridade}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="titulo">Secretaria</td>
                                                            <td>{{$detalheEncaminhamento->area}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="titulo">Departamento/Destinatário</td>
                                                            <td>{{$detalheEncaminhamento->destinatario}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="titulo">Assunto</td>
                                                            <td>{{$detalheEncaminhamento->assunto}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="titulo">Subassunto</td>
                                                            <td>{{$detalheEncaminhamento->subassunto}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="titulo">Responsável</td>
                                                            <td>{{$detalheEncaminhamento->responsavel}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="titulo">Encaminhado</td>
                                                            <td>{{$detalheEncaminhamento->encaminhado}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="titulo">Relato</td>
                                                            <td>{{$detalheEncaminhamento->relato}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="titulo">Parecer</td>
                                                            <td>{{$detalheEncaminhamento->parecer}}</td>
                                                        </tr>
                                                        @if($detalheEncaminhamento->resposta)
                                                            <tr>
                                                                <td class="titulo">Resposta</td>
                                                                <td>{{$detalheEncaminhamento->resposta}}</td>
                                                            </tr>
                                                        @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div><br  />
                                    {{--<div class="mail-body text-right tooltip-demo">
                                        <a class="btn btn-sm btn-white" href="{!! route('seracademico.ouvidoria.encaminhamento.encaminhados') !!}">
                                            <i class="fa fa-reply"></i> Voltar</a>
                                        <button class="btn btn-sm btn-white" type="button" data-toggle="modal" data-target="#modal_responder_encaminhamento"><i class="fa fa-arrow-right"></i> Responder</button>
                                        <a class="btn btn-sm btn-white" href="{!! route('seracademico.ouvidoria.encaminhamento.historico', ['id' => $detalheEncaminhamento->demanda_id]) !!}">
                                            <i class="fa fa-arrow-right"></i> Histórico do encaminhamento</a>
                                        @role('ouvidoria|admin')
                                            <a href="{!! route('seracademico.ouvidoria.encaminhamento.reencaminar', ['id' => $detalheEncaminhamento->id]) !!}"
                                               data-placement="top"  class="btn btn-sm btn-white"><i class="fa fa-arrow-right"></i> Reenchaminhar</a>
                                            <a href="{!! route('seracademico.ouvidoria.encaminhamento.encaminhar', ['id' => $detalheEncaminhamento->id]) !!}" title="" data-placement="top" class="btn btn-sm btn-white">
                                                <i class="fa fa-arrow-right"></i> Encaminhar
                                            </a>
                                            <button type="button" id="finalizarDemanda" title="" data-placement="top" class="btn btn-sm btn-blue">
                                                <i class="fa fa-arrow-right"></i> Finalizar
                                            </button>
                                        @endrole
                                    </div>--}}
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div><br/>
                        @include('encaminhamento.modal_responder_encaminhamento')
                </div>
            </div>
        </div>
    </section>
@stop

@section('javascript')
    <script type="text/javascript">

        //Warning Message
        $('#finalizarDemanda').click(function(){
            swal({
                title: "Alerta",
                text: "Tem certeza que deseja finalizar essa demanda?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Sim, desejo finalizar!",
            }).then(function(){
                location.href = '{!! route('seracademico.ouvidoria.encaminhamento.finalizar', ['id' => $detalheEncaminhamento->id]) !!}'
            });
        });

        /*$(document).on('click', '#finalizarDemanda', function (event) {
            event.preventDefault();
            var url = $(this).attr('href');
            bootbox.confirm("Tem certeza que deseja finalizar essa demanda?", function (result) {
                if (result) {
                    location.href = url
                } else {
                    false;
                }
            });
        });*/
    </script>
@stop