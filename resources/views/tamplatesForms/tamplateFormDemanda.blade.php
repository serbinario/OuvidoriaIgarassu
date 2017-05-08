<div class="block-header">
    <h2>Cadastro de Demandas</h2>
</div>
<div class="card">
    <div class="card-body card-padding">

        {{--<input type="hidden" id="idAluno" value="{{ isset($model->cgm->id) ? $model->cgm->id : null }}">--}}

        <div class="row">
            <div class="col-md-12">

                <!-- Painel -->
                <div role="tabpanel">
                    <!-- Guias -->
                    <ul id="tabs" class="tab-nav" role="tablist" data-tab-color="cyan">
                        <li class="active"><a href="#dados" aria-controls="dados" role="tab" data-toggle="tab">Dados Principais</a>
                        </li>
                       {{-- <li><a href="#perfil" aria-controls="perfil" role="tab" data-toggle="tab">Perfil</a>
                        </li>--}}
                        <li><a href="#outros" aria-controls="outros" role="tab" data-toggle="tab">Outras Informações</a>
                        </li>
                        @if(!isset($model))
                            <li><a href="#encaminhamento" aria-controls="encaminhamento" role="tab" data-toggle="tab">Encaminhamento</a>
                            </li>
                        @endif
                    </ul>
                    <!-- Fim Guias -->

                    <!-- Conteúdo -->
                    <div class="tab-content">
                        {{--#1--}}
                        <div role="tabpanel" class="tab-pane active" id="dados">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <div class=" fg-line">
                                        <label for="sigilo_id">Sigilo</label>
                                        <div class="select">
                                            {!! Form::select('sigilo_id', $loadFields['ouvidoria\sigilo'], null, array('class'=> 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <div class=" fg-line">
                                        <label for="anonimo_id">Anônimo</label>
                                        <div class="select">
                                            {!! Form::select('anonimo_id', $loadFields['ouvidoria\anonimo'], null, array('class'=> 'form-control' , 'id' => 'anonimo')) !!}
                                        </div>
                                    </div>
                                </div>
                                {{--<div class="form-group col-md-2">
                                    <div class=" fg-line">
                                        <label for="tipo_resposta_id">Tipo de resposta</label>
                                        <div class="select">
                                            {!! Form::select('tipo_resposta_id', (["" => "Selecione"] + $loadFields['ouvidoria\tiporesposta']->toArray()), null, array('class'=> 'form-control' , 'id' => 'tipo_resposta_id')) !!}
                                        </div>
                                    </div>
                                </div>--}}
                                <div class="form-group col-md-2">
                                    <div class="fg-line">
                                        <div class="fg-line">
                                            <label for="data_da_ocorrencia">Data da ocorrência</label>
                                            {!! Form::text('data_da_ocorrencia', Session::getOldInput('data_da_ocorrencia'), array('class' => 'form-control input-sm date', 'id' => 'data_da_ocorrencia', 'placeholder' => 'Data da ocorrência')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <div class="fg-line">
                                        <div class="fg-line">
                                            <label for="hora_da_ocorrencia">Hora da ocorrência</label>
                                            {!! Form::text('hora_da_ocorrencia', Session::getOldInput('hora_da_ocorrencia'), array('class' => 'form-control input-sm time', 'placeholder' => 'Hora da ocorrência')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <div class="fg-line">
                                        <div class="fg-line">
                                            <label for="nome">Nome</label>
                                            {!! Form::text('nome', Session::getOldInput('nome'), array('class' => 'form-control input-sm', 'id' => 'nome', 'placeholder' => 'Nome Completo')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class=" fg-line">
                                        <label for="idade_id">Idade</label>
                                        <div class="select">
                                            {!! Form::select('idade_id', $loadFields2['ouvidoria\idade'], null, array('class'=> 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="fg-line">
                                        <div class="fg-line">
                                            <label for="email">E-mail</label>
                                            {!! Form::text('email', Session::getOldInput('email'), array('class' => 'form-control input-sm', 'placeholder' => 'Endereço Eletrônico')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <div class="fg-line">
                                        <div class="fg-line">
                                            <label for="fone">Telefone</label>
                                            {!! Form::text('fone', Session::getOldInput('fone'), array('class' => 'form-control input-sm telefone', 'placeholder' => 'Telefone para Contato')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('comunidade_id', 'Bairro') !!}
                                        {!! Form::select('comunidade_id',(["" => "Selecione"] + $loadFields['ouvidoria\comunidade']->toArray()), Session::getOldInput('comunidade_id'), array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <div class="fg-line">
                                        <div class="fg-line">
                                            <label for="endereco">Endereço</label>
                                            {!! Form::text('endereco', Session::getOldInput('endereco'), array('class' => 'form-control input-sm', 'placeholder' => 'Endereço')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="fg-line">
                                        <div class="fg-line">
                                            <label for="numero">Número</label>
                                            {!! Form::text('numero', Session::getOldInput('numero'), array('class' => 'form-control input-sm', 'placeholder' => 'Número')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <div class=" fg-line">
                                        <label for="informacao_id">Tipo de manifestação</label>
                                        <div class="select">
                                            {!! Form::select('informacao_id', $loadFields['ouvidoria\informacao'], null, array('class'=> 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class=" fg-line">
                                        <label for="pessoa_id">Autor da manifestação</label>
                                        <div class="select">
                                            {!! Form::select('pessoa_id', $loadFields['ouvidoria\ouvpessoa'], null, array('class'=> 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class=" fg-line">
                                        <label for="tipo_demanda_id">Origem da manifestação</label>
                                        <div class="select">
                                            {!! Form::select('tipo_demanda_id', $loadFields['ouvidoria\tipodemanda'], null, array('class'=> 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <div class=" fg-line">
                                        <label for="area_id">Área</label>
                                        <div class="select">
                                            @if(isset($model->subassunto->assunto->secretaria->id))
                                                {!! Form::select('area_id', (["" => "Selecione"] + $loadFields['ouvidoria\secretaria']->toArray()), $model->subassunto->assunto->secretaria->id, array('class' => 'form-control', 'id' => 'area_id')) !!}
                                            @else
                                                {!! Form::select('area_id', (["" => "Selecione"] + $loadFields['ouvidoria\secretaria']->toArray()), Session::getOldInput('area_id'), array('class' => 'form-control', 'id' => 'area_id')) !!}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class=" fg-line">
                                        <label for="assunto_id">Assunto</label>
                                        <div class="select">
                                            @if(isset($model->subassunto->assunto->id))
                                                {!! Form::select('assunto_id', $loadFields['ouvidoria\assunto'], $model->subassunto->assunto->id, array('class' => 'form-control', 'id' => 'assunto_id')) !!}
                                            @else
                                                {!! Form::select('assunto_id', $loadFields['ouvidoria\assunto'], Session::getOldInput('assunto_id'), array('class' => 'form-control', 'id' => 'assunto_id')) !!}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class=" fg-line">
                                        <label for="assunto_id">Subassunto</label>
                                        @if(isset($model->subassunto->id))
                                            {!! Form::select('subassunto_id', array($model->subassunto->id => $model->subassunto->nome), $model->subassunto->id,array('class' => 'form-control', 'id' => 'subassunto_id')) !!}
                                        @else
                                            {!! Form::select('subassunto_id', array(), Session::getOldInput('subassunto_id'),array('class' => 'form-control', 'id' => 'subassunto_id')) !!}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <div class="form-group">
                                        <div class="fg-line">
                                            <label for="relato">Relato</label>
                                            <div class="textarea">
                                                {!! Form::textarea('relato', Session::getOldInput('relato'),
                                                    array('class' => 'form-control', 'rows' => '5')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--#1--}}
                        {{--#2--}}
                        {{--<div role="tabpanel" class="tab-pane" id="perfil">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <div class=" fg-line">
                                        <label for="sexos_id">Sexo</label>
                                        <div class="select">
                                            {!! Form::select('sexos_id', $loadFields['sexo'], null, array('class'=> 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class=" fg-line">
                                        <label for="exclusividade_sus_id">Utiliza exclusivamente o SUS?</label>
                                        <div class="select">
                                            {!! Form::select('exclusividade_sus_id', (["2" => "Sim"] + $loadFields['ouvidoria\exclusividadesus']->toArray()), null, array('class'=> 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class=" fg-line">
                                        <label for="idade_id">Idade</label>
                                        <div class="select">
                                            {!! Form::select('idade_id', $loadFields2['ouvidoria\idade'], null, array('class'=> 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class=" fg-line">
                                        <label for="escolaridade_id">Escolaridade</label>
                                        <div class="select">
                                            {!! Form::select('escolaridade_id', (["1" => "Não informado"] + $loadFields['ouvidoria\escolaridade']->toArray()), null, array('class'=> 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>--}}
                        {{--#2--}}
                        {{--#3--}}
                        <div role="tabpanel" class="tab-pane" id="outros">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <div class=" fg-line">
                                        <label for="melhoria_secretaria">Secretaria</label>
                                        <div class="select">
                                            @if(isset($model->melhoria->secretaria->id))
                                                {!! Form::select('melhoria_secretaria', (["" => "Selecione"] + $loadFields['ouvidoria\secretaria']->toArray()), $model->melhoria->secretaria->id, array('class' => 'form-control', 'id' => 'melhoria_secretaria')) !!}
                                            @else
                                                {!! Form::select('melhoria_secretaria', (["" => "Selecione"] + $loadFields['ouvidoria\secretaria']->toArray()), Session::getOldInput('area_id'), array('class' => 'form-control', 'id' => 'melhoria_secretaria')) !!}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class=" fg-line">
                                        <label for="melhoria_id">Melhoria</label>
                                        <div class="select">
                                            @if(isset($model->melhoria->id))
                                                {!! Form::select('melhoria_id', array($model->melhoria->id => $model->melhoria->nome), $model->melhoria->id,array('class' => 'form-control', 'id' => 'melhoria_id')) !!}
                                            @else
                                                {!! Form::select('melhoria_id', array(), Session::getOldInput('subassunto_id'),array('class' => 'form-control', 'id' => 'melhoria_id')) !!}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <div class="form-group">
                                        <div class="fg-line">
                                            <label for="melhorias">Quais melhorias você identifica na saúde de Igarassu?</label>
                                            <div class="textarea">
                                                {!! Form::textarea('melhorias', Session::getOldInput('relato'),
                                                    array('class' => 'form-control', 'rows' => '5')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <div class="form-group">
                                        <div class="fg-line">
                                            <label for="obs">Observações</label>
                                            <div class="textarea">
                                                {!! Form::textarea('obs', Session::getOldInput('relato'),
                                                    array('class' => 'form-control', 'rows' => '5')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--#3--}}
                        {{--#4--}}
                        @if(!isset($model))
                            <div role="tabpanel" class="tab-pane" id="encaminhamento">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <div class=" fg-line">
                                            <label for="secretaria">Secretaria *</label>
                                            <div class="select">
                                                {!! Form::select('secretaria', (["" => "Selecione"] + $loadFields['ouvidoria\secretaria']->toArray()), Session::getOldInput('secretaria'), array('class' => 'form-control', 'id' => 'secretaria')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class=" fg-line">
                                            <label for="encaminhamento[destinatario_id]">Destino *</label>
                                            <div class="select">
                                                {!! Form::select('encaminhamento[destinatario_id]', array(), Session::getOldInput('destinatario_id'), array('class' => 'form-control', 'id' => 'destinatario_id')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class=" fg-line">
                                            <label for="encaminhamento[prioridade_id]">Prioridade *</label>
                                            <div class="select">
                                                {!! Form::select('encaminhamento[prioridade_id]',  (["" => "Selecione"] + $loadFields['ouvidoria\prioridade']->toArray()), Session::getOldInput('encaminhamento[prioridade_id]'), array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    {{--<div class="form-group col-md-3">
                                        <div class=" fg-line">
                                            <label for="encaminhamento[status_id]">Status</label>
                                            <div class="select">
                                                {!! Form::select('encaminhamento[status_id]', (["" => "Selecione"] + $loadFields['ouvidoria\status']->toArray()), Session::getOldInput('encaminhamento[status_id]'), array('class' => 'form-control', 'id' => 'encaminhamento')) !!}
                                            </div>
                                        </div>
                                    </div>--}}
                                </div>
                                {{--<div class="row">
                                    <div class="form-group col-md-5">
                                        <div class="fg-line">
                                            <div class="fg-line">
                                                <label for="encaminhamento[encaminhado]">Documento Encaminhamento</label>
                                                {!! Form::text('encaminhamento[encaminhado]', Session::getOldInput('encaminhamento[encaminhado]')  , array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <div class="fg-line">
                                            <div class="fg-line">
                                                <label for="encaminhamento[copia]">Cópia Para</label>
                                                {!! Form::text('encaminhamento[copia]', Session::getOldInput('encaminhamento[copia]')  , array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>--}}
                                <div class="row">
                                    <div class="form-group col-md-8">
                                        <div class="form-group">
                                            <div class="fg-line">
                                                <label for="encaminhamento[parecer]">Comentário/Parecer</label>
                                                <div class="textarea">
                                                    {!! Form::textarea('encaminhamento[parecer]', Session::getOldInput('encaminhamento[parecer]'),
                                                        array('class' => 'form-control', 'rows' => '5')) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        {{--#4--}}
                    </div>
                    <!-- Conteúdo -->
                </div>
                <!-- Painel -->
                <button class="btn btn-primary btn-sm m-t-10 submit">Salvar</button>
                <a class="btn btn-primary btn-sm m-t-10" href="{{ route('seracademico.ouvidoria.demanda.index') }}">Voltar</a>
            </div>
        </div>
    </div>
</div>

@section('javascript')
    {{--Mensagens personalizadas--}}
    <script type="text/javascript" src="{{ asset('/dist/js/messages_pt_BR.js')  }}"></script>

    {{-- --}}
    <script type="text/javascript" src="{{ asset('/dist/js/validacao/adicional/alphaSpace.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/lib/jquery-validation/src/additional/integer.js')  }}"></script>
    <script src="{{ asset('/js/validacoes/demanda.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#anonimo').on('change', function(){
                var value = $('#anonimo').val();
                if(value == '2') {
                    $('#nome').prop('readonly', true);
                    $('#tipo_resposta_id').prop('disabled', true);
                } else {
                    $('#nome').prop('readonly', false);
                    $('#tipo_resposta_id').prop('disabled', false);
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

                    $('#destinatario_id option').remove();
                    $('#destinatario_id').append(option);
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
@stop