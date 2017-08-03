<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="form-group col-md-7">
                {!! Form::label('nome', 'Nome *') !!}
                {!! Form::text('nome',  Session::getOldInput('nome') , array('class' => 'form-control')) !!}
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('data_nasciemento', 'Nascimento *') !!}
                {!! Form::text('data_nasciemento', null, array('class' => 'form-control datepicker date')) !!}
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('sexos_id]', 'Sexo ') !!}
                {!! Form::select('sexos_id', $loadFields['sexo'], Session::getOldInput('sexos_id'), array('class' => 'form-control')) !!}
            </div>
            <div class="form-group col-md-1">
                {!! Form::label('ativar', 'Ativar') !!}
                <div class="checkbox checkbox-primary">
                    {!! Form::hidden('ativo', 0) !!}
                    {!! Form::checkbox('ativo', 1, null, array('class' => 'form-control')) !!}
                    {!! Form::label('ativo', 'Ativar', false) !!}
                </div>
            </div>

        </div>
    </div>
    {{--<div class="col-md-2">--}}
        {{--<div class="fileinput fileinput-new" data-provides="fileinput">--}}
            {{--<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 135px; height: 115px;">--}}
                {{--@if (isset($aluno) && $aluno->path_image != null)--}}
                    {{--<div id="midias">--}}
                        {{--<img id="logo" src="/images/{{$aluno->path_image}}"  alt="Foto" height="120" width="100"/><br/>--}}
                    {{--</div>--}}
                {{--@endif--}}
            {{--</div>--}}
            {{--<div>--}}
               {{--<span class="btn btn-primary btn-xs btn-block btn-file">--}}
                   {{--<span class="fileinput-new">Selecionar</span>--}}
                   {{--<span class="fileinput-exists">Mudar</span>--}}
                   {{--<input type="file" name="img">--}}
               {{--</span>--}}
                {{--<a href="#" class="btn btn-warning btn-xs fileinput-exists col-md-6" data-dismiss="fileinput">Remover</a>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
</div>
<hr class="hr-line-dashed"/>


<div class="row">
    <div class="col-md-12">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#dados" aria-controls="dados" data-toggle="tab"><i class="fa fa-male"></i> Dados pessoais</a>
            </li>
            <li role="presentation">
                <a href="#contato" aria-controls="contato" role="tab" data-toggle="tab"><i class="fa fa-globe"></i>Informações para contato</a>
            </li>
        </ul>
        <!-- End Nav tabs -->

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="dados">
                <br/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-md-2">
                                {!! Form::label('estados_civis_id', 'Estado Civil ') !!}
                                {!! Form::select('estados_civis_id', (['' => 'Selecione uma opção'] + $loadFields['estadocivil']->toArray()), null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="row">

                        </div>
                        <legend><i class="fa fa-archive"></i> Outros dados</legend>
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default">


                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"> <i
                                                    class="fa fa-plus-circle"></i> Documentos</a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                {!! Form::label('identidade', 'Identidade *') !!}
                                                {!! Form::text('identidade', Session::getOldInput('identidade'), array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                {!! Form::label('cpf', 'CPF *') !!}
                                                {!! Form::text('cpf', Session::getOldInput('cpf'), array('class' => 'form-control cpf', 'id' => 'cpfAlunos')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane" id="contato">
                <br/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-md-8">
                                {!! Form::label('endereco[logradouro]', 'Endereço ') !!}
                                {!! Form::text('endereco[logradouro]', Session::getOldInput('endereco[logradouro]'), array('class' => 'form-control')) !!}
                            </div>

                            <div class="form-group col-md-2">
                                {!! Form::label('endereco[cep]', 'CEP') !!}
                                {!! Form::text('endereco[cep]', Session::getOldInput('endereco[cep]'), array('class' => 'form-control')) !!}
                            </div>

                            <div class="form-group col-md-2">
                                {!! Form::label('endereco[numero]', 'Número') !!}
                                {!! Form::text('endereco[numero]', Session::getOldInput('endereco[numero]'), array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                {!! Form::label('estado', 'UF ') !!}
                                @if(isset($model->endereco->bairro->cidade->estado->id))
                                    {!! Form::select('estado', $loadFields['estado'], $model->endereco->bairro->cidade->estado->id, array('class' => 'form-control', 'id' => 'estado')) !!}
                                @else
                                    {!! Form::select('estado', $loadFields['estado'], Session::getOldInput('estado'), array('class' => 'form-control', 'id' => 'estado')) !!}
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('cidade', 'Cidade ') !!}
                                @if(isset($model->endereco->bairro->cidade->id))
                                    {!! Form::select('cidade', array($model->endereco->bairro->cidade->id => $model->endereco->bairro->cidade->nome), $model->gen_endereco->bairro->cidade->id,array('class' => 'form-control', 'id' => 'cidade')) !!}
                                @else
                                    {!! Form::select('cidade', array(), Session::getOldInput('cidade'),array('class' => 'form-control', 'id' => 'cidade')) !!}
                                @endif
                            </div>
                            <div class="form-group col-md-3">
                                {!! Form::label('gen_endereco[bairros_id]', 'Bairro ') !!}
                                @if(isset($model->gen_endereco->bairro->id))
                                    {!! Form::select('gen_endereco[bairros_id]', array($model->gen_endereco->bairro->id => $model->gen_endereco->bairro->nome), $model->gen_endereco->bairro->id,array('class' => 'form-control', 'id' => 'bairro')) !!}
                                @else
                                    {!! Form::select('gen_endereco[bairros_id]', array(), Session::getOldInput('bairro'),array('class' => 'form-control', 'id' => 'bairro')) !!}
                                @endif
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label('gen_endereco[complemento]', 'Complemento ') !!}
                                {!! Form::text('gen_endereco[complemento]', Session::getOldInput('gen_endereco[complemento]'), array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <legend><i class="fa fa-phone"></i> Contato</legend>
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#contato1"> <i
                                                    class="fa fa-plus-circle"></i> Contato pessoal</a>
                                    </h4>
                                </div>
                                <div id="contato1" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group col-md-5">
                                                {!! Form::label('email', 'E-mail') !!}
                                                {!! Form::text('email', Session::getOldInput('email'), array('class' => 'form-control')) !!}
                                            </div>
                                            <div class="form-group col-md-3">
                                                {!! Form::label('telefone_fixo', 'Telefone fixo') !!}
                                                {!! Form::text('telefone_fixo', Session::getOldInput('telefone_fixo') , array('class' => 'form-control phone')) !!}
                                            </div>
                                            <div class="form-group col-md-2">
                                                {!! Form::label('celular', 'Celular') !!}
                                                {!! Form::text('celular', Session::getOldInput('celular'), array('class' => 'form-control phone')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Fim da aba vestibular --}}
        </div>
    </div>
    <div class="col-md-10"></div>

    {{--Buttons Submit e Voltar--}}
    <div class="row">
        <div class="col-md-9"></div>
        <div class="col-md-3">
            <div class="btn-group btn-group-justified">
                <div class="btn-group">
                    <a href="{{ route('seracademico.biblioteca.indexPessoa') }}" class="btn btn-primary btn-block pull-right">Voltar</a>
                </div>
                <div class="btn-group">
                    {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block pull-right', 'id' => 'submitForm')) !!}
                </div>
            </div>
        </div>

    </div>
    {{--Fim Buttons Submit e Voltar--}}
</div>
</div>

@section('javascript')
    <script type="text/javascript">
        //Carregando as cidades
        $(document).on('change', "#estado", function () {
            //Removendo as cidades
            $('#cidade option').remove();

            //Removendo as Bairros
            $('#bairro option').remove();

            //Recuperando o estado
            var estado = $(this).val();

            if (estado !== "") {
                var dados = {
                    'table' : 'gen_cidades',
                    'field_search' : 'estados_id',
                    'value_search': estado,
                };

                jQuery.ajax({
                    type: 'POST',
                    url: '{{ route('seracademico.util.search')  }}',
                    data: dados,
                    datatype: 'json',
                    headers: {
                        'X-CSRF-TOKEN' : '{{  csrf_token() }}'
                    },
                }).done(function (json) {
                    var option = "";

                    option += '<option value="">Selecione uma cidade</option>';
                    for (var i = 0; i < json.length; i++) {
                        option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
                    }

                    $('#cidade option').remove();
                    $('#cidade').append(option);
                });
            }
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
                    'value_search': cidade,
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
@endsection
