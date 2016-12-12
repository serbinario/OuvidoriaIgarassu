@extends('menu')

@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4><i class="material-icons">find_in_page</i> Relatório por comunidade</h4>
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
            {!! Form::open(['route'=>'seracademico.ouvidoria.report.comunidade', 'method' => "POST", 'target' => '_blank' ]) !!}
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('comunidade', 'Comunidade') !!}
                                    {!! Form::select('comunidade', $loadFields['ouvidoria\comunidade'], null, array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="btn-group btn-group-justified">
                            <div class="btn-group">
                                {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
                            </div>
                        </div>
                    </div>
                    {{--Fim Buttons Submit e Voltar--}}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('javascript')
    <script src="{{ asset('/js/validacoes/validation_form_demanda.js')}}"></script>
@stop