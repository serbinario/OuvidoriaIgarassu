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
    <section id="content">
        <div class="container">
            <div class="block-header">
                <h2>Histórido de encaminhamento</h2>
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
                                </div>
                                <h2>
                                    Histórico
                                </h2>
                                <div class="mail-tools tooltip-demo m-t-md">
                                    <h3>
                                        <span class="font-noraml"></span>Demanda de número
                                        - {{$encaminhamentos[0]->codigo}}
                                    </h3>
                                </div>
                            </div>
                            <div class="mail-box">
                                <br />
                                @foreach($encaminhamentos as $encaminhamento)
                                    <table class="table">
                                        <tbody>
                                            <tr style="background-color: #e0e5ef">
                                                <td><b>Data:</b> {{$encaminhamento->data}}</td>
                                                <td><b>Previsão:</b> {{$encaminhamento->previsao}}</td>
                                                <td><b>Prioridade:</b> {{$encaminhamento->prioridade}}</td>
                                            </tr>
                                            <tr>
                                                <td><b>Secretaria:</b> {{$encaminhamento->area}}</td>
                                                <td><b>Departamento/Destinatário:</b> {{$encaminhamento->destinatario}}</td>
                                                <td><b>Status:</b> {{$encaminhamento->status}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"><b>Parecer: </b></span>{{$encaminhamento->parecer}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"><b>Resposta: </b></span>{{$encaminhamento->resposta}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @endforeach
                                <div class="mail-body text-right tooltip-demo">
                                    <button class="btn btn-sm btn-green voltar" onclick='javascript:history.back();'
                                            type="button"><i class="fa fa-reply"></i> Voltar
                                    </button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
    </section>
@stop

@section('javascript')
    <script type="text/javascript">

    </script>
@stop