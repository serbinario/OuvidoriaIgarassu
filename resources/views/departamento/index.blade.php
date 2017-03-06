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
                <h4><i class="material-icons">find_in_page</i> Listar Departamentos</h4>
            </div>
            {{--<div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.ouvidoria.departamento.create')}}" class="btn-sm btn-primary pull-right">Novo Departamento</a>
            </div>--}}
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
                <div class="col-sm-12 col-md-12">
                    <a href="{{ route('seracademico.ouvidoria.departamento.create')}}" class="btn btn-primary">Novo Departamento</a>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="departamento-grid" class="display table compact table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Secretaria</th>
                                <th>Nome</th>
                                <th>Acão</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Secretaria</th>
                                <th>Nome</th>
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

            var table = $('#departamento-grid').DataTable({
                processing: true,
                serverSide: true,
                order: [[ 1, "asc" ]],
                ajax: {
                    url: "{!! route('seracademico.ouvidoria.departamento.grid') !!}",
                    method: 'POST'
                },
                columns: [
                    {data: 'area', name: 'ouv_area.nome'},
                    {data: 'nome', name: 'ouv_destinatario.nome'},
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