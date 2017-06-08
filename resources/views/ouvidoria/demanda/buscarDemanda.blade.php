<html>
<head>
    <link href="{{ asset('/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900,300" rel="stylesheet">
    <link href="{{ asset('/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{ asset('/css/bootstrapValidation.mim.css')}}" rel="stylesheet">
    <link href="{{ asset('/css/jquery.datetimepicker.css')}}" rel="stylesheet"/>
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

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: small;
        }

        th {
            background-color:#CCC;
            font-size: 12px;
            color:#484848;
            padding-left:4px;
            padding-right:4px;
            border-bottom:solid 1px #CCC;
            height:26px;
            padding-right:5px;

        }

        tr:nth-child(odd) {
            background-color:#F3F3F3;
        }

        tr:nth-child(even) {
            background-color:#FFF;

        }

        tr, td {
            height:26px;
            padding-left:4px;
            padding-right:2px;
            font-family:Verdana, Geneva, sans-serif;
            font-size:12px;
            /*white-space:nowrap;*/
            border-bottom:solid 1px #E1E1E1;
        }

    </style>
</head>
<body>
<div class="conteiner">
    <div class="row">
        <center>
            <div class="topo" style="background-color: #0b8345">
                <center>
                    <img src="{{asset('/img/LOGO_OUVIDORIA_2.jpg')}}" style="width: 500px; height: 150px">
                    {{--<img src="{{asset('/img/igarassu.png')}}" style="width: 400px; height: 90px">--}}
                </center>
            </div>
        </center>
    </div>

    <br />
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            {!! Form::open(['route'=>'getDemanda', 'method' => "GET" ]) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <div class="fg-line">
                                <div class="fg-line">
                                    <label for="protocolo">Número de protocolo *</label>
                                    {!! Form::text('protocolo', Session::getOldInput('protocolo') , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-primary btn-sm m-t-10">Consultar</button>
                    <a class="btn btn-default btn-sm m-t-10" href="{{ route('seracademico.indexPublico') }}">Voltar</a>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
        @if(isset($dados))
            <div class="col-md-6 col-md-offset-3">
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
        <div class="col-md-2"></div>
    </div>
</div>

<footer id="footer" class="p-t-0" style="margin-top: 90px">
    <center>
        <img src="{{ asset('/img/s1.png')}}" style="width: 10%;"/><br />
        <strong>Copyright &copy; 2015-2016 <a target="_blank" href="http://serbinario.com.br"><i></i>SERBINARIO</a> .</strong> Todos os direitos reservados.
    </center>
</footer>

<script src="{{ asset('/js/jquery-2.1.1.js')}}"></script>
<script src="{{ asset('/js/jquery-ui.js')}}"></script>
<script src="{{ asset('/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('/js/jquery.mask.js')}}"></script>
<script src="{{ asset('/js/mascaras.js')}}"></script>
<script src="{{ asset('/js/bootstrapvalidator.js')}}" type="text/javascript"></script>
<script src="{{ asset('/js/jquery.datetimepicker.js')}}" type="text/javascript"></script>
<script src="{{ asset('/js/validacoes/validation_form_demanda.js')}}"></script>

</body>
</html>
