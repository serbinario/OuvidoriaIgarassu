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
                <h2>Manifestações arquivadas</h2>
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

                </div>
                <div class="table-responsive">
                    <table id="manifestacao-arquivada-grid" class="table table-bordered compact" cellspacing="0" width="100%">
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
    <script src="{{ asset('/js/demanda/manifestacoes_arquivadas.js')}}"></script>
@stop