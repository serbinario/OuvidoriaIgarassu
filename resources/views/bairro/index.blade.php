@extends('menu')

@section('content')
    <section id="content">
        <div class="container">
            <div class="block-header">
                <h2>Listar Bairro(s)</h2>
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
                                <a class="btn btn-primary btn-sm m-t-10", href="{{ route('seracademico.ouvidoria.bairro.create')}}">Novo Bairro</a>
                            </div>
                        </div>
                    </div>
                    <!-- Botão novo -->
                </div>

                <div class="table-responsive">
                    <table id="bairro-grid" class="display table compact table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Cidade</th>
                            <th>Acão</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Nome</th>
                            <th>Cidade</th>
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

            var tableBairro = $('#bairro-grid').DataTable({
                processing: true,
                serverSide: true,
                order: [[ 1, "asc" ]],
                ajax: {
                    url: "{!! route('seracademico.ouvidoria.bairro.grid') !!}",
                    method: 'POST'
                },
                columns: [
                    {data: 'nome', name: 'gen_bairros.nome'},
                    {data: 'cidade', name: 'gen_cidades.nome'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });


        $(document).on('click', 'a.excluir', function (event) {
            event.preventDefault();
            var url = $(this).attr('href');
            swal({
                title: "Alerta",
                text: "Tem certeza da exclusão do item?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Sim!",
            }).then(function(){
                location.href = url;
            });
        });
    </script>
@stop