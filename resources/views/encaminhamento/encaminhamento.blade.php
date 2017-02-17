@extends('menu')

@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4><i class="material-icons">find_in_page</i> Reencaminhamento da demanda</h4>
            </div>
            <div class="col-sm-6 col-md-3">

            </div>
        </div>

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

            {!! Form::open(['route'=>'seracademico.ouvidoria.encaminhamento.encaminharStore', 'method' => "POST", 'id'=> 'formEncaminhamento' ]) !!}
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('secretaria', 'Secretaria') !!}
                                    {!! Form::select('secretaria', (["" => "Selecione"] + $loadFields['ouvidoria\secretaria']->toArray()), null, array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('destinatario_id', 'Destino') !!}
                                    {!! Form::select('destinatario_id', array(), null, array('class' => 'form-control', 'id' => 'destinatario_id')) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('prioridade_id', 'Prioridade') !!}
                                    {!! Form::select('prioridade_id',  (["" => "Selecione"] + $loadFields['ouvidoria\prioridade']->toArray()), Session::getOldInput('encaminhamento[prioridade_id]'), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    {!! Form::label('encaminhado', 'Documento encaminhado') !!}
                                    {!! Form::text('encaminhado', Session::getOldInput('encaminhamento[encaminhado]')  , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('copia', 'Cópia Para') !!}
                                    {!! Form::text('copia', Session::getOldInput('encaminhamento[copia]')  , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    {!! Form::label('parecer', 'Comentário/Parecer') !!}
                                    {!! Form::textarea('parecer', Session::getOldInput('encaminhamento[parecer]')  ,['size' => '127x5'] , array('class' => 'form-control')) !!}
                                    <input type="hidden" name="demanda_id" value="{{$model->demanda_id}}">
                                    <input type="hidden" name="id" value="{{$model->id}}">
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
            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('javascript')
    <script src="{{ asset('/js/validacoes/validation_form_assunto.js')}}"></script>
    <script type="text/javascript">
        //Carregando os bairros
        $(document).on('change', "#secretaria", function () {
            //Removendo as assuntos
            $('#destinatario_id option').remove();

            //Recuperando a secretaria
            var secretaria = $(this).val();

            if (secretaria !== "") {
                var dados = {
                    'table' : 'ouv_destinatario',
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

                    option += '<option value="">Selecione</option>';
                    for (var i = 0; i < json.length; i++) {
                        option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
                    }

                    $('#destinatario_id option').remove();
                    $('#destinatario_id').append(option);
                });
            }
        });
    </script>
@stop