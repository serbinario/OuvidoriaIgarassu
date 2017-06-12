<html>
<head>
    <link href="{{ asset('/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900,300" rel="stylesheet">
    <link href="{{ asset('/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{ asset('/css/bootstrapValidation.mim.css')}}" rel="stylesheet">
    <link href="{{ asset('/css/jquery.datetimepicker.css')}}" rel="stylesheet"/>
    <style type="text/css" class="init">
        *  {
            margin:0;
            padding:0;
        }

        html, body {height:100%;}

        .geral {
            min-height:100%;
            position:relative;
            width:100%;
        }

        .footer {
            position:absolute;
            bottom:0;
            width:100%;
        }

        .content {overflow:hidden;}
        .aside {width:200px;}
        .fleft {float:left;}
        .fright {float:right;}
    </style>
</head>
<body>

<div class="geral">

    <div class="header">
    </div>
    <div class="aside fleft">
    </div>
    <div class="aside fright">
    </div>

    <div class="content">
        <div class="row">
            <center>
                <div class="topo" style="background-color: #0b8345">
                    <center>
                        <img src="{{asset('/img/LOGO_OUVIDORIA_2.jpg')}}" style="width: 30%; height: 15%">
                        {{--<img src="{{asset('/img/igarassu.png')}}" style="width: 400px; height: 90px">--}}
                    </center>
                </div>
            </center>
        </div>

        <br />
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <a href="{{ route('createPublico')  }}" title="cadastro da manifestação">
                    <img src="{{asset('/img/TagInicial_04.png')}}" style="margin-left: 25px">
                </a>
                <a href="{{ route('buscarDemanda')  }}" title="consultar da manifestação">
                    <img src="{{asset('/img/TagInicial_05.png')}}" >
                </a>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>

    <div class="footer">
        <center>
            <img src="{{ asset('/img/s1.png')}}" style="width: 10%;"/><br />
            <strong>Copyright &copy; 2015-2016 <a target="_blank" href="http://serbinario.com.br"><i></i>SERBINARIO</a> .</strong> Todos os direitos reservados.
        </center>
    </div>

</div>

<script src="{{ asset('/js/jquery-2.1.1.js')}}"></script>
<script src="{{ asset('/js/jquery-ui.js')}}"></script>
<script src="{{ asset('/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('/js/jquery.mask.js')}}"></script>
<script src="{{ asset('/js/mascaras.js')}}"></script>
<script src="{{ asset('/js/bootstrapvalidator.js')}}" type="text/javascript"></script>
<script src="{{ asset('/js/jquery.datetimepicker.js')}}" type="text/javascript"></script>
<script src="{{ asset('/js/validacoes/validation_form_demanda.js')}}"></script>

</body>
</html>
