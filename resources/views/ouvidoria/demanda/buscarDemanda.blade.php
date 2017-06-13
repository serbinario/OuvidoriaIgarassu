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
            <img src="{{asset('/img/LOGO_OUVIDORIA_2.jpg')}}" class="img-responsive" style="width: 450px; height: 120px">
            {{--<img src="{{asset('/img/igarassu.png')}}" style="width: 400px; height: 90px">--}}
        </center>
    </div>
</div>

<div class="loginColumns animated fadeInDown">
    <div class="row">
        <div class="col-sm-5 col-md-10 col-md-offset-1">
            <div class="ibox-content">
                {!! Form::open(['route'=>'getDemanda', 'method' => "GET" ]) !!}
                    <div class="form-group">
                        <label for="protocolo">Número de protocolo *</label>
                        {!! Form::text('protocolo', Session::getOldInput('protocolo') , array('class' => 'form-control')) !!}
                    </div>
                    <button class="btn btn-primary btn-sm m-t-10">Consultar</button>
                    <a class="btn btn-default btn-sm m-t-10" href="{{ route('indexPublico') }}">Voltar</a>
                {!! Form::close() !!}
            </div>
        </div>
        @if(isset($dados))
            <div class="col-sm-5 col-md-10 col-md-offset-1">
                <br />
                <div class="table-responsive">
                    <table class="table compact table-condensed">
                        <tbody>
                        <tr>
                            <td colspan="3" style="background-color: #0b8345; color: white">Identificação</td>
                        </tr>
                        <tr>
                            <td colspan="3">Sigilo: {{$dados->sigilo}} </td>
                            {{--<td>Anônimo: {{$dados->anonimo}} </td>--}}
                        </tr>
                        @if($dados->anonimo_id == '1')
                            <tr>
                                <td colspan="3" style="background-color: #213a53; color: white">Dados pessoas</td>
                            </tr>
                            <tr>
                                <td colspan="2">Nome: {{$dados->nome}} </td>
                                <td>Fone: {{$dados->fone}} </td>
                            </tr>
                            <tr>
                                <td colspan="3">E-mail: {{$dados->email}} </td>
                            </tr>
                            <tr>
                                <td>Endereço: {{$dados->endereco}} </td>
                                <td>Número: {{$dados->numero_end}} </td>
                                <td>Comunidade: {{$dados->comunidade}} </td>
                            </tr>
                            <tr>
                                <td>Sexo: {{$dados->sexo}} </td>
                                <td>Idade: {{$dados->idade}} </td>
                                <td>Escolaridade: {{$dados->escolaridade}} </td>
                            </tr>
                        @endif
                        <tr>
                            <td colspan="3" style="background-color: #0b8345; color: white">Dados da manifestação</td>
                        </tr>
                        <tr>
                            <td colspan="3">Situação: @if($dados->status_id == '6') {{$dados->status}} @else AGUARDANDO RESPOSTA @endif </td>
                        </tr>
                        <tr>
                            <td>Perfil: {{$dados->perfil}} </td>
                            <td colspan="2">Tipo da manifestação: {{$dados->informacao}} </td>
                            {{--<td>Data/Hora da ocorrência: <br /> {{$dados->data_da_ocorrencia}} - {{$dados->hora_da_ocorrencia}} </td>--}}
                        </tr>
                        <tr>
                            <td>Área: {{$dados->area}} </td>
                            <td>Assunto: {{$dados->assunto}} </td>
                            <td>Subassunto: {{$dados->subassunto}}</td>
                        </tr>
                        <tr>
                            <td colspan="3">Relato</td>
                        </tr>
                        <tr>
                            <td colspan="3">{{$dados->relato}} </td>
                        </tr>
                        <tr>
                            <td>Resposta</td>
                            <td>Prazo para solução:</td>
                            <td>{{$dados->prazo_solucao}}</td>
                        </tr>
                        @if($dados->resp_publica == '1')
                            <tr>
                                <td colspan="3">{{$dados->resposta}} </td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="3">{{$dados->resposta_ouvidor}} </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
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
    {{--<script src="{{ asset('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js')}}" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>--}}
</body>
</html>
