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
            {!! Form::open(['route'=>'seracademico.ouvidoria.encaminhamento.encaminharStore', 'method' => "POST", 'id'=> 'formEncaminhamento' ]) !!}
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
                                        <label for="secretaria">Secretaria *</label>
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
                                            <input type="hidden" name="demanda_id" value="@if(isset($model)) {{$model->demanda_id}} @else {{$id}} @endif">
                                            <input type="hidden" name="id" value="@if(isset($model)){{$model->id}}@endif">
                                            @if(isset($id))
                                                <input type="hidden" name="primeiro_encaminhamento" value="1">
                                            @endif
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
    <script src="{{ asset('/js/validacoes/encaminhamento.js')}}"></script>

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