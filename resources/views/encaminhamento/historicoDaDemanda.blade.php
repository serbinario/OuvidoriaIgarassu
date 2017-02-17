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
                            <a href="#" class="btn btn-white btn-sm" data-toggle="tooltip"
                               data-placement="top" title="Reply"><i class="fa fa-reply"></i> Reply</a>
                        </div>
                        <h2>
                            View Message
                        </h2>
                        <div class="mail-tools tooltip-demo m-t-md">
                            <h3>
                                <span class="font-noraml">Subject: </span>Aldus PageMaker including versions of Lorem
                                Ipsum.
                            </h3>
                            <h5>
                                <span class="pull-right font-noraml">10:15AM 02 FEB 2014</span>
                                <span class="font-noraml">From: </span>alex.smith@corporation.com
                            </h5>
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
                            <a class="btn btn-sm btn-white" href="#"><i class="fa fa-reply"></i>
                                Reply</a>
                            <a class="btn btn-sm btn-white" href="#"><i class="fa fa-arrow-right"></i>
                                Forward</a>
                            <button title="" data-placement="top" data-toggle="tooltip" type="button"
                                    data-original-title="Print" class="btn btn-sm btn-white"><i class="fa fa-print"></i>
                                Print
                            </button>
                            <button title="" data-placement="top" data-toggle="tooltip" data-original-title="Trash"
                                    class="btn btn-sm btn-white"><i class="fa fa-trash-o"></i> Remove
                            </button>
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