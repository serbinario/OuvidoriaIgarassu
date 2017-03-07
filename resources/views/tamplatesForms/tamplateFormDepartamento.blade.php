<div class="block-header">
    <h2>Cadastro de Departamento</h2>
</div>
<div class="card">
    <div class="card-body card-padding">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="form-group col-md-6">
                        <div class="fg-line">
                            <div class="fg-line">
                                <label for="nome">Nome *</label>
                                {!! Form::text('nome', Session::getOldInput('nome') , array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="fg-line">
                            <div class="fg-line">
                                <label for="area_id">Secretaria *</label>
                                {!! Form::select('area_id', $loadFields['ouvidoria\secretaria'], Session::getOldInput('area_id'), array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary btn-sm m-t-10">Salvar</button>
                <a class="btn btn-primary btn-sm m-t-10" href="{{ route('seracademico.ouvidoria.departamento.index') }}">Voltar</a>
            </div>
        </div>
    </div>
</div>
</div>

@section('javascript')
    {{--Mensagens personalizadas--}}
    <script type="text/javascript" src="{{ asset('/dist/js/messages_pt_BR.js')  }}"></script>

    {{--Regras de validação personalizadas--}}
    <script type="text/javascript" src="{{ asset('/dist/js/validacao/adicional/alphaSpace.js')  }}"></script>

    {{--Regras de validação--}}
    <script type="text/javascript" src="{{ asset('/dist/js/validacao/disciplina.js')  }}"></script>
@endsection