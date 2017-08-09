<!DOCTYPE html>

<html class="ie9">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="{{ asset('/lib/chosen/chosen.css') }}" rel="stylesheet">
    <link href="{{ asset('/lib/summernote/dist/summernote.css') }}" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{ asset('/lib/sweetalert2/dist/sweetalert2.min.css') }}"  media="screen,projection"/>

    <link type="text/css" rel="stylesheet" href="{{ asset('/dist/css/app_1.min.css') }}"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('/dist/css/app_2.min.css') }}"  media="screen,projection"/>

    {{-- CSS personalizados--}}
    <link type="text/css" rel="stylesheet" href="{{ asset('/dist/css/demo.css') }}"  media="screen,projection"/>
    <link href="{{ asset('/css/bootstrapValidation.mim.css')}}" rel="stylesheet">
    <link href="{{ asset('/css/jquery.datetimepicker.css')}}" rel="stylesheet"/>
    <style type="text/css" class="init">

        *  {
            margin:0;
            padding:0;
        }

        html, body {height:100%;}

        .geral {
            min-height:100%;
            position:relative;
            width:100%;
        }

        .footer {
            position:absolute;
            bottom:0;
            width:100%;
        }

        .content {overflow:hidden;}
        .aside {width:200px;}
        .fleft {float:left;}
        .fright {float:right;}
    </style>
</head>
<body>

<div class="geral">

    <div class="header">
    </div>
    <div class="aside fleft">
    </div>
    <div class="aside fright">
    </div>

    <div class="content">

        <div class="row">
            <div class="col-sm-12 col-md-12" style="background-color: #0b8345">
                <center>
                    <img src="{{asset('/img/ouvidoria_saude.png')}}" class="img-responsive" style="width: 190px; height: 150px">
                    {{--<img src="{{asset('/img/igarassu.png')}}" style="width: 400px; height: 90px">--}}
                </center>
            </div>
        </div>
        <br />
        <center><h2><?php echo "REGISTRO DE MANIFESTAÇÃO DA OUVIDORIA"; ?></h2></center>

        <br />

        <div class="row">
            <div class="col-md-9 col-md-offset-2">
                @if(Session::has('message'))
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <em style="text-align: justify"> {!! session('message') !!}</em>
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

                {!! Form::open(['route'=>'storePublico', 'method' => "POST", 'id'=> 'formDemanda' ]) !!}

                {{--  Início do formulário --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">


                                <div class="card">
                                    <div class="card-header" style="background-color: #0b8345;">
                                        <h2 style="color: white">Identificação
                                            {{--<small>Multi-colored: red, blue, green, yellow</small>--}}
                                        </h2>
                                    </div>

                                    <div class="card-body card-padding">
                                        <br>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="radio m-b-15">
                                                    <label>
                                                        <input type="radio" id="sigilo-1" name="sigilo_id"
                                                               value="2">
                                                        <i class="input-helper"></i>
                                                        "Desejo me identificar"
                                                    </label>
                                                </div>
                                                <div class="radio m-b-15">
                                                    <label>
                                                        <input type="radio" id="sigilo-2" name="sigilo_id"
                                                               value="1">
                                                        <i class="input-helper"></i>
                                                        "Desejo sigilo"
                                                    </label>
                                                </div>
                                                <div class="radio m-b-15">
                                                    <label>
                                                        <input type="radio" id="sigilo-3" name="sigilo_id"
                                                               value="3">
                                                        <i class="input-helper"></i>
                                                        "Desejo anonimato"
                                                    </label>
                                                </div>
                                            </div>
                                            {{--<div class="form-group col-md-4">
                                                <div class=" fg-line">
                                                    <label for="tipo_resposta_id">Tipo de resposta</label>
                                                    <div class="select">
                                                        {!! Form::select('tipo_resposta_id', (["" => "Selecione"] + $loadFields['ouvidoria\tiporesposta']->toArray()), null, array('class'=> 'form-control' , 'id' => 'tipo_resposta_id')) !!}
                                                    </div>
                                                </div>
                                            </div>--}}
                                        </div>
                                    </div>
                                </div>

                                <div class="card dados-pessoais">
                                    <div class="card-header dados-pessoais" style="background-color: #0b8345;">
                                        <h2 style="color: white">Dados pessoais
                                            {{--<small>Multi-colored: red, blue, green, yellow</small>--}}
                                        </h2>
                                    </div>

                                    <div class="card-body card-padding dados-pessoais">
                                        <br>

                                        <div class="row">

                                            <div class="form-group col-md-8">
                                                <div class=" fg-line">
                                                    <label for="nome">Nome *</label>
                                                    {!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control', 'id' => 'nome')) !!}
                                                    @if(!isset($model->id))
                                                        {!! Form::hidden('tipo_demanda_id', '1') !!}
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group col-md-2">
                                                <div class=" fg-line">
                                                    <label for="sexos_id">Sexo *</label>

                                                    <div class="select">
                                                        {!! Form::select('sexos_id', (["" => "Selecione"] + $loadFields['sexo']->toArray()), Session::getOldInput('sexos_id'), array('class' => 'form-control')) !!}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-2">
                                                <div class=" fg-line">
                                                    <label for="idade_id">Idade *</label>

                                                    <div class="select">
                                                        {!! Form::select('idade_id', $loadFields2['ouvidoria\idade'], Session::getOldInput('idade_id'), array('class' => 'form-control')) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-2">
                                                <div class="fg-line">
                                                    {!! Form::label('cpf', 'CPF *') !!}
                                                    {!! Form::text('cpf', Session::getOldInput('cpf'), array('class' => 'form-control input-sm cpf', 'placeholder' => 'CPF')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <div class="fg-line">
                                                    {!! Form::label('rg', 'RG') !!}
                                                    {!! Form::text('rg', Session::getOldInput('rg'), array('class' => 'form-control input-sm', 'placeholder' => 'RG')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <div class="fg-line">
                                                    {!! Form::label('fone', 'Fone *') !!}
                                                    {!! Form::text('fone', Session::getOldInput('fone')  , array('class' => 'form-control telefone')) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {!! Form::label('email', 'E-mail') !!}
                                                    {!! Form::text('email', Session::getOldInput('email')  , array('class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-8">
                                                <div class="fg-line">
                                                    {!! Form::label('profissao', 'Profissão *') !!}
                                                    {!! Form::text('profissao', Session::getOldInput('profissao')  , array('class' => 'form-control', 'id' => 'profissao')) !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <div class="fg-line">
                                                    {!! Form::label('endereco', 'Endereço *') !!}
                                                    {!! Form::text('endereco', Session::getOldInput('endereco')  , array('class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <div class="fg-line">
                                                    {!! Form::label('numero_end', 'Número *') !!}
                                                    {!! Form::text('numero_end', Session::getOldInput('numero_end')  , array('class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <div class="fg-line">
                                                    {!! Form::label('cep', 'CEP') !!}
                                                    {!! Form::text('cep', Session::getOldInput('cep'), array('class' => 'form-control input-sm', 'placeholder' => 'CEP')) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-3">
                                                <div class="fg-line">
                                                    <label class="control-label" for="cidade">Cidade *</label>

                                                    <div class="select">
                                                        {!! Form::select('cidade', (["" => "Selecione"] + $loadFields['cidade']->toArray()), Session::getOldInput('cidade'),array('class' => 'form-control', 'id' => 'cidade')) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <div class="fg-line">
                                                    <label class="control-label" for="bairro">Bairro *</label>

                                                    <div class="select">
                                                        {!! Form::select('bairro_id', array(), Session::getOldInput('bairro_id'),array('class' => 'form-control', 'id' => 'bairro')) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header " style="background-color: #0b8345;">
                                        <h2 style="color: white">Dados da manifestação
                                            {{--<small>Multi-colored: red, blue, green, yellow</small>--}}
                                        </h2>
                                    </div>

                                    <div class="card-body card-padding">
                                        <br>

                                        <div class="row">

                                            <div class="form-group col-md-4">
                                                <div class=" fg-line">
                                                    <label for="pessoa_id">Autor da manifestação *</label>

                                                    <div class="select">
                                                        {!! Form::select('pessoa_id', $loadFields['ouvidoria\ouvpessoa'], Session::getOldInput('pessoa_id'), array('class' => 'form-control')) !!}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <div class=" fg-line">
                                                    <label for="informacao_id">Tipo de manifestação *</label>

                                                    <div class="select">
                                                        {!! Form::select('informacao_id', (["" => "Selecione"] + $loadFields['ouvidoria\informacao']->toArray()), Session::getOldInput('informacao_id'), array('class' => 'form-control')) !!}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-2">
                                                <div class="fg-line">
                                                    <div class="fg-line">
                                                        <label for="data_da_ocorrencia">Data da ocorrência</label>
                                                        {!! Form::text('data_da_ocorrencia', Session::getOldInput('data_da_ocorrencia'), array('class' => 'form-control date', 'id' => 'data_da_ocorrencia', 'placeholder' => 'Data da ocorrência')) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <div class="fg-line">
                                                    <div class="fg-line">
                                                        <label for="hora_da_ocorrencia">Hora da ocorrência</label>
                                                        {!! Form::text('hora_da_ocorrencia', Session::getOldInput('hora_da_ocorrencia'), array('class' => 'form-control time', 'placeholder' => 'Hora da ocorrência')) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12" id="msg-sigilo">
                                                    <span style="color: red">
                                                            * Para garantir o sigilo, Não coloque seu nome no campo de descrição da manifestação , seus dados ficarão restritos só a ouvidoria
                                                    </span>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <div class=" fg-line">
                                                    <label for="relato">Descrição da manifestação *</label>
                                                    {!! Form::textarea('relato', Session::getOldInput('relato') , array('class' => 'form-control', 'rows' => '5')) !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-offset-4 col-md-12">
                                                {!! App('captcha')->display($attributes = [], $lang = 'pt-BR') !!}
                                                {{--<div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>--}}
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" id="submit"
                                                        class="btn btn-primary btn-sm m-t-10 submit">Registrar
                                                    Manifestação
                                                </button>
                                                <a class="btn btn-default btn-sm m-t-10"
                                                   href="{{ route('indexPublico') }}">Voltar</a>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                {{-- Final do formulário --}}

                {!! Form::close() !!}
            </div>

            <div class="col-md-6">

            </div>
        </div>

    </div>

    <div class="footer">
        <center>
            <img src="{{ asset('/img/s1.png')}}" style="width: 10%;"/><br />
            <strong>Copyright &copy; 2015-2016 <a target="_blank" href="http://serbinario.com.br"><i></i>SERBINARIO</a> .</strong> Todos os direitos reservados.
        </center>
    </div>

</div>


<script src="{{ asset('/js/jquery-2.1.1.js')}}"></script>
<script src="{{ asset('/js/jquery-ui.js')}}"></script>
<script src="{{ asset('/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('/js/jquery.mask.js')}}"></script>
<script src="{{ asset('/js/mascaras.js')}}"></script>
<script src="{{ asset('/lib/sweetalert2/dist/sweetalert2.min.js') }}"></script>
<script src="{{ asset('/lib/jquery-validation/dist/jquery.validate.js') }}"></script>
<script src="{{ asset('/lib/jquery-validation/src/localization/messages_pt_BR.js') }}"></script>
<script src="{{ asset('/js/jquery.datetimepicker.js')}}" type="text/javascript"></script>
<script type="text/javascript">

    // Regras de validação
    $(document).ready(function () {

        $("#formDemanda").validate({
            rules: {

                sigilo_id: {
                    required: true
                },

                anonimo_id: {
                    required: true
                },

                /*nome: {
                 required: true
                 },

                 sexos_id: {
                 required: true
                 },

                 idade_id: {
                 required: true
                 },

                 cpf: {
                 required: true
                 },

                 fone: {
                 required: true
                 },

                 profissao: {
                 required: true
                 },

                 endereco: {
                 required: true
                 },

                 numero_end: {
                 required: true
                 },

                 cidade: {
                 required: true
                 },

                 bairro_id: {
                 required: true
                 },*/

                informacao_id: {
                    required: true
                },

                pessoa_id: {
                    required: true
                },

                relato: {
                    required: true
                }
            },
            //For custom messages
            /*messages: {
             nome_operadores:{
             required: "Enter a username",
             minlength: "Enter at least 5 characters"
             }
             },*/
            //Define qual elemento será adicionado
            errorElement : 'small',
            errorPlacement: function(error, element) {
                error.insertAfter(element.parent());
            },

            highlight: function(element, errorClass) {
                //console.log("Error");
                $(element).parent().parent().addClass("has-error");
            },

            unhighlight: function(element, errorClass, validClass) {
                //console.log("Sucess");
                $(element).parent().parent().removeClass("has-error");

            },

            submitHandler: function (form) {
                var response = grecaptcha.getResponse();

                //recaptcha failed validation
                if (response.length == 0) {
                    swal('Marque, EU NÃO SOU UM ROBÔ!', "Click no botão abaixo!", 'error');
                    $('#recaptcha-error').show();
                    return false;
                }

                //recaptcha passed validation
                else {
                    $('#recaptcha-error').hide();
                    return true;
                }
            }
        });
    });


    // Trata a questão de marcar o campo de sigilo como sigiloso, e ativar a mensagem sobre informação
    // de dados pessoais
    $(document).ready(function(){

        $('#msg-sigilo').hide();

        // Exibi a mensagem de informação para caso da opção de "Deseja sigilo" esta marcada
        $('#sigilo-2, #sigilo-1').on('click', function(){
            if($("#sigilo-2").prop( "checked")) {
                $('#msg-sigilo').show();
            } else if ($("#sigilo-1").prop( "checked")) {
                $('#msg-sigilo').hide();
            }
        });

        // Caso seja marcado como anônimo, os campos para dados pessoais seram desativados
        $('#sigilo-3, #sigilo-2, #sigilo-1').on('click', function(){
            if($("#sigilo-3").prop( "checked")) {
                $('.dados-pessoais').hide();
            } else if (!$("#sigilo-3").prop( "checked")) {
                $('.dados-pessoais').show();
            }
        });

    });

    //Carregando os bairros
    $(document).on('change', "#cidade", function () {

        //Removendo as Bairros
        $('#bairro option').remove();

        //Recuperando a cidade
        var cidade = $(this).val();

        if (cidade !== "") {

            var dados = {
                'table' : 'gen_bairros',
                'field_search' : 'cidades_id',
                'value_search': cidade
            };

            jQuery.ajax({
                type: 'POST',
                url: "/index.php/seracademico/util/search",
                data: dados,
                datatype: 'json'
            }).done(function (json) {
                var option = "";

                option += '<option value="">Selecione um bairro</option>';
                for (var i = 0; i < json.length; i++) {
                    option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
                }

                $('#bairro option').remove();
                $('#bairro').append(option);
            });
        }
    });
</script>

</body>
</html>
