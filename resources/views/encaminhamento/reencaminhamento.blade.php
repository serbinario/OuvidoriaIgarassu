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
            {!! Form::open(['route'=>'seracademico.ouvidoria.encaminhamento.reencaminarStore', 'method' => "POST", 'id'=> 'formReencaminhamento' ]) !!}
            <div class="block-header">
                <h2>Reencaminhamento da demanda</h2>
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
                                            {!! Form::select('secretaria', (["" => "Selecione"] + $loadFields['ouvidoria\secretaria']->toArray()), $model->destinatario->area->id, array('class' => 'form-control', 'id' => 'secretaria', 'readonly' => 'readonly')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class=" fg-line">
                                        <label for="destinatario_id">Destino *</label>
                                        <div class="select">
                                            {!! Form::select('destinatario_id', array($model->destinatario->id => $model->destinatario->nome), $model->destinatario->id, array('class' => 'form-control', 'id' => 'destinatario_id', 'readonly' => 'readonly')) !!}
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
                                <div class="form-group col-md-5">
                                    <div class="fg-line">
                                        <div class="fg-line">
                                            <label for="encaminhado">Documento Encaminhamento</label>
                                            {!! Form::text('encaminhado', Session::getOldInput('encaminhamento[encaminhado]')  , array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-5">
                                    <div class="fg-line">
                                        <div class="fg-line">
                                            <label for="copia">Cópia Para</label>
                                            {!! Form::text('copia', Session::getOldInput('encaminhamento[copia]')  , array('class' => 'form-control')) !!}
                                        </div>
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
                                            <input type="hidden" name="demanda_id" value="{{$model->demanda_id}}">
                                            <input type="hidden" name="id" value="{{$model->id}}">
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
@stop

@section('javascript')
    {{--Mensagens personalizadas--}}
    <script type="text/javascript" src="{{ asset('/dist/js/messages_pt_BR.js')  }}"></script>

    {{-- --}}
    <script type="text/javascript" src="{{ asset('/dist/js/validacao/adicional/alphaSpace.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/lib/jquery-validation/src/additional/integer.js')  }}"></script>
    <script src="{{ asset('/js/validacoes/reencaminhamento.js')}}"></script>
@endsection