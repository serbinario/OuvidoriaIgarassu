<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SerOuvidor - Sistema Eletrônico Para Gestão de Ouvidorias</title>

    <link href="{{ asset('/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('/font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <link href="{{ asset('/css/animate.css')}}" rel="stylesheet">
    <link href="{{ asset('/css/style.css')}}" rel="stylesheet">
    <style type="text/css" class="init">

        html, body {height:100%;}

        .footer {
            position:absolute;
            bottom:0;
            width:100%;
        }

    </style>
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">--}}
</head>
<body class="gray-bg">

<div class="row">
    <div class="col-sm-12 col-md-12" style="background-color: #0b8345">
        <center>
            <img src="{{asset('/img/LOGO_OUVIDORIA_2.jpg')}}"  class="img-responsive" style="width: 450px; height: 120px">
            {{--<img src="{{asset('/img/igarassu.png')}}" style="width: 400px; height: 90px">--}}
        </center>
    </div>
</div>

<div class="loginColumns animated fadeInDown">
    <div class="row">
        <div class="col-sm-5 col-md-10 col-md-offset-1">
            <div class="ibox-content">
                {!! Form::open(['route'=>'getDemanda', 'method' => "GET", 'id' => 'formBuscaDemanda' ]) !!}
                <div class="row">
                    <div class="form-group col-md-10">
                        <div class="fg-line">
                            <div class="fg-line">
                                <label for="protocolo">Número de protocolo *</label>
                                {!! Form::text('protocolo', Session::getOldInput('protocolo') , array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                </div>

                    <button class="btn btn-primary btn-sm m-t-10">Consultar</button>
                    <a class="btn btn-default btn-sm m-t-10" href="{{ route('indexPublico') }}">Voltar</a>
                {!! Form::close() !!}
            </div>
        </div>
        @if(isset($dados))
            <div class="col-sm-5 col-md-10 col-md-offset-1">
                <br />
                {{--Painel 1--}}
                <div class="panel panel-primary">
                    <!-- Default panel contents -->
                    <div class="panel-heading">Dados do manifestante</div>

                    <!-- List group -->
                    <ul class="list-group">
                        <li class="list-group-item">
                            <b>Nome:</b> @if($dados->sigilo_id == '1') {{$dados->nome}} @else
                                Sigiloso @endif
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6">
                                    <b>CPF:</b> @if($dados->sigilo_id == '1') {{$dados->cpf}} @endif
                                </div>
                                <div class="col-md-6">
                                    <b>Idade:</b> @if($dados->sigilo_id == '1')  {{$dados->idade}} @endif
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                {{--Painel 2--}}
                <div class="panel panel-primary">
                    <!-- Default panel contents -->
                    <div class="panel-heading">Dados da manifestação</div>

                    <!-- List group -->
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6">
                                    <b>Sigilo:</b> {{$dados->sigilo}}
                                </div>
                                <div class="col-md-6">
                                    <b>Protocolo:</b>  {{$dados->n_protocolo}}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6">
                                    <b>Perfil:</b> {{$dados->perfil}}
                                </div>
                                <div class="col-md-6">
                                    <b>Tipo da manifestação:</b> {{$dados->informacao}}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6">
                                    <b>Assunto:</b> {{$dados->assunto}}
                                </div>
                                <div class="col-md-6">
                                    <b>Subassunto:</b> {{$dados->subassunto}}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <b>Relato: </b> {{$dados->relato}}
                        </li>
                    </ul>
                </div>

                {{--Painel 1--}}
                <div class="panel panel-primary">
                    <!-- Default panel contents -->
                    <div class="panel-heading">Histórico das situações da manifestação</div>

                    <!-- List group -->
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6">
                                    <span>{{$dados->data_demanda}} - <b> Recebimento da manifestação </b></span>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        @foreach($encaminhamentos as $chave => $encaminhamento)
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading-{{$chave}}">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-{{$chave}}" aria-expanded="true" aria-controls="collapse-{{$chave}}">
                                            {{$encaminhamento->data}} - Encaminhada para
                                                @if($encaminhamento->secretaria_id == '1'){{$encaminhamento->destino}}
                                                @else {{$encaminhamento->secretaria}} @endif - <b>Prazo de retorno:</b> {{$dados->previsao}}
                                        </a>
                                    </h4>
                                </div>

                                <div id="collapse-{{$chave}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-{{$chave}}">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <span><b> Situação </b> - ({{$encaminhamento->status}})</span>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                            </div>

                        {{-- collapse para respotas --}}
                            @if($encaminhamento->resp_publica == '1' || $encaminhamento->resposta_ouvidor)
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="heading-<?php echo $chave."a"; ?>">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?php echo $chave."a"; ?>" aria-expanded="true" aria-controls="collapse-<?php echo $chave."a"; ?>">
                                                {{$encaminhamento->data_resposta}} - <b>Resposta da Secretaria Demandante :</b> - <b>Prazo para solução:</b> {{$encaminhamento->prazo_solucao}}
                                            </a>
                                        </h4>
                                    </div>

                                    <div id="collapse-<?php echo $chave."a"; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-<?php echo $chave."a"; ?>">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        @if($encaminhamento->resp_publica == '1')
                                                            {{$encaminhamento->resposta}}
                                                        @else
                                                            {{$encaminhamento->resposta_ouvidor}}
                                                        @endif
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            @endif

                        @endforeach
                    </div>

                    <!-- List group para demanda que for finalizada -->
                    @if(isset($encaminhamento) && $encaminhamento->status_id == '6')
                        
                        <ul class="list-group" style="margin-top: -15px">
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-md-12">
                                        {{$encaminhamento->data_finalizacao}} - <b>Demanda finalizada como: </b> {{$dados->status_externo}}
                                    </div>
                                </div>
                            </li>
                        </ul>
                    @endif

                </div>
            </div>
        @endif
    </div>
    <br />  <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br />
    <div class="footer">
        <center>
            <img src="{{ asset('/img/s1.png')}}" style="width: 10%;"/><br />
            <strong>Copyright &copy; 2015-2016 <a target="_blank" href="http://serbinario.com.br"><i></i>SERBINARIO</a> .</strong> Todos os direitos reservados.
        </center>
    </div>
    <hr/>
    <script src="{{ asset('/js/jquery-2.1.1.js')}}"></script>
    <script src="{{ asset('/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('/lib/jquery-validation/dist/jquery.validate.js') }}"></script>
    <script src="{{ asset('/lib/jquery-validation/src/localization/messages_pt_BR.js') }}"></script>
    <script src="{{ asset('/js/validacoes/busca_demanda.js')}}"></script>

</body>
</html>
