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
                <h4><i class="material-icons">find_in_page</i> Demandas concluídas</h4>
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
                    <div class="table-responsive">
                        <table id="concluidos-grid" class="display table compact table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Secretaria</th>
                                <th>Departamento</th>
                                <th>Prioridade</th>
                                <th>Data</th>
                                <th>Previsão</th>
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

            var table = $('#concluidos-grid').DataTable({
                processing: true,
                serverSide: true,
                bLengthChange: false,
                order: [[ 1, "asc" ]],
                ajax: {
                    url: "{!! route('seracademico.ouvidoria.encaminhamento.concluidosGrid') !!}",
                    method: 'POST'
                },
                columns: [
                    {data: 'codigo', name: 'codigo', orderable: false, searchable: false},
                    {data: 'area', name: 'ouv_area.nome'},
                    {data: 'destino', name: 'ouv_destinatario.nome'},
                    {data: 'prioridade', name: 'ouv_prioridade.nome'},
                    {data: 'data', name: 'ouv_encaminhamento.data'},
                    {data: 'previsao', name: 'ouv_encaminhamento.previsao'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
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