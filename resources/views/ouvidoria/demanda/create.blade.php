@extends('menu')

@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4><i class="material-icons">find_in_page</i> Cadastrar Demanda</h4>
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
            {!! Form::open(['route'=>'seracademico.ouvidoria.demanda.store', 'method' => "POST", 'id'=> 'formDemanda' ]) !!}
                @include('tamplatesForms.tamplateFormDemanda')
            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('javascript')
    <script src="{{ asset('/js/validacoes/validation_form_demanda.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#anonimo').on('change', function(){
                var value = $('#anonimo').val();
                if(value == '2') {
                    $('#nome').prop('readonly', true);
                } else {
                    $('#nome').prop('readonly', false);
                }
            });
        });

        //Carregando os bairros
        $(document).on('change', "#assunto_id", function () {
            //Removendo as Bairros
            $('#subassunto_id option').remove();

            //Recuperando a cidade
            var assunto = $(this).val();

            if (assunto !== "") {
                var dados = {
                    'table' : 'ouv_subassunto',
                    'field_search' : 'assunto_id',
                    'value_search': assunto,
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

                    option += '<option value="">Selecione um subassunto</option>';
                    for (var i = 0; i < json.length; i++) {
                        option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
                    }

                    $('#subassunto_id option').remove();
                    $('#subassunto_id').append(option);
                });
            }
        });


        //Carregando os bairros
        $(document).on('change', "#encaminhamento", function () {

            //Recuperando a cidade
            var encaminhamento = $(this).val();

            if (encaminhamento !== "") {

                jQuery.ajax({
                    type: 'POST',
                    url: '{{ route('seracademico.ouvidoria.demanda.situacaoAjax')  }}',
                    headers: {
                        'X-CSRF-TOKEN': '{{  csrf_token() }}'
                    },
                    datatype: 'json'
                }).done(function (json) {

                    //alert('sdsd');

                    ///console.log(encaminhamento);
                    var option = "";

                    option += '<option value="">Selecione</option>';
                    for (var i = 0; i < json['situacao'].length; i++) {
                        if(encaminhamento == '1' && json['situacao'][i]['id'] == 2) {
                            option += '<option selected value="' + json['situacao'][i]['id'] + '">' + json['situacao'][i]['nome'] + '</option>';
                        } else if (encaminhamento == '2' && json['situacao'][i]['id'] == 3) {
                            option += '<option selected value="' + json['situacao'][i]['id'] + '">' + json['situacao'][i]['nome'] + '</option>';
                        } else if (encaminhamento == '3' && json['situacao'][i]['id'] == 6) {
                            option += '<option selected value="' + json['situacao'][i]['id'] + '">' + json['situacao'][i]['nome'] + '</option>';
                        } else if (encaminhamento == '4' && json['situacao'][i]['id'] == 4) {
                            option += '<option selected value="' + json['situacao'][i]['id'] + '">' + json['situacao'][i]['nome'] + '</option>';
                        } else if (encaminhamento == '5' && json['situacao'][i]['id'] == 1) {
                            option += '<option selected value="' + json['situacao'][i]['id'] + '">' + json['situacao'][i]['nome'] + '</option>';
                        } else if (encaminhamento == '6' && json['situacao'][i]['id'] == 7) {
                            option += '<option selected value="' + json['situacao'][i]['id'] + '">' + json['situacao'][i]['nome'] + '</option>';
                        } else if (encaminhamento == '7' && json['situacao'][i]['id'] == 5) {
                            option += '<option selected value="' + json['situacao'][i]['id'] + '">' + json['situacao'][i]['nome'] + '</option>';
                        } else {
                            option += '<option value="' + json['situacao'][i]['id'] + '">' + json['situacao'][i]['nome'] + '</option>';
                        }

                    }

                    $('#situacao option').remove();
                    $('#situacao').append(option);
                });
            }
        });
    </script>
@stop