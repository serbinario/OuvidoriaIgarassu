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

            {!! Form::open(['route'=>'seracademico.ouvidoria.encaminhamento.reencaminarStore', 'method' => "POST", 'id'=> 'formReencaminhamento' ]) !!}
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('secretaria', 'Secretaria') !!}
                                    {!! Form::select('secretaria', (["" => "Selecione"] + $loadFields['ouvidoria\secretaria']->toArray()), $model->destinatario->area->id, array('class' => 'form-control', 'readonly' => 'readonly')) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('destinatario_id', 'Destino') !!}
                                    {!! Form::select('destinatario_id', array($model->destinatario->id => $model->destinatario->nome), $model->destinatario->id, array('class' => 'form-control', 'id' => 'destinatario_id', 'readonly' => 'readonly')) !!}
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
                                <button type="button" onclick='javascript:history.back();' class="btn btn-primary btn-block"><i
                                            class="fa fa-long-arrow-left"></i> Voltar</button></div>
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
@stop