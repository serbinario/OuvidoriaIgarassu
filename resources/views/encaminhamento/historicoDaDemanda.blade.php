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
                <h4><i class="material-icons">find_in_page</i> Histórido de encaminhamento</h4>
            </div>
        </div>
        <div class="ibox-content">

            <div class="row">
                <div class="col-lg-12 animated fadeInRight">
                    <div class="mail-box-header">
                        <div class="pull-right tooltip-demo">
                        </div>
                        <h2>
                            Histórico
                        </h2>
                        <div class="mail-tools tooltip-demo m-t-md">
                            <h3>
                                <span class="font-noraml"></span>Demanda de número - {{$encaminhamentos[0]->codigo}}
                            </h3>
                        </div>
                    </div>
                    <div class="mail-box">
                        @foreach($encaminhamentos as $encaminhamento)
                            <div class="mail-body">
                                <p>
                                    <span><b>Data:</b> {{$encaminhamento->data}}</span>
                                    <span><b>Previsão:</b> {{$encaminhamento->previsao}}</span>
                                    <span><b>Prioridade:</b> {{$encaminhamento->prioridade}}</span>
                                    <br/>
                                    <span><b>Secretaria:</b> {{$encaminhamento->area}}</span><br />
                                    <span><b>Departamento/Destinatário:</b> {{$encaminhamento->destinatario}}</span><br />
                                    <span><b>Status:</b> {{$encaminhamento->status}}</span>
                                    <br />
                                    <br/>
                                    <span><b>Parecer: </b></span>{{$encaminhamento->parecer}}
                                </p>
                                <p>
                                    <span><b>Resposta: </b></span>{{$encaminhamento->resposta}}
                                </p>
                            </div>
                        @endforeach
                        <div class="mail-body text-right tooltip-demo">
                            <button class="btn btn-sm btn-green voltar" onclick='javascript:history.back();' type="button"><i class="fa fa-reply"></i> Voltar</button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
        </div>
    </div>
@stop

@section('javascript')
    <script type="text/javascript">

    </script>
@stop