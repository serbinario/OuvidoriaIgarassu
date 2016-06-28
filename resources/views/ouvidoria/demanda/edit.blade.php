@extends('menu')

@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4><i class="material-icons">find_in_page</i> Editar Acervo</h4>
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

            {!! Form::model($model, ['route'=> ['seracademico.ouvidoria.demanda.update', $model->id], 'method' => "POST", 'id'=> 'formDemanda' ]) !!}
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
    </script>
@stop