<!DOCTYPE html>
<!--[if IE 9 ]-->
<html class="ie9">
<!--[endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ouvidoria, Prefeitura Municipal de Pedras de Fogo</title>

    {{--<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">--}}

    <link type="text/css" rel="stylesheet" href="{{ asset('/lib/fullcalendar/dist/fullcalendar.min.css') }}"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('/lib/animate.css/animate.min.css') }}"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('/lib/sweetalert2/dist/sweetalert2.min.css') }}"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('/lib/material-design-iconic-font/dist/css/material-design-iconic-font.min.css') }}"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('/lib/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css') }}"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('/lib/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{ asset('/lib/select2/dist/css/select2.min.css')}}" rel="stylesheet"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('/lib/select2-bootstrap-theme/dist/select2-bootstrap.min.css')}}" rel="stylesheet"/>
    <!-- Datepicker -->
    <link type="text/css" rel="stylesheet" href="{{ asset('lib/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}" rel="stylesheet"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('/dist/css/validate.css') }}"  media="screen,projection"/>

    {{--<link href="/lib/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">--}}
    {{--<link href="/lib/nouislider/distribute/nouislider.min.css" rel="stylesheet">--}}
    {{--<link href="/lib/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">--}}
    {{--<link href="/lib/dropzone/dist/min/dropzone.min.css" rel="stylesheet">--}}
    {{--<link href="/lib/farbtastic/farbtastic.css" rel="stylesheet">--}}
    <link href="{{ asset('/lib/chosen/chosen.css') }}" rel="stylesheet">
    <link href="{{ asset('/lib/summernote/dist/summernote.css') }}" rel="stylesheet">

    <link type="text/css" rel="stylesheet" href="{{ asset('/dist/css/app_1.min.css') }}"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('/dist/css/app_2.min.css') }}"  media="screen,projection"/>

    {{-- CSS personalizados--}}
    <link type="text/css" rel="stylesheet" href="{{ asset('/dist/css/demo.css') }}"  media="screen,projection"/>

    @yield('css')
</head>
<body>
<header id="header" class="clearfix" data-ma-theme="blue">
    <ul class="h-inner">
        <li class="hi-trigger ma-trigger" data-ma-action="sidebar-open" data-ma-target="#sidebar">
            <div class="line-wrap">
                <div class="line top"></div>
                <div class="line center"></div>
                <div class="line bottom"></div>
            </div>
        </li>

        <li class="hi-logo hidden-xs">
            <a href="index.html">SerEducacional</a>
        </li>

        <li class="pull-right">
            <ul class="hi-menu">


                <li class="hidden-xs ma-trigger" data-ma-action="sidebar-open" data-ma-target="#chat">
                    <a href=""><i class="him-icon zmdi zmdi-comment-alt-text"></i></a>
                </li>
            </ul>
        </li>
    </ul>

    <!-- Top Search Content -->
    <div class="h-search-wrap">
        <div class="hsw-inner">
            <i class="hsw-close zmdi zmdi-arrow-left" data-ma-action="search-close"></i>
            <input type="text">
        </div>
    </div>
</header>


<section id="main">
    {{--Menu Lateral--}}
    <aside id="sidebar" class="sidebar c-overflow">
        <div class="s-profile">
            <a href="" data-ma-action="profile-menu-toggle">
                <div class="sp-pic">
                    <img src="{{ asset ('/dist/img/demo/profile-pics/1.jpg') }}" alt="">
                    {{--{{dd(Auth::user())}}--}}
                    {{--{{Auth::user()->operador()->get()->first()->nome_operadores}}--}}
                </div>

                <div class="sp-info">
                    {{ Auth::user()->name }}
                    <i class="zmdi zmdi-caret-down"></i>
                </div>
            </a>

            <ul class="main-menu">
                {{--<li>
                    <a href="profile-about.html"><i class="zmdi zmdi-account"></i>Perfil</a>
                </li>
                <li>
                    <a href=""><i class="zmdi zmdi-input-antenna"></i> Privacy Settings</a>
                </li>
                <li>
                    <a href="{{ route('user.alterarSenha') }}"><i class="zmdi zmdi-settings"></i>Alterar Senha</a>
                </li>
                <li>
                    <a href="{{ route('logout') }}"><i class="zmdi zmdi-time-restore"></i>Sair</a>
                </li>--}}
                <li>
                    <a href="{{ url('auth/logout') }}"><i class="zmdi zmdi-power"></i>Sair</a>
                </li>
            </ul>
        </div>

        <ul class="main-menu">
            <li class="sub-menu">
                @role('ouvidoria')
                    <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-assignment-o"></i>Ouvidoria</a>
                    <ul>
                        <li>
                            <a href="{{ route('seracademico.ouvidoria.demanda.index')  }}">Demanda</a>
                        </li>
                        <li>
                            <a href="{{ route('seracademico.ouvidoria.melhoria.index')  }}">Melhoria</a>
                        </li>
                    </ul>
                    <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-storage"></i>Cadastros</a>
                    <ul>
                        <li>
                            <a href="{{ route('seracademico.ouvidoria.psf.index')  }}">PSF</a>
                        </li>
                        <li>
                            <a href="{{ route('seracademico.ouvidoria.comunidade.index')  }}">Comunidade</a>
                        </li>
                        <li>
                            <a href="{{ route('seracademico.ouvidoria.assunto.index')  }}">Assunto</a>
                        </li>
                        <li>
                            <a href="{{ route('seracademico.ouvidoria.subassunto.index')  }}">Subassunto</a>
                        </li>
                    </ul>
                    <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-assignment"></i>Relatório</a>
                    <ul>
                        <li>
                            <a href="{{ route('seracademico.ouvidoria.report.viewReportPessoas')  }}">Pessoas</a>
                        </li>
                        <li>
                            <a href="{{ route('seracademico.ouvidoria.report.viewReportStatus')  }}">Status</a>
                        </li>
                        <li>
                            <a href="{{ route('seracademico.ouvidoria.report.comunidadeView')  }}">Comunidade</a>
                        </li>
                    </ul>
                    <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-view-compact"></i>Tabelas</a>
                    <ul>
                        <li>
                            <a href="{{ route('seracademico.ouvidoria.tabelas.viewAssuntoClassificacao')  }}">Assunto class.</a>
                        </li>
                        <li>
                            <a href="{{ route('seracademico.ouvidoria.tabelas.assuntoView')  }}">Assuntos x Subass.</a>
                        </li>
                        <li>
                            <a href="{{ route('seracademico.ouvidoria.tabelas.viewSexo')  }}">Sexo</a>
                        </li>
                        <li>
                            <a href="{{ route('seracademico.ouvidoria.tabelas.viewEscolaridade')  }}">Escolaridade</a>
                        </li>
                        <li>
                            <a href="{{ route('seracademico.ouvidoria.tabelas.viewMelhorias')  }}">Melhoria</a>
                        </li>
                        <li>
                            <a href="{{ route('seracademico.ouvidoria.tabelas.viewComunidadeClassificacao')  }}">Comunidade class.</a>
                        </li>
                    </ul>
                    <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-chart"></i>Gráficos</a>
                    <ul>
                        <li>
                            <a href="{{ route('seracademico.ouvidoria.graficos.caracteristicasView')  }}">Características</a>
                        </li>
                        <li>
                            <a href="{{ route('seracademico.ouvidoria.graficos.assuntoView')  }}">Assuntos</a>
                        </li>
                        <li>
                            <a href="{{ route('seracademico.ouvidoria.graficos.subassuntoView')  }}">Subassuntos</a>
                        </li>
                        <li>
                            <a href="{{ route('seracademico.ouvidoria.graficos.meioRegistroView')  }}">Meios de registro</a>
                        </li>
                        <li>
                            <a href="{{ route('seracademico.ouvidoria.graficos.perfilView')  }}">Perfis</a>
                        </li>
                        <li>
                            <a href="{{ route('seracademico.ouvidoria.graficos.escolaridadeView')  }}">Escolaridade</a>
                        </li>
                        <li>
                            <a href="{{ route('seracademico.ouvidoria.graficos.atendimento')  }}">Meio Atendi.</a>
                        </li>
                        <li>
                            <a href="{{ route('seracademico.ouvidoria.graficos.informacao')  }}">Calss. Manifestação</a>
                        </li>
                        <li>
                            <a href="{{ route('seracademico.ouvidoria.graficos.status')  }}">Status demanda</a>
                        </li>
                        <li>
                            <a href="{{ route('seracademico.ouvidoria.graficos.melhorias')  }}">Melhorias</a>
                        </li>
                        <li>
                            <a href="{{ route('seracademico.ouvidoria.graficos.melhoria')  }}">Recla. x Melhoria</a>
                        </li>
                        <li>
                            <a href="{{ route('seracademico.ouvidoria.graficos.demandasView')  }}">Demandas</a>
                        </li>
                    </ul>
                @endrole
            </li>
        </ul>
    </aside>
    {{--FIM Menu Lateral--}}

    @yield('content')

</section>

<!-- Page Loader -->
<div class="page-loader">
    <div class="preloader pls-blue">
        <svg class="pl-circular" viewBox="25 25 50 50">
            <circle class="plc-path" cx="50" cy="50" r="20" />
        </svg>

        <p>Please wait...</p>
    </div>
</div>
<!-- -->

<!-- Imagem de carregamento em requisições ajax-->
<div class="modal">
    <div class="preloader pl-xxl">
        <svg class="pl-circular" viewBox="25 25 50 50">
            <circle class="plc-path" cx="50" cy="50" r="20"/>
        </svg>
    </div>
</div>
<!-- -->

<footer id="footer" class="p-t-0">
    <strong>Copyright &copy; 2015-2016 <a target="_blank" href="http://serbinario.com.br"><i></i>SERBINARIO</a> .</strong> Todos os direitos reservados.
</footer>

<!-- Javascript Libraries -->
<script src="{{ asset('/lib/jquery/dist/jquery.js') }}"></script>
<script src="{{ asset('/lib/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/lib/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script src="{{ asset('/lib/Waves/dist/waves.min.js') }}"></script>
{{--<script src="{{ asset('/dist/js/bootstrap-growl/bootstrap-growl.min.js') }}"></script>--}}
<script src="{{ asset('/lib/sweetalert2/dist/sweetalert2.min.js') }}"></script>
<script src="{{ asset('/lib/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/lib/select2/dist/js/select2.full.js') }}"></script>
<script src="{{ asset('/js/plugins/toastr.min.js')}}"></script>
<script src="{{ asset('/js/bootstrapvalidator.js')}}" type="text/javascript"></script>
<script src="{{ asset('/js/jquery.tree.js')}}" type="text/javascript"></script>
<script src="{{ asset('/js/jquery.mask.js')}}"></script>
<script src="{{ asset('/js/mascaras.js')}}"></script>

<!-- Datepicker e suas dependencias. Sempre importa-lo nessa ordem -->
<script src="{{ asset('/lib/flot/jquery.flot.js') }}"></script>
<script src="{{ asset('/lib/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('/lib/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

{{--jquery Validator https://jqueryvalidation.org/ --}}
<script src="{{ asset('/lib/jquery-validation/dist/jquery.validate.js') }}"></script>
<script src="{{ asset('/lib/jquery-validation/src/additional/cpfBR.js') }}"></script>
<script src="{{ asset('/dist/js/fileinput/fileinput.min.js')}}"></script>

{{-- Mascaras https://igorescobar.github.io/jQuery-Mask-Plugin/ --}}
<script src="{{ asset('/lib/jquery-mask-plugin/dist/jquery.mask.js') }}"></script>

<!-- Placeholder for IE9 -->
<script type="text/javascript" src={{ asset('/lib/jquery-placeholder/jquery.placeholder.min.js') }}></script>

{{--<script src="{{ asset('/js/laroute.js') }}"></script>--}}
<script src="{{ asset('/lib/chosen/chosen.jquery.js') }}"></script>
<script type="text/javascript" src={{ asset('/dist/js/app.js') }}></script>

<script type="text/javascript">
    $(".chosen").chosen();
    $('.datepicker').datetimepicker({
        timepicker: false,
        format: 'd/m/Y',
        mask: false,
        lang: 'pt-BR'
    });

    $.validator.setDefaults({
        ignore: []
    });
</script>

@yield('javascript')

</body>
</html>