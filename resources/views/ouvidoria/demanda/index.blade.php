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

                <!-- Botão novo -->
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="text-right">
                                <a class="btn btn-primary btn-sm m-t-10", href="{{ route('seracademico.ouvidoria.demanda.create')}}">Nova Demanda</a>
                            </div>
                        </div>
                    </div>
                    <!-- Botão novo -->

                    <div class="row">
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
                            <div class="col-sm-2">
                                <button type="submit" style="margin-top: 28px" id="search" class="btn-primary btn input-sm">Consultar</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div><br/>
                </div>
                <div class="table-responsive">
                    <table id="demanda-grid" class="table table-bordered compact" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Relato</th>
                            <th>Data</th>
                            <th>Nº da demanda</th>
                            <th>Nome</th>
                            <th>Comunidade</th>
                            <th>Caract. da demanda</th>
                            <th>Meio de registro</th>
                            <th>Assunto</th>
                            <th>Melhoria</th>
                            <th>Status</th>
                            <th>Acão</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Relato</th>
                            <th>Data</th>
                            <th>Nº da demanda</th>
                            <th>Nome</th>
                            <th>Comunidade</th>
                            <th>Caract da demanda</th>
                            <th>Meio de registro</th>
                            <th>Assunto</th>
                            <th>Melhoria</th>
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

            function format(d) {

                var html = "";

                html += '<center><h5>Relato</h5></center>';
                html += '<p style="text-align: justify">"'+d.relato+'"</p>';

                return html;
            }

            var table = $('#demanda-grid').DataTable({
                processing: true,
                serverSide: true,
                order: [[ 1, "asc" ]],
                ajax: {
                    url: "{!! route('seracademico.ouvidoria.demanda.grid') !!}",
                    method: 'POST',
                    data: function (d) {
                        d.data_inicio = $('input[name=data_inicio]').val();
                        d.data_fim = $('input[name=data_fim]').val();
                    }
                },
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
                    {data: 'comunidade', name: 'ouv_comunidade.nome'},
                    {data: 'informacao', name: 'ouv_informacao.nome'},
                    {data: 'tipo_demanda', name: 'ouv_tipo_demanda.nome'},
                    {data: 'assunto', name: 'ouv_assunto.nome'},
                    {data: 'melhoria', name: 'ouv_melhorias.nome'},
                    {data: 'status', name: 'ouv_status.nome'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            //Função do submit do search da grid principal
            $('#search').click(function(e) {
                table.draw();
                e.preventDefault();
            });

            // Add event listener for opening and closing details
            $('#demanda-grid tbody').on('click', 'td.details-control', function () {
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