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
                                <label for="nome">Nome *</label>
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