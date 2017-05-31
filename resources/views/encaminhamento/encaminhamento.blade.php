@extends('menu')

@section('content')
    <div class="container">
        <section id="content">
            {{-- Mensagem de alerta quando os dados não atendem as regras de validação que foramd efinidas no servidor --}}
            <div class="ibox-content">
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
            </div>
            {{-- Fim mensagem de alerta --}}
            {{--Formulario--}}
            {!! Form::open(['route'=>'seracademico.ouvidoria.encaminhamento.encaminharStore', 'method' => "POST", 'id'=> 'formEncaminhamento' ]) !!}
            <div class="block-header">
                <h2>Encaminhamento da demanda</h2>
            </div>
            <div class="card">
                <div class="card-body card-padding">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <div class=" fg-line">
                                        <label for="secretaria">Secretaria *</label>
                                        <div class="select">
                                            {!! Form::select('secretaria', (["" => "Selecione"] + $loadFields['ouvidoria\secretaria']->toArray()), null, array('class' => 'form-control', 'id' => 'secretaria')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class=" fg-line">
                                        <label for="destinatario_id">Destino *</label>
                                        <div class="select">
                                            {!! Form::select('destinatario_id', array(), null, array('class' => 'form-control', 'id' => 'destinatario_id')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class=" fg-line">
                                        <label for="prioridade_id">Prioridade *</label>
                                        <div class="select">
                                            {!! Form::select('prioridade_id',  (["" => "Selecione"] + $loadFields['ouvidoria\prioridade']->toArray()), Session::getOldInput('encaminhamento[prioridade_id]'), array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <div class=" fg-line">
                                        <label for="assunto_id">Assunto</label>
                                        <div class="select">
                                            {!! Form::select('assunto_id', array(), Session::getOldInput('assunto_id'), array('class' => 'form-control', 'id' => 'assunto_id')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <label for="assunto_id"></label>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-sm m-t-10"  data-toggle="modal" data-target="#modal_assunto" id="add-assunto" style="margin-left: -31px;" type="button">+
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class=" fg-line">
                                        <label for="assunto_id">Subassunto</label>
                                        {!! Form::select('subassunto_id', array(), Session::getOldInput('subassunto_id'),array('class' => 'form-control', 'id' => 'subassunto_id')) !!}
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <label for="assunto_id"></label>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-sm m-t-10" data-toggle="modal" data-target="#modal_subassunto" id="add-subassunto" style="margin-left: -31px;" type="button">+
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-8">
                                    <div class="form-group">
                                        <div class="fg-line">
                                            <label for="parecer">Comentário/Parecer</label>
                                            <div class="textarea">
                                                {!! Form::textarea('parecer', Session::getOldInput('encaminhamento[parecer]'),
                                                    array('class' => 'form-control', 'rows' => '5')) !!}
                                            </div>
                                            <input type="hidden" name="demanda_id" value="@if(isset($model)) {{$model->demanda_id}} @else {{$id}} @endif">
                                            <input type="hidden" name="id" value="@if(isset($model)){{$model->id}}@endif">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-primary btn-sm m-t-10">Salvar</button>
                            <button type="button" class="btn btn-primary btn-sm m-t-10" onclick='javascript:history.back();'>Voltar</button>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
            {{--Fim formulario--}}
        </section>
    </div>

    @include('modals.modal_cadastro_assunto')
    @include('modals.modal_cadastro_subassunto')
@stop

@section('javascript')
    {{--Mensagens personalizadas--}}
    <script type="text/javascript" src="{{ asset('/dist/js/messages_pt_BR.js')  }}"></script>

    {{-- --}}
    <script type="text/javascript" src="{{ asset('/dist/js/validacao/adicional/alphaSpace.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/lib/jquery-validation/src/additional/integer.js')  }}"></script>
    <script src="{{ asset('/js/validacoes/encaminhamento.js')}}"></script>

    <script type="text/javascript">
        // Cadastrar assunto
        $(document).on('click', "#salvar-assunto", function(){

            var nome = $("#nome-assunto").val();
            var area = $("#secretaria").val();

            if(nome && area) {

                var dados = {
                    'nome': nome,
                    'area_id' : area
                };

                jQuery.ajax({
                    type: 'POST',
                    url: '{{ route('seracademico.ouvidoria.assunto.storeAjax')  }}',
                    data: dados,
                    datatype: 'json'
                }).done(function (json) {

                    if(json['success']) {
                        swal("Ops!", "Assunto cadastrado com sucesso!", "success");
                        $('#modal_assunto').modal('toggle');
                        $("#nome-assunto").val("");

                        var dados = {
                            'table' : 'ouv_assunto',
                            'field_search' : 'area_id',
                            'value_search': area,
                        };

                        loadAssuntos(dados);
                    }

                });

            } else {
                swal("Ops!", "Você deve ter selecionado uma secretaria e informa o nome do assunto!", "warning");
            }

        });

        // Cadastrar subassunto
        $(document).on('click', "#salvar-subassunto", function(){

            var nome    = $("#nome-subassunto").val();
            var assunto = $("#assunto_id").val();

            if(nome && assunto) {

                var dados = {
                    'nome': nome,
                    'assunto_id' : assunto
                };

                jQuery.ajax({
                    type: 'POST',
                    url: '{{ route('seracademico.ouvidoria.subassunto.storeAjax')  }}',
                    data: dados,
                    datatype: 'json'
                }).done(function (json) {

                    if(json['success']) {
                        swal("Ops!", "Subassunto cadastrado com sucesso!", "success");
                        $('#modal_subassunto').modal('toggle');
                        $("#nome-subassunto").val("");

                        var dados = {
                            'table' : 'ouv_subassunto',
                            'field_search' : 'assunto_id',
                            'value_search': assunto,
                        };

                        loadSubassuntos(dados);
                    }

                });

            } else {
                swal("Ops!", "Você deve ter selecionado um assunto e informa o nome do subassunto!", "warning");
            }

        });

        //Carregando os bairros
        $(document).on('change', "#secretaria", function () {
            //Removendo as assuntos
            $('#destinatario_id option').remove();

            //Recuperando a secretaria
            var secretaria = $(this).val();

            if (secretaria !== "") {

                var dados = {
                    'table' : 'ouv_destinatario',
                    'field_search' : 'area_id',
                    'value_search': secretaria,
                };

                jQuery.ajax({
                    type: 'POST',
                    url: '{{ route('seracademico.util.search')  }}',
                    data: dados,
                    datatype: 'json'
                }).done(function (json) {
                    var option = "";

                    option += '<option value="">Selecione</option>';
                    for (var i = 0; i < json.length; i++) {
                        option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
                    }

                    $('#destinatario_id option').remove();
                    $('#destinatario_id').append(option);
                });
            }
        });

        // Funcção para carregar os assunto
        function loadAssuntos(dados) {

            //Removendo as assuntos
            $('#assunto_id option').remove();

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

        //Carregando os assuntos
        $(document).on('change', "#secretaria", function () {

            //Recuperando a secretaria
            var secretaria = $(this).val();

            if (secretaria !== "") {

                var dados = {
                    'table' : 'ouv_assunto',
                    'field_search' : 'area_id',
                    'value_search': secretaria,
                };

                loadAssuntos(dados);
            }
        });


        // Função para carregar os subassuntos
        function loadSubassuntos(dados) {

            //Removendo as Bairros
            $('#subassunto_id option').remove();

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

        //Carregando os subassunto
        $(document).on('change', "#assunto_id", function () {

            //Recuperando a cidade
            var assunto = $(this).val();

            if (assunto !== "") {
                var dados = {
                    'table' : 'ouv_subassunto',
                    'field_search' : 'assunto_id',
                    'value_search': assunto,
                };

                loadSubassuntos(dados);
            }
        });
    </script>
@stop