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
                <h2>Demandas encaminhadas</h2>
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

                    <div class="row">
                        {!! Form::open(['method' => "POST"]) !!}
                        <div class="col-md-12">

                            <div class="form-group col-md-3">
                                <div class="fg-line">
                                    <div class="fg-line">
                                        <label for="status">Status *</label>
                                        <select name="status" class="form-control" id="status">
                                            <option value="0">Todos</option>
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

                            <div class="col-sm-2">
                                <button type="submit" style="margin-top: 28px" id="search" class="btn-primary btn input-sm">Consultar</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div><br/>
                </div>
                <div class="table-responsive">
                    <table id="encaminhamento-grid" class="table table-bordered table-condensed" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Código</th>
                            <th>Secretaria</th>
                            <th>Departamento</th>
                            <th>Responsável</th>
                            <th>Prioridade</th>
                            <th>Data</th>
                            <th>Previsão</th>
                            <th>Status</th>
                            <th>Acão</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Código</th>
                            <th>Secretaria</th>
                            <th>Departamento</th>
                            <th>Responsável</th>
                            <th>Prioridade</th>
                            <th>Data</th>
                            <th>Previsão</th>
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
        $(document).ready(function(){

            //Pega o status por acesso a página via get
            var statusGet = '{{$status}}';

            var table = $('#encaminhamento-grid').DataTable({
                processing: true,
                serverSide: true,
                bLengthChange: false,
                order: [[ 1, "asc" ]],
                ajax: {
                    url: "{!! route('seracademico.ouvidoria.encaminhamento.encaminhadosGrid') !!}",
                    method: 'POST',
                    data: function (d) {
                        d.status = $('select[name=status] option:selected').val();
                        d.responsavel = $('select[name=responsavel] option:selected').val();
                        d.statusGet = statusGet;
                    }
                },
                columns: [
                    {data: 'codigo', name: 'codigo', orderable: false, searchable: false},
                    {data: 'area', name: 'ouv_area.nome'},
                    {data: 'destino', name: 'ouv_destinatario.nome'},
                    {data: 'responsavel', name: 'users.name'},
                    {data: 'prioridade', name: 'ouv_prioridade.nome'},
                    {data: 'data', name: 'ouv_encaminhamento.data'},
                    {data: 'previsao', name: 'ouv_encaminhamento.previsao'},
                    {data: 'status', name: 'ouv_status.nome'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            // Função do submit do search da grid principal
            $('#search').click(function(e) {
                statusGet = "0";
                table.draw();
                e.preventDefault();
            });

        });

        $(document).on('click', 'a.excluir', function (event) {
            event.preventDefault();
            var url = $(this).attr('href');
            bootbox.confirm("Tem certeza da exclusão do item?", function (result) {
                if (result) {
                    location.href = url
                } else {
                    false;
                }
            });
        });
    </script>
@stop