<html>
<head>
    <link href="{{ asset('/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900,300" rel="stylesheet">
    <link href="{{ asset('/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{ asset('/css/bootstrapValidation.mim.css')}}" rel="stylesheet">
    <link href="{{ asset('/css/jquery.datetimepicker.css')}}" rel="stylesheet"/>
</head>
<body>
<div class="conteiner">
    <div class="row">
        <center>
            <div class="topo" style="background-color: #213a53">
                <center>
                    <img src="{{asset('/img/ouvidoria-logo.png')}}" style="width: 500px; height: 150px">
                    {{--<img src="{{asset('/img/igarassu.png')}}" style="width: 400px; height: 90px">--}}
                </center>
            </div>
        </center>
    </div>
    <br />
    <center><h2>REGISTRO DE DEMANDA OUVIDORIA</h2></center>
    <hr style="width: 100%">
    <br />
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
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
            {!! Form::open(['route'=>'storePublico', 'method' => "POST", 'id'=> 'formDemanda' ]) !!}
            @include('tamplatesForms.tamplateFormDemandaPublic')
            {!! Form::close() !!}
        </div>
        <div class="col-md-2"></div>
    </div>
</div>

<script src="{{ asset('/js/jquery-2.1.1.js')}}"></script>
<script src="{{ asset('/js/jquery-ui.js')}}"></script>
<script src="{{ asset('/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('/js/jquery.mask.js')}}"></script>
<script src="{{ asset('/js/mascaras.js')}}"></script>
<script src="{{ asset('/js/bootstrapvalidator.js')}}" type="text/javascript"></script>
<script src="{{ asset('/js/jquery.datetimepicker.js')}}" type="text/javascript"></script>
<script src="{{ asset('/js/validacoes/validation_form_demanda.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#anonimo').on('change', function(){
            var value = $('#anonimo').val();
            if(value == '2') {
                $('#nome').prop('readonly', true);
                $('#tipo_resposta_id').prop('disabled', true);
                $('.dados-pessoas').hide();
            } else {
                $('#nome').prop('readonly', false);
                $('#tipo_resposta_id').prop('disabled', false);
                $('.dados-pessoas').show();
            }
        });
    });

    //Carregando os assuntos
    $(document).on('change', "#area_id", function () {
        //Removendo as assuntos
        $('#assunto_id option').remove();

        //Recuperando a secretaria
        var secretaria = $(this).val();

        if (secretaria !== "") {
            var dados = {
                'table' : 'ouv_assunto',
                'field_search' : 'area_id',
                'value_search': secretaria,
            };

            jQuery.ajax({
                type: 'POST',
                url: '{{ route('seracademico.util.search')  }}',
                headers: {
                    'X-CSRF-TOKEN': '{{  csrf_token() }}'
                },
                data: dados,
                datatype: 'json'
            }).done(function (json) {
                var option = "";

                option += '<option value="">Selecione um assunto</option>';
                for (var i = 0; i < json.length; i++) {
                    option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
                }

                $('#assunto_id option').remove();
                $('#assunto_id').append(option);
            });
        }
    });

    //Carregando os bairros
    $(document).on('change', "#assunto_id", function () {
        //Removendo as Bairros
        $('#subassunto_id option').remove();

        //Recuperando a cidade
        var assunto = $(this).val();

        if (assunto !== "") {
            var dados = {
                'table' : 'ouv_subassunto',
                'field_search' : 'assunto_id',
                'value_search': assunto,
            };

            jQuery.ajax({
                type: 'POST',
                url: '{{ route('seracademico.util.search')  }}',
                headers: {
                    'X-CSRF-TOKEN': '{{  csrf_token() }}'
                },
                data: dados,
                datatype: 'json'
            }).done(function (json) {
                var option = "";

                option += '<option value="">Selecione um subassunto</option>';
                for (var i = 0; i < json.length; i++) {
                    option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
                }

                $('#subassunto_id option').remove();
                $('#subassunto_id').append(option);
            });
        }
    });

    //Carregando as melhorias
    $(document).on('change', "#melhoria_secretaria", function () {
        //Removendo as assuntos
        $('#melhoria_id option').remove();

        //Recuperando a secretaria
        var secretaria = $(this).val();

        if (secretaria !== "") {
            var dados = {
                'table' : 'ouv_melhorias',
                'field_search' : 'area_id',
                'value_search': secretaria,
            };

            jQuery.ajax({
                type: 'POST',
                url: '{{ route('seracademico.util.search')  }}',
                headers: {
                    'X-CSRF-TOKEN': '{{  csrf_token() }}'
                },
                data: dados,
                datatype: 'json'
            }).done(function (json) {
                var option = "";

                option += '<option value="">Selecione</option>';
                for (var i = 0; i < json.length; i++) {
                    option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
                }

                $('#melhoria_id option').remove();
                $('#melhoria_id').append(option);
            });
        }
    });

</script>

</body>
</html>
