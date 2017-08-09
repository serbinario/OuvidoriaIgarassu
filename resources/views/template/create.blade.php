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
            {!! Form::open(['route'=>'seracademico.template.store', 'method' => "POST", 'id'=> 'formTemplate', 'enctype' => 'multipart/form-data' ]) !!}
            <div class="block-header">
                <h2>Importação de template</h2>
            </div>
            <div class="card">
                <div class="card-body card-padding">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <div class="fg-line">
                                        <label for="nome">Template (Documento) *</label>
                                        {!! Form::text('nome', Session::getOldInput('nome') , array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="fg-line">
                                        <label for="documento_id">Documento *</label>
                                        {!! Form::select('documento_id', $loadFields['documento'], Session::getOldInput('documento_id'), array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class=" fg-line">
                                        <label for="file">Arquivo *</label>
                                        <input type="file" name="file" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm m-t-10">Salvar</button>
                            <a class="btn btn-primary btn-sm m-t-10" href="{{ route('seracademico.template.index') }}">Voltar</a>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
            {{--Fim formulario--}}
        </section>
    </div>
@stop
