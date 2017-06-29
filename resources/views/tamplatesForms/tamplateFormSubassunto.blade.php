<div class="block-header">
    <h2>Cadastro de Subassunto</h2>
</div>
<div class="card">
    <div class="card-body card-padding">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="form-group col-md-4">
                        <div class="fg-line">
                            <div class="fg-line">
                                <label for="nome">Subassunto *</label>
                                {!! Form::text('nome', Session::getOldInput('nome') , array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="fg-line">
                            <div class="fg-line">
                                <label for="secretaria">Secretaria *</label>
                                @if(isset($model->assunto->secretaria))
                                    {!! Form::select('secretaria', (["" => "Selecione"] + $loadFields['ouvidoria\secretaria']->toArray()), $model->assunto->secretaria->id, array('class' => 'form-control', 'id' => 'secretaria')) !!}
                                @else
                                    {!! Form::select('secretaria', (["" => "Selecione"] + $loadFields['ouvidoria\secretaria']->toArray()), Session::getOldInput('secretaria'), array('class' => 'form-control', 'id' => 'secretaria')) !!}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="fg-line">
                            <div class="fg-line">
                                <label for="assunto_id">Assunto *</label>
                                @if(isset($model->assunto->id))
                                    {!! Form::select('assunto_id', array($model->assunto->id => $model->assunto->nome), $model->assunto->id,array('class' => 'form-control', 'id' => 'assunto_id')) !!}
                                @else
                                    {!! Form::select('assunto_id', array(), Session::getOldInput('assunto_id'),array('class' => 'form-control', 'id' => 'assunto_id')) !!}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary btn-sm m-t-10">Salvar</button>
                <a class="btn btn-primary btn-sm m-t-10" href="{{ route('seracademico.ouvidoria.subassunto.index') }}">Voltar</a>
            </div>
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
    <script src="{{ asset('/js/validacoes/subassunto.js')}}"></script>
    <script src="{{ asset('/js/cadastros/subassunto.js')}}"></script>
@stop