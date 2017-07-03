@extends('menu')

@section('content')
    <section id="content">
        <div class="container">
            <div class="block-header">
                <h2>Listar Usuário(s)</h2>
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
                                <a class="btn btn-primary btn-sm m-t-10", href="{{ route('seracademico.user.create')}}">Novo Usuário</a>
                            </div>
                        </div>
                    </div>
                    <!-- Botão novo -->
                </div>

                <div class="table-responsive">
                    <table id="user-grid" class="table table-hover" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Secretaria</th>
                            <th>Status</th>
                            <th >Acão</th>
                        </tr>
                        </thead>

                        <tfoot>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Secretaria</th>
                            <th>Status</th>
                            <th style="width: 10%;">Acão</th>
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
        var tableUser = $('#user-grid').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('seracademico.user.grid') !!}",
            columns: [
                {data: 'name', name: 'users.name'},
                {data: 'email', name: 'users.email'},
                {data: 'secretaria', name: 'ouv_area.nome'},
                {data: 'ativo', name: 'ativo', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    </script>
@stop