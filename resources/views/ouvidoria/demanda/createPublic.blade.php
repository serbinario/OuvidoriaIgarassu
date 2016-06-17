<html>
<head>
    <link href="{{ asset('/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900,300" rel="stylesheet">
    <link href="{{ asset('/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
</head>
<body>
<div class="conteiner">
    <br />
    <div class="row">
        <center>
            <div class="topo" style="">
                <center><img src="{{asset('/img/ouvidoria_saude.png')}}" style="width: 120px; height: 100px"></center>
            </div>
        </center>
    </div>
    <br />
    <center><h2>REGISTRO DE DEMANDA OUVIDORIA SÁUDE IGARASSU</h2></center>
    <hr style="width: 100%">
    <br />
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
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
            {!! Form::open(['route'=>'storePublico', 'method' => "POST" ]) !!}
            @include('tamplatesForms.tamplateFormDemandaPublic')
            {!! Form::close() !!}
        </div>
        <div class="col-md-2"></div>
    </div>
</div>

<script src="{{ asset('/js/jquery-2.1.1.js')}}"></script>
<script src="{{ asset('/js/jquery-ui.js')}}"></script>
<script src="{{ asset('/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('/js/jquery.mask.js')}}"></script>
<script src="{{ asset('/js/mascaras.js')}}"></script>
</body>
</html>
