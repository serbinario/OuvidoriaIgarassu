<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SerOuvidor - Sistema Eletrônico Para Gestão de Ouvidorias</title>

    <link href="{{ asset('/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('/font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <link href="{{ asset('/css/animate.css')}}" rel="stylesheet">
    <link href="{{ asset('/css/style.css')}}" rel="stylesheet">
    <style type="text/css" class="init">

        html, body {height:100%;}

        .footer {
            position:absolute;
            bottom:0;
            width:100%;
        }

    </style>
   {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">--}}
</head>
<body class="gray-bg">

<div class="row">
    <div class="col-sm-12 col-md-12" style="background-color: #0b8345">
        <center>
            <img src="{{asset('/img/ouvidoria_saude.png')}}" class="img-responsive" style="width: 190px; height: 150px">
            {{--<img src="{{asset('/img/igarassu.png')}}" style="width: 400px; height: 90px">--}}
        </center>
    </div>
</div>

<div class="loginColumns animated fadeInDown">
    <div class="row">
        <div class="col-sm-1 col-md-5 col-md-offset-1">
            <div class="ibox-content">
                <p>
                    <a href="{{ route('buscarDemanda')  }}" class="img-responsive" title="cadastro da manifestação">
                        <img src="{{ asset('/img/TagInicial_05.png')}}" style="width: 100%;"/>
                    </a>
                </p>
            </div>
        </div>
        <div class="col-sm-1 col-md-5">
            <div class="ibox-content">
                <p>
                    <a href="{{ route('createPublico')  }}" class="img-responsive" title="consultar da manifestação">
                        <img src="{{ asset('/img/TagInicial_04.png')}}" style="width: 100%;"/>
                    </a>
                </p>
            </div>
        </div>
    </div>
    <br />  <br /> <br />
    <div class="footer">
        <center>
            <img src="{{ asset('/img/s1.png')}}" style="width: 10%;"/><br />
            <strong>Copyright &copy; 2015-2016 <a target="_blank" href="http://serbinario.com.br"><i></i>SERBINARIO</a> .</strong> Todos os direitos reservados.
        </center>
    </div>
    <hr/>

    <script src="{{ asset('/js/jquery-2.1.1.js')}}"></script>
    <script src="{{ asset('/js/bootstrap.min.js')}}"></script>
</body>
</html>
