@extends('menu')

@section('css')
    <style type="text/css" class="init">
        td.details-control {
            background: url({{asset("/imagemgrid/icone-produto-plus.png")}}) no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url({{asset("/imagemgrid/icone-produto-minus.png")}}) no-repeat center center;
        }


        a.visualizar {
            background: url({{asset("/imagemgrid/impressao.png")}}) no-repeat 0 0;
            width: 23px;
        }

        td.bt {
            padding: 10px 0;
            width: 126px;
        }

        td.bt a {
            float: left;
            height: 22px;
            margin: 0 10px;
        }
        .highlight {
            background-color: #FE8E8E;
        }
    </style>
@endsection

@section('content')
    <section id="content">
        <div class="container">
            <div class="block-header">
                <h2>Listar Demanda(s)</h2>
            </div>

            <div class="card material-table">
                <div class="card-header">

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

                 @role('ouvidoria|admin')
                    <!-- Botão novo -->
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="text-right">
                                <a class="btn btn-primary btn-sm m-t-10", href="{{ route('seracademico.ouvidoria.demanda.create')}}">Nova Demanda</a>
                            </div>
                        </div>
                    </div><br />
                    <!-- Botão novo -->
                 @endrole

                    <div class="row" >
                        {!! Form::open(['method' => "POST"]) !!}
                        <div class="col-md-12">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <?php $data = new \DateTime('now') ?>
                                    {!! Form::label('data_inicio', 'Início') !!}
                                    {!! Form::text('data_inicio', null , array('class' => 'form-control date')) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('data_fim', 'Fim') !!}
                                    {!! Form::text('data_fim', null , array('class' => 'form-control date')) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <div class="fg-line">
                                    <div class="fg-line">
                                        <label for="status">Status *</label>
                                        <select name="status" class="form-control" id="status">
                                            <option value="0">Todos</option>
                                            <option @if($status == '7') selected @endif value="7">Novas</option>
                                            <option @if($status == '1') selected @endif value="1">Encaminhados\Reencaminhados</option>
                                            <option @if($status == '2') selected @endif value="2">Em análise</option>
                                            <option @if($status == '3') selected @endif value="3">Conluídos</option>
                                            <option @if($status == '4') selected @endif value="4">Finalizados</option>
                                            <option @if($status == '5') selected @endif value="5">A Atrasar em 15 dias</option>
                                            <option @if($status == '6') selected @endif value="6">Atrasados</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @role('ouvidoria|admin')
                            <div class="form-group col-md-3">
                                <div class="fg-line">
                                    <div class="fg-line">
                                        <label for="status">Responsável</label>
                                        <select name="responsavel" class="form-control" id="responsavel">
                                            <option value="0">Todos</option>
                                            @foreach($usuarios as $usuario)
                                                <option value="{{$usuario->id}}">{{$usuario->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @endrole
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('globalSearch', 'Pesquisar') !!}
                                    {!! Form::text('globalSearch', null , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" style="margin-top: 28px" id="search" class="btn-primary btn input-sm">Consultar</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="demanda-grid" class="table table-bordered compact" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Detalhe</th>
                            <th>Data</th>
                            <th>Previsão</th>
                            <th>Nº da demanda</th>
                            <th>Responsável</th>
                            <th>Prioridade</th>
                            <th>Caract. da demanda</th>
                            <th>Meio de registro</th>
                            <th>Status</th>
                            <th>Acão</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Detalhe</th>
                            <th>Data</th>
                            <th>Previsão</th>
                            <th>Nº da demanda</th>
                            <th>Responsável</th>
                            <th>Prioridade</th>
                            <th>Caract. da demanda</th>
                            <th>Meio de registro</th>
                            <th>Status</th>
                            <th style="width: 16%;">Acão</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section>
@stop

@section('javascript')
    <script type="text/javascript">
        //Pega o status por acesso a página via get
        statusGet = '{{$status}}';
    </script>
@stop