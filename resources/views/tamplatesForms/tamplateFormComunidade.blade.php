<div class="block-header">
    <h2>Cadastro de Comunidade</h2>
</div>
<div class="card">
    <div class="card-body card-padding">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="form-group col-md-6">
                        <div class="fg-line">
                            <div class="fg-line">
                                <label for="nome">Comunidade *</label>
                                {!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="fg-line">
                            <div class="fg-line">
                                <label for="ouv_psf_id">Psf *</label>
                                {!! Form::select('ouv_psf_id', ['' => 'Selecione uma PSF'] + $loadFields['ouv_psf']->toArray(), Session::getOldInput('ouv_psf_id'), array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary btn-sm m-t-10">Salvar</button>
                <a class="btn btn-primary btn-sm m-t-10" href="{{ route('seracademico.ouvidoria.comunidade.index') }}">Voltar</a>
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
    <script src="{{ asset('/js/validacoes/comunidade.js')}}"></script>
@endsection