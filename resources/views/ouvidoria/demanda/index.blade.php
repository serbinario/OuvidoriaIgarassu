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
                <h4><i class="material-icons">find_in_page</i> Listar Demandas</h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.ouvidoria.demanda.create')}}" class="btn-sm btn-primary pull-right">Nova Demanda</a>
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
                    <div class="table-responsive no-padding">
                        <table id="sala-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Relato</th>
                                <th>Data</th>
                                <th>Nº da demanda</th>
                                <th>Nome</th>
                                <th>Endereço</th>
                                <th>Bairro</th>
                                <th>Telefone</th>
                                <th>Caracteristica da demanda</th>
                                <th>Meio de registro</th>
                                <th>Situação</th>
                                <th >Acão</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Relato</th>
                                <th>Data</th>
                                <th>Nº da demanda</th>
                                <th>Nome</th>
                                <th>Endereço</th>
                                <th>Bairro</th>
                                <th>Telefone</th>
                                <th>Caracteristica da demanda</th>
                                <th>Meio de registro</th>
                                <th>Situação</th>
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
            function format(d) {

                var html = "";

                html += '<center><h5>Relato</h5></center>';
                html += '<p style="text-align: justify">"'+d.relato+'"</p>';

                return html;
            }

            var table = $('#sala-grid').DataTable({
                processing: true,
                serverSide: true,
                order: [[ 1, "asc" ]],
                ajax: "{!! route('seracademico.ouvidoria.demanda.grid') !!}",
                columns: [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "data":           'ouv_demanda.nome',
                        "defaultContent": ''
                    },
                    {data: 'data', name: 'ouv_demanda.data'},
                    {data: 'codigo', name: 'ouv_demanda.codigo'},
                    {data: 'nome', name: 'ouv_demanda.nome'},
                    {data: 'endereco', name: 'ouv_demanda.endereco'},
                    {data: 'minicipio', name: 'ouv_demanda.minicipio'},
                    {data: 'fone', name: 'ouv_demanda.fone'},
                    {data: 'informacao', name: 'ouv_informacao.nome'},
                    {data: 'tipo_demanda', name: 'ouv_tipo_demanda.nome'},
                    {data: 'situacao', name: 'ouv_situacao.nome'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            // Add event listener for opening and closing details
            $('#sala-grid tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );

                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( format(row.data()) ).show();
                    tr.addClass('shown');
                }
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