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

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4><i class="material-icons">find_in_page</i> Demandas encaminhadas</h4>
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

            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control" id="status">
                                <option value="0">Todos</option>
                                <option value="1">Encaminhados\Reencaminhados</option>
                                <option value="2">Em análise</option>
                                <option value="3">Conluídos</option>
                                <option value="4">Finalizados</option>
                                <option value="5">Atrasados</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2" style="margin-top: 22px">
                        <div class="btn-group btn-group-justified">
                            <div class="btn-group">
                                <button type="button" id="search" class="btn btn-primary btn-block btn-sm">Consultar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="encaminhamento-grid" class="display table compact table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Secretaria</th>
                                <th>Departamento</th>
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
        </div>
    </div>
@stop

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function(){

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
                    }
                },
                columns: [
                    {data: 'codigo', name: 'codigo', orderable: false, searchable: false},
                    {data: 'area', name: 'ouv_area.nome'},
                    {data: 'destino', name: 'ouv_destinatario.nome'},
                    {data: 'prioridade', name: 'ouv_prioridade.nome'},
                    {data: 'data', name: 'ouv_encaminhamento.data'},
                    {data: 'previsao', name: 'ouv_encaminhamento.previsao'},
                    {data: 'status', name: 'ouv_status.nome'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            // Função do submit do search da grid principal
            $('#search').click(function(e) {
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