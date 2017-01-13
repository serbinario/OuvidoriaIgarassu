<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('assunto_id', 'Assunto *') !!}
                    {!! Form::select('assunto_id', $loadFields['ouvidoria\assunto'], Session::getOldInput('assunto_id'), array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('nome', 'Nome *') !!}
                    {!! Form::text('nome', Session::getOldInput('nome') , array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>

    </div>
    {{--Buttons Submit e Voltar--}}
    <div class="col-md-3">
        <div class="btn-group btn-group-justified">
            <div class="btn-group">
                <a href="{{ route('seracademico.ouvidoria.subassunto.index') }}" class="btn btn-primary btn-block"><i
                            class="fa fa-long-arrow-left"></i> Voltar</a></div>
            <div class="btn-group">
                {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
            </div>
        </div>
    </div>
</div>
@section('javascript')
    {{--<script src="{{ asset('/js/validacoes/validation_form_chamado.js') }}"></script>--}}
@stop