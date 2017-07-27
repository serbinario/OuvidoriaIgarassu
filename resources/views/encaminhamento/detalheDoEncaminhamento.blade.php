@extends('menu')

@section('css')
    <style type="text/css" class="init">

        td.bt a {
            float: left;
            height: 22px;
            margin: 0 10px;
        }
        .titulo {
            background-color: #f8f8f8;
            width: 16%;
            font-weight: 900;
        }

        td.details-control {
            background: url({{asset("/imagemgrid/icone-produto-plus.png")}}) no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url({{asset("/imagemgrid/icone-produto-minus.png")}}) no-repeat center center;
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

                    @if(Session::has('error'))
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <em> {!! session('error') !!}</em>
                        </div>
                    @endif


                    <div class="row">
                        <div class="col-lg-12 animated fadeInRight">
                            <div class="mail-box-header">
                                <div class="pull-right tooltip-demo">
                                    {{--<button type="button"  @if($detalheEncaminhamento->status_id == '6') disabled @endif
                                            class="btn btn-default btn-icon-text waves-effect"
                                            data-toggle="modal" data-target="#modal_responder_encaminhamento">
                                        <i class="zmdi zmdi-check"></i> Responder
                                    </button>--}}
                                </div>
                                {{--<h2>
                                    {{$detalheEncaminhamento->area}} - {{$detalheEncaminhamento->destinatario}}
                                </h2>--}}

                                <div class="mail-tools tooltip-demo m-t-md">
                                    <h3>
                                        <span class="font-noraml"></span>Manifestação de número
                                        - {{$detalheEncaminhamento->codigo}} (Protocolo
                                        - {{$detalheEncaminhamento->n_protocolo}})
                                    </h3>
                                    <h4>
                                        <span class="font-noraml">Tipo da manifestação: </span>{{$detalheEncaminhamento->informacao}}
                                    </h4>
                                    <h5>
                                        <span class="font-noraml">Status: </span>{{$detalheEncaminhamento->status}}
                                    </h5>
                                </div>
                            </div>
                            <br/>

                            <div class="mail-box">
                                <div class="mail-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">

                                                {{-- <a href="{!! route('seracademico.ouvidoria.demanda.index') !!}"
                                                   class="btn bgm-bluegray waves-effect">
                                                    <i class="zmdi zmdi-arrow-back"></i> Voltar
                                                </a> --}}
                                                <button type="button" class="btn bgm-bluegray waves-effect" onclick='javascript:history.back();'><i class="zmdi zmdi-arrow-back"></i> Voltar</button>
                                                <button type="button" data-toggle="modal" @if($detalheEncaminhamento->status_id == '6') disabled @endif
                                                        data-target="#modal_responder_encaminhamento"
                                                        class="btn btn-primary">
                                                    <i class="zmdi zmdi-check"></i> Resposta
                                                </button>
                                                @role('ouvidoria|admin')
                                                <button type="button" data-toggle="modal" @if($detalheEncaminhamento->status_id == '6') disabled @endif
                                                        data-target="#modal_resposta_ouvidor_encaminhamento"
                                                        class="btn btn-primary">
                                                    <i class="zmdi zmdi-check"></i> Resposta ouvidoria
                                                </button>
                                                <button type="button" data-toggle="modal" @if($detalheEncaminhamento->status_id == '6') disabled @endif
                                                        data-target="#modal_reencaminhamento"
                                                        class="btn btn-primary">
                                                    <i class="zmdi zmdi-mail-reply"></i> Reenchaminhar
                                                </button>
                                                <button type="button" data-toggle="modal" @if($detalheEncaminhamento->status_id == '6') disabled @endif
                                                        data-target="#modal_encaminhamento"
                                                        class="btn btn-primary">
                                                    <i class="zmdi zmdi-mail-send"></i> Encaminhar
                                                </button>
                                                <button type="button" data-toggle="modal" @if($detalheEncaminhamento->status_id == '6') disabled @endif
                                                        data-target="#modal-finalizar-manifestacao"
                                                        class="btn btn bgm-deeporange waves-effect">
                                                    <i class="zmdi zmdi-close-circle-o"></i> Finalizar
                                                </button>
                                                @endrole
                                                <br><br>
                                                <table id="encaminhamento-grid"
                                                       class=" table compact table-bordered table-condensed"
                                                       cellspacing="0" width="50%">
                                                    <tbody>
                                                    <tr>
                                                        <td colspan="6" style="font-size: 16px;" class="titulo">Dados do
                                                            Manifestante
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td><b>Manifestante:</b></td>
                                                        <td colspan="3"
                                                            style="width: 50%;">{{$detalheEncaminhamento->manifestante}}</td>
                                                        <td><b>CPF:</b></td>
                                                        <td style="width : 30%">{{$detalheEncaminhamento->cpf}}</td>
                                                    </tr>

                                                    <tr>
                                                        <td><b>Sexo:</b></td>
                                                        <td style="width : 20%">{{$detalheEncaminhamento->sexo}}</td>
                                                        <td><b>Idade:</b></td>
                                                        <td style="width : 30%">{{$detalheEncaminhamento->idade}}</td>
                                                        <td><b>Telefone:</b></td>
                                                        <td style="width : 30%">{{$detalheEncaminhamento->fone}}</td>
                                                    </tr>

                                                    <tr>
                                                        <td><b>Profissão</b></td>
                                                        <td style="width : 30%">{{$detalheEncaminhamento->profissao}}</td>
                                                        <td><b>Email:</b></td>
                                                        <td style="width : 30%">{{$detalheEncaminhamento->email}}</td>
                                                        <td><b>RG:</b></td>
                                                        <td style="width : 30%">{{$detalheEncaminhamento->rg}}</td>
                                                    </tr>

                                                    <tr>
                                                        <td><b>Endereço:</b></td>
                                                        <td colspan="3"
                                                            style="width : 50%">{{$detalheEncaminhamento->endereco}}</td>
                                                        <td><b>Número:</b></td>
                                                        <td style="width : 20%">{{$detalheEncaminhamento->numero_end}}</td>
                                                    </tr>

                                                    <tr>
                                                        <td><b>Cidade:</b></td>
                                                        <td style="width : 30%">{{$detalheEncaminhamento->cidade}}</td>
                                                        <td><b>Bairro:</b></td>
                                                        <td style="width : 30%">{{$detalheEncaminhamento->bairro}}</td>
                                                        <td><b>CEP:</b></td>
                                                        <td style="width : 30%">{{$detalheEncaminhamento->cep}}</td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="6" style="font-size: 16px;" class="titulo">Dados da
                                                            Manifestação
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td><b>Protocolo:</b></td>
                                                        <td style="width : 30%">{{$detalheEncaminhamento->n_protocolo}}</td>
                                                        <td><b>Número:</b></td>
                                                        <td style="width : 30%">{{$detalheEncaminhamento->codigo}}</td>
                                                        <td><b>Prioridade:</b></td>
                                                        <td style="width : 30%">{{$detalheEncaminhamento->prioridade}}</td>
                                                    </tr>

                                                    <tr>
                                                        <td><b>Registro:</b></td>
                                                        <td style="width : 30%">{{$detalheEncaminhamento->tipo_demanda }}</td>
                                                        <td><b>Tipo:</b></td>
                                                        <td style="width : 30%">{{$detalheEncaminhamento->informacao}}</td>
                                                        <td><b>Data:</b></td>
                                                        <td style="width : 30%">{{$detalheEncaminhamento->dataCadastro}}</td>
                                                    </tr>

                                                    <tr>
                                                        <td><b>Identificação:</b></td>
                                                        <td style="width: 50%;">{{$detalheEncaminhamento->sigilo}}</td>
                                                        <td><b>Autor:</b></td>
                                                        <td style="width: 50%;">{{$detalheEncaminhamento->identificacao}}</td>
                                                        <td><b>HORA:</b></td>
                                                        <td style="width : 30%">{{$detalheEncaminhamento->horaCadastro}}</td>
                                                    </tr>

                                                    <tr>
                                                        <td><b>Assunto:</b></td>
                                                        <td colspan="5">{{$detalheEncaminhamento->assunto}}</td>
                                                    </tr>

                                                    <tr>
                                                        <td><b>Sub Assunto:</b></td>
                                                        <td colspan="5">{{$detalheEncaminhamento->subassunto}}</td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="6" style="font-size: 16px;" class="titulo">Dados da
                                                            ocorrência do fato
                                                        </td>
                                                    </tr>

                                                    {{--<tr>
                                                        <td><b>DATA:</b></td>
                                                        <td colspan="1" style="width : 50%">{{ $detalheEncaminhamento->dataOcorrencia }}</td>
                                                        <td><b>HORA:</b></td>
                                                        <td colspan="3" style="width : 50%">{{ $detalheEncaminhamento->horaOcorrencia }}</td>
                                                    </tr>--}}

                                                    <tr>
                                                        <td><b>Descrição:</b></td>
                                                        <td colspan="5">{{ $detalheEncaminhamento->relato }}</td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="6" style="font-size: 16px;" class="titulo">
                                                            Encaminhamento
                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <td><b>DE:</b></td>
                                                        <td colspan="2"
                                                            style="width : 50%">{{ $detalheEncaminhamento->responsavel_resposta }}</td>
                                                        <td><b>DATA:</b></td>
                                                        <td style="width : 50%">{{ $detalheEncaminhamento->data }}</td>
                                                    </tr>


                                                    <tr>
                                                        <td><b>PARA:</b></td>
                                                        <td colspan="2"
                                                            style="width : 50%">{{ $detalheEncaminhamento->area }}</td>
                                                        <td><b>PRAZO:</b></td>
                                                        <td style="width : 50%">{{ $detalheEncaminhamento->previsao }}</td>
                                                        <td>
                                                            @role('ouvidoria|admin')
                                                                @if(!$detalheEncaminhamento->prazo_solucao &&
                                                                (isset($encaminhamentoAnterior->prazo_solucao) && !$encaminhamentoAnterior->prazo_solucao) &&
                                                                $detalheEncaminhamento->status_id != '6')
                                                                    <button type="button" data-toggle="modal"
                                                                            data-target="#modal-prorrogar-manifestacao"
                                                                            class="btn btn-sm btn-success waves-effect">
                                                                        <i class="zmdi zmdi-time-restore"></i> Prorrogar prazo
                                                                    </button>
                                                                @endif
                                                            @endrole
                                                        </td>
                                                    </tr>

                                                    @if($detalheEncaminhamento->status_prorrogacao == '1')
                                                        <tr>
                                                            <td colspan="5"><b>PRAZO PRORROGADO - Justificativa da prorrogação:</b></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5">{{ $detalheEncaminhamento->justificativa_prorrogacao }}</td>
                                                        </tr>
                                                    @endif

                                                    <tr>
                                                        <td colspan="6" style="font-size: 16px;" class="titulo">Situação
                                                            Atual
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td><b>Situação:</b></td>
                                                        <td colspan="2" style="width : 50%">{{ $detalheEncaminhamento->status }}</td>
                                                        <td><b>DATA DA RESPOSTA:</b></td>
                                                        <td style="width : 50%">{{ $detalheEncaminhamento->data_resposta }}</td>
                                                    </tr>

                                                    <tr>
                                                        <td><b>Secretaria:</b></td>
                                                        <td colspan="2" style="width : 50%">{{ $detalheEncaminhamento->area }}</td>
                                                        <td><b>PRAZO PARA SOLUÇÃO:</b></td>
                                                        <td style="width : 50%">
                                                            @if($detalheEncaminhamento->prazo_solucao)
                                                                {{ $detalheEncaminhamento->prazo_solucao }}
                                                            @elseif(isset($encaminhamentoAnterior->prazo_solucao) && $encaminhamentoAnterior->prazo_solucao)
                                                                {{  $encaminhamentoAnterior->prazo_solucao }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @role('ouvidoria|admin')
                                                                @if($detalheEncaminhamento->prazo_solucao || (isset($encaminhamentoAnterior->prazo_solucao) && $encaminhamentoAnterior->prazo_solucao))
                                                                    <button type="button" data-toggle="modal" @if($detalheEncaminhamento->status_id == '6') disabled @endif
                                                                            data-target="#modal-prorrogar-solucao-manifestacao"
                                                                            class="btn btn-sm btn-success waves-effect">
                                                                        <i class="zmdi zmdi-time-restore"></i> Prorrogar prazo
                                                                    </button>
                                                                @endif
                                                            @endrole
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td><b>Resposta:</b></td>
                                                        <td colspan="5">{{ $detalheEncaminhamento->resposta }}</td>
                                                    </tr>

                                                    @if($detalheEncaminhamento->status_prazo_solucao ||
                                                    (isset($encaminhamentoAnterior->status_prazo_solucao) && $encaminhamentoAnterior->status_prazo_solucao))
                                                        <tr>
                                                            <td colspan="5"><b>PRAZO DE SOLUÇÃO PRORROGADO - Justificativa da prorrogação:</b></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5">
                                                                @if($detalheEncaminhamento->status_prazo_solucao)
                                                                    {{ $detalheEncaminhamento->justificativa_prazo_solucao }}
                                                                @elseif (isset($encaminhamentoAnterior->status_prazo_solucao) && $encaminhamentoAnterior->status_prazo_solucao)
                                                                    {{ $encaminhamentoAnterior->justificativa_prazo_solucao }}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif

                                                    </tbody>
                                                    {{--<tbody>
                                                    <tr>
                                                        <td class="titulo"><b>Prioridade</b></td>
                                                        <td style="width: 15%">{{$detalheEncaminhamento->prioridade}}</td>
                                                        <td class="titulo"><b>Código</b></td>
                                                        <td>{{$detalheEncaminhamento->codigo}}</td>
                                                        <td  class="titulo"><b>Data</b></td>
                                                        <td>{{$detalheEncaminhamento->data}}</td>
                                                        <td  class="titulo"><b>Previsão</b></td>
                                                        <td>{{$detalheEncaminhamento->previsao}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="titulo"><b>Assunto</b></td>
                                                        <td colspan="3">{{$detalheEncaminhamento->assunto}}</td>
                                                        <td class="titulo"><b>Subassunto</b></td>
                                                        <td colspan="3">{{$detalheEncaminhamento->subassunto}}</td>
                                                    </tr>
                                                    @if($detalheEncaminhamento->sigilo_id == '2')
                                                        @role('ouvidoria|admin')
                                                            <tr>
                                                                <td class="titulo"><b>Manisfestante</b></td>
                                                                <td colspan="8">{{$detalheEncaminhamento->manifestante}}</td>
                                                            </tr>
                                                        @endrole
                                                    @else
                                                        <tr>
                                                            <td class="titulo"><b>Manisfestante</b></td>
                                                            <td colspan="8">{{$detalheEncaminhamento->manifestante}}</td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <td class="titulo"><b>Responsável</b></td>
                                                        <td colspan="8">{{$detalheEncaminhamento->responsavel}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="titulo"><b>Parecer</b></td>
                                                        <td colspan="8">{{$detalheEncaminhamento->parecer}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="titulo"><b>Relato</b></td>
                                                        <td colspan="8">{{$detalheEncaminhamento->relato}}</td>
                                                    </tr>
                                                    @if($detalheEncaminhamento->resposta)
                                                        <tr>
                                                            <td class="titulo"><b>Respondido por</b></td>
                                                            <td colspan="8">{{$detalheEncaminhamento->responsavel_resposta}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="titulo"><b>Resposta</b></td>
                                                            <td colspan="8">{{$detalheEncaminhamento->resposta}}</td>
                                                        </tr>
                                                    @endif
                                                    </tbody>--}}
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-12">

                                            <ul id="tabs" class="tab-nav" role="tablist" data-tab-color="cyan">
                                                <li class="active"><a href="#historico" aria-controls="historico"
                                                                      role="tab" data-toggle="tab">Histórico da
                                                        manifestação</a>
                                                </li>
                                                @role('ouvidoria|admin')
                                                {{--<li><a href="#agrupar" aria-controls="agrupar" role="tab" data-toggle="tab">Agrupar demanda</a>--}}
                                                {{--</li>--}}
                                                @endrole
                                            </ul>

                                            <div class="tab-content">
                                                <div role="tabpanel" class="tab-pane active" id="historico">
                                                    <div class="table-responsive">
                                                        <table id="historico-grid"
                                                               class="display table compact table-bordered"
                                                               cellspacing="0" width="100%">
                                                            <thead>
                                                            <tr>
                                                                <th style="width: 10%;">Detalhe</th>
                                                                <th>Data</th>
                                                                <th>Previsão</th>
                                                                <th>Prioridade</th>
                                                                <th>Secretaria</th>
                                                                <th>Departamento/Destinatário</th>
                                                                <th>Status</th>
                                                            </tr>
                                                            </thead>
                                                            <tfoot>
                                                            <tr>
                                                                <th>Detalhe</th>
                                                                <th>Data</th>
                                                                <th>Previsão</th>
                                                                <th>Prioridade</th>
                                                                <th>Secretaria</th>
                                                                <th>Departamento/Destinatário</th>
                                                                <th>Status</th>
                                                            </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                                @role('ouvidoria|admin')
                                                <div role="tabpanel" class="tab-pane" id="agrupar">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group col-md-2">
                                                                <div class="fg-line">
                                                                    <div class="fg-line">
                                                                        <label for="codigo">Código da
                                                                            demanda</label>
                                                                        {!! Form::text('codigo', null , array('class' => 'form-control', 'id' => 'codigo')) !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div style="margin-top: 22px"
                                                                 class="form-group col-md-2">
                                                                <div class="fg-line">
                                                                    <div class="fg-line">
                                                                        <button id="agrupar-demanda"
                                                                                class="btn btn-primary btn-sm m-t-10">
                                                                            Agrupar
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="table-responsive">
                                                                <table id="demandas-agrupadas-grid"
                                                                       class="display table compact table-bordered"
                                                                       cellspacing="0" width="100%">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Código</th>
                                                                        <th>Secretaria</th>
                                                                        <th>Assunto</th>
                                                                        <th>Subassunto</th>
                                                                        <th>Status</th>
                                                                        <th>Data</th>
                                                                        <th style="width: 4%;">Acão</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tfoot>
                                                                    <tr>
                                                                        <th>Código</th>
                                                                        <th>Secretaria</th>
                                                                        <th>Assunto</th>
                                                                        <th>Subassunto</th>
                                                                        <th>Status</th>
                                                                        <th>Data</th>
                                                                        <th>Acão</th>
                                                                    </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endrole
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br/>

                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('encaminhamento.modal_responder_encaminhamento')
    @include('encaminhamento.modal_resposta_ouvidor_encaminhamento')
    @include('encaminhamento.modal_encaminhamento')
    @include('encaminhamento.modal_reencaminhamento')
    @include('encaminhamento.modal_finalizar_manifestacao')
    @include('encaminhamento.modal_prorrogar_manifestacao')
    @include('encaminhamento.modal_prorrogar_solucao_manifestacao')
@stop

@section('javascript')
    <script type="text/javascript">

        idDemanda = "{{$detalheEncaminhamento->demanda_id}}";
        idEncaminhamento = "{{$detalheEncaminhamento->id}}";

    </script>
@stop