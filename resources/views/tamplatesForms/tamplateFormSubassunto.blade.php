<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('secretaria', 'Secretaria *') !!}
                    @if(isset($model->assunto->secretaria))
                        {!! Form::select('secretaria', (["" => "Selecione"] + $loadFields['ouvidoria\secretaria']->toArray()), $model->assunto->secretaria->id, array('class' => 'form-control', 'id' => 'secretaria')) !!}
                    @else
                        {!! Form::select('secretaria', (["" => "Selecione"] + $loadFields['ouvidoria\secretaria']->toArray()), Session::getOldInput('secretaria'), array('class' => 'form-control', 'id' => 'secretaria')) !!}
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('assunto_id', 'Assunto *') !!}
                    @if(isset($model->assunto->id))
                        {!! Form::select('assunto_id', array($model->assunto->id => $model->assunto->nome), $model->assunto->id,array('class' => 'form-control')) !!}
                    @else
                        {!! Form::select('assunto_id', array(), Session::getOldInput('assunto_id'),array('class' => 'form-control')) !!}
                    @endif
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
    <script type="text/javascript">

        //Carregando os bairros
        $(document).on('change', "#secretaria", function () {
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

    </script>
@stop