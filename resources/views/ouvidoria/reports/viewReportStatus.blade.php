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
            {!! Form::open(['route'=>'seracademico.ouvidoria.report.reportStatus', 'method' => "POST", 'target' => '_blank' ]) !!}

            <div class="block-header">
                <h2>Relatório de status</h2>
            </div>
            <div class="card">
                <div class="card-body card-padding">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">

                                <div class="form-group col-md-4">
                                    <div class="fg-line">
                                        <div class="fg-line">
                                            <label for="secretaria">Secretaria</label>
                                            {!! Form::select('secretaria',(["" => "Selecione uma secretaria"] + $loadFields['ouvidoria\secretaria']->toArray()), Session::getOldInput('secretaria'), array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <div class="fg-line">
                                        <div class="fg-line">
                                            <label for="status">Status</label>
                                            {!! Form::select('status', $loadFields['ouvidoria\situacao'], null, array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <div class="fg-line">
                                        <div class="fg-line">
                                            <label for="data_inicio">Início</label>
                                            {!! Form::text('data_inicio', null , array('class' => 'form-control date ')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <div class="fg-line">
                                        <div class="fg-line">
                                            <label for="data_fim">Fim</label>
                                            {!! Form::text('data_fim', null , array('class' => 'form-control date ')) !!}
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <button class="btn btn-primary btn-sm m-t-10">Consultar</button>
                        </div>
                    </div>
                </div>
            </div>

            {!! Form::close() !!}
            {{--Fim formulario--}}
        </section>
    </div>
@stop