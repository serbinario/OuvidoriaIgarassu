@extends('menu')

@section('content')

    <section id="content">
        <div class="container">

            <div class="mini-charts">
                <div class="row">
                    <div class="col-sm-6 col-md-3">
                        <a href="{{route('seracademico.ouvidoria.demanda.index', ['status' => '1' ])}}">
                            <div class="mini-charts-item bgm-cyan ">
                                <div class="clearfix">
                                    <div class=""></div>
                                    <div class="count">
                                        <small>Manifestações a serem analisadas</small>
                                        <h2>{{$novas->novas}}</h2>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <a href="{{route('seracademico.ouvidoria.demanda.index', ['status' => '2' ])}}">
                            <div class="mini-charts-item bgm-orange">
                                <div class="clearfix">
                                    <div class=""></div>
                                    <div class="count">
                                        <small>Manifestações aguardando resposta</small>
                                        <h2>{{$analises->analises}}</h2>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <a href="{{route('seracademico.ouvidoria.demanda.index', ['status' => '3' ])}}">
                            <div class="mini-charts-item bgm-lightgreen">
                                <div class="clearfix">
                                    <div class=""></div>
                                    <div class="count">
                                        <small>Manifestações respondidas</small>
                                        <h2>{{$concluidas->concluidas}}</h2>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <a href="{{route('seracademico.ouvidoria.demanda.index', ['status' => '6' ])}}">
                            <div class="mini-charts-item bgm-red">
                                <div class="clearfix">
                                    <div class=""></div>
                                    <div class="count">
                                        <small>Manifestações atrasadas</small>
                                        <h2>{{$atrasadas->atrasadas}}</h2>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body card-padding">
                            <div class="row">
                                <div class="col-6-md">
                                    <div id="container-1" style=" margin: 0 auto"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body card-padding">
                            <div class="row">
                                <div class="col-6-md">
                                    <div id="container-2" style=" margin: 0 auto"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@stop

@section('javascript')
    <script src="{{ asset('/js/dashboard/index.js')  }}"></script>
@stop