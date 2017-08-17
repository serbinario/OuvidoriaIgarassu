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

                @if(Session::has('warning'))
                    <div class="alert alert-warning">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <em> {!! session('warning') !!}</em>
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
            {!! Form::model($user, ['route'=> ['seracademico.user.update', $user->id], 'method' => "POST", 'enctype' => 'multipart/form-data' ]) !!}
            <div class="block-header">
                <h2>Editar usuário</h2>
            </div>
            <div class="card">
                <div class="card-body card-padding">
                    <div class="row">
                        <div class="col-md-12">

                            <div role="tabpanel">
                                <!-- Guias -->
                                <ul class="nav nav-tabs">
                                    <li role="presentation" class="active">
                                        <a href="#user" aria-controls="user" role="tab" data-toggle="tab">Dados Gerais</a>
                                    </li>
                                    {{--<li role="presentation">
                                        <a href="#permission" aria-controls="permission" role="tab" data-toggle="tab">Permissões</a>
                                    </li>--}}
                                    <li role="presentation">
                                        <a href="#perfil" aria-controls="perfil" role="tab" data-toggle="tab">Perfís</a>
                                    </li>
                                </ul>
                                <!-- Fim Guias -->

                                <!-- Conteúdo -->
                                <div class="tab-content">

                                    <div role="tabpanel" class="tab-pane active" id="user">
                                        <div class="row">
                                            <div class="form-group col-md-2">
                                                <div class="fg-line">
                                                    <div class="fg-line">
                                                        <label for="name">Nome</label>
                                                        {!! Form::text('name', null, array('class' => 'form-control')) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <div class="fg-line">
                                                    <div class="fg-line">
                                                        <label for="email">E-mail</label>
                                                        {!! Form::text('email', null, array('class' => 'form-control')) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <div class="fg-line">
                                                    <div class="fg-line">
                                                        <label for="password">Senha</label>
                                                        {!! Form::text('password', '', array('class' => 'form-control')) !!}
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="form-group col-md-3">
                                                <div class=" fg-line">
                                                    <label for="area_id">Secretaria</label>
                                                    <div class="select">
                                                        {!! Form::select('area_id', ['' => 'Selecione uma secretaria'] + $loadFields2['ouvidoria\secretaria']->toArray(), null,array('id' => 'area_id', 'class' => 'form-control')) !!}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <div class=" fg-line">
                                                    <label for="departamento_id">Departamento</label>
                                                    <div class="select">
                                                        @if(isset($user->departamento->id))
                                                            {!! Form::select('departamento_id', array($user->departamento->id => $user->departamento->nome), $user->departamento->id, array('class' => 'form-control', 'id' => 'departamento_id')) !!}
                                                        @else
                                                            {!! Form::select('departamento_id', array(), null, array('class' => 'form-control', 'id' => 'departamento_id')) !!}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label for="active" class="checkbox checkbox-inline m-r-20">
                                                    {!! Form::hidden('active', 0) !!}
                                                    {!! Form::checkbox('active', 1, null, ['id' => 'active']) !!}
                                                    <i class="input-helper"></i>
                                                    Ativar
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    {{--<div role="tabpanel" class="tab-pane" id="permission">
                                        <br/>

                                        <div id="tree-role">
                                            <ul>
                                                <li>
                                                    @if(count($user->permissions->lists('name')->all()) > 0)
                                                        <input type="checkbox" checked> Todos
                                                    @else
                                                        <input type="checkbox"> Todos
                                                    @endif
                                                    <ul>
                                                        @if(isset($loadFields['permission']))
                                                            @foreach($loadFields['permission'] as $id => $permission)
                                                                @if(\in_array($permission, $user->permissions->lists('name')->all()))
                                                                    <li><input type="checkbox" name="permission[]" checked value="{{ $id  }}"> {{ $permission }} </li>
                                                                @else
                                                                    <li><input type="checkbox" name="permission[]" value="{{ $id  }}"> {{ $permission }} </li>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>--}}

                                    <div role="tabpanel" class="tab-pane" id="perfil">
                                        <br/>

                                        <div id="tree-permission">
                                            <ul>
                                                @if(isset($loadFields['role']))
                                                    @foreach($loadFields['role'] as $id => $role)
                                                        @if(\in_array($role, $user->roles->lists('name')->all()))
                                                            <li><input type="checkbox" name="role[]" checked value="{{ $id  }}"> {{ $role }} </li>
                                                        @else
                                                            <li><input type="checkbox" name="role[]" value="{{ $id  }}"> {{ $role }} </li>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                                <!-- Fim Conteúdo -->
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
@stop

@section('javascript')
    <script type="text/javascript" class="init">
        $(document).ready(function () {
            //$("#tree-role, #tree-permission").tree();

            $('#user a').click(function (e) {
                e.preventDefault();
                $(this).tab('show');
            });
        });

        //Carregando os departamentos
        $(document).on('change', "#area_id", function () {
            //Removendo as assuntos
            $('#departamento_id option').remove();

            //Recuperando a secretaria
            var secretaria = $(this).val();

            if (secretaria !== "") {

                var dados = {
                    'table': 'gen_departamento',
                    'field_search': 'area_id',
                    'value_search': secretaria
                };

                jQuery.ajax({
                    type: 'POST',
                    url: "/index.php/seracademico/util/search",
                    data: dados,
                    datatype: 'json'
                }).done(function (json) {
                    var option = "";

                    option += '<option value="">Selecione</option>';
                    for (var i = 0; i < json.length; i++) {
                        option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
                    }

                    $('#departamento_id option').remove();
                    $('#departamento_id').append(option);
                });
            }
        });
    </script>
@stop