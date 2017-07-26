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
                            <div>{{ utf8_encode($error) }}</div>
                        @endforeach
                    </div>
                @endif
            </div>
            {{-- Fim mensagem de alerta --}}
            {{--Formulario--}}
            {!! Form::open(['route'=>'seracademico.ouvidoria.encaminhamento.primeiroEncaminharStore', 'method' => "POST", 'id'=> 'formPrimeiroEncaminhamento' ]) !!}
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
                                        <label for="secretaria">Encaminhar *</label>
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
                                            {!! Form::select('prioridade_id',  (["" => "Selecione"] + $loadFields['ouvidoria\prioridade']->toArray()),
                                            Session::getOldInput('encaminhamento[prioridade_id]'), array('class' => 'form-control', 'id' => 'prioridade')) !!}
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
                                <div class="form-group col-md-9">
                                    <div class="fg-line">
                                        <label for="relato">Relato</label>
                                        <div class="textarea">
                                            {!! Form::textarea('relato', $manifestacao->relato,
                                                array('class' => 'form-control', 'rows' => '5', 'readonly' => 'readonly')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-9">
                                    <div class="fg-line">
                                        <label for="parecer">Comentário/Parecer</label>

                                        <div class="textarea">
                                            {!! Form::textarea('parecer', Session::getOldInput('encaminhamento[parecer]'),
                                                array('class' => 'form-control', 'rows' => '5', 'id' => 'parecer')) !!}
                                        </div>
                                        <input type="hidden" id="demanda_id" name="demanda_id" value="@if(isset($model)) {{$model->demanda_id}} @else {{$id}} @endif">
                                        <input type="hidden" id="id" name="id" value="@if(isset($model)){{$model->id}}@endif">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm m-t-10">Salvar</button>
                            <button type="button" class="btn btn-primary btn-sm m-t-10" onclick='javascript:history.back();'>Voltar</button>
                            <button type="button" disabled id="respManifestacaoAjax" class="btn btn-success btn-sm m-t-10">Responder</button>
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
