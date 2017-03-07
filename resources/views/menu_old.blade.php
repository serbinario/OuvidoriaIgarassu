<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ouvidoria - Prefeitura de Igarassu</title>

    <link href="{{ asset('/css/bootstrap.min.css')}}" rel="stylesheet">
    {{--<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">--}}

    <link href="{{ asset('/fonts/iconfont/material-icons.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900,300" rel="stylesheet">
    <link href="{{ asset('/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{ asset('/css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">
    <link href="{{ asset('/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{ asset('/css/animate.css')}}" rel="stylesheet">
    <link href="{{ asset('/css/style.css')}}" rel="stylesheet">

    <link href="{{ asset('/css/jquery-ui.css')}}" rel="stylesheet">
    {{--<link href="https://code.jquery.com/ui/1.11.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet" type="text/css">--}}

    <link href="{{ asset('/css/jquery.tree.css')  }}" rel="stylesheet">
    <link href="{{ asset('/css/jasny-bootstrap.css')  }}" rel="stylesheet">
    <link href="{{ asset('/css/awesome-bootstrap-checkbox.css')  }}" rel="stylesheet">
    <link href="{{ asset('/css/bootstrapValidation.mim.css')}}" rel="stylesheet">
    <link href="{{ asset('/css/jquery.datetimepicker.css')}}" rel="stylesheet"/>

    <link href="{{ asset('/css/jquery.dataTables.min.css')}}" rel="stylesheet"/>
    {{--<link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">--}}

    <link href="{{ asset('/css/buttons.dataTables.min.css')}}" rel="stylesheet"/>
    {{--<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">--}}

    <link rel="stylesheet" href="{{ asset('/css/plugins/sweetalert/sweetalert.css')  }}">
    <link rel="stylesheet" href="{{ asset('/css/plugins/botao/botao-fab.css')  }}">
    <link rel="stylesheet" href="{{ asset('/css/bootstrap-multiselect.css')  }}">

    <!-- zTree-->
    <link rel="stylesheet" href="{{ asset('/css/plugins/zTree/zTreeStyle.css')  }}">
    {{--<link rel="stylesheet" href="{{ asset('/css/plugins/zTree/demo.css')  }}">--}}

    @yield('css')
</head>

<body class="pace-done skin-1">

<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <img alt="image" class="logoDash" src="{{ asset('/img/ouvidoria_saude.png')}}"/>
                </li>
                @role('ouvidoria|admin')
                    <li>
                        <a href="index.html"><i class="fa fa-building-o"></i> <span class="nav-label"> Ouvidoria</span> <span
                                    class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="{{ route('seracademico.ouvidoria.demanda.index') }}"><i class="material-icons">perm_identity</i> Demanda</a></li>
                        </ul>
                    </li>
                @endrole
                <li>
                    <a href="index.html"><i class="fa fa-building-o"></i> <span class="nav-label"> Encaminhamentos</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        @role('ouvidoria|secretaria|admin')
                            <li><a href="{{ route('seracademico.ouvidoria.encaminhamento.encaminhados') }}"><i class="material-icons">perm_identity</i> Relação</a></li>
                        @endrole
                    </ul>
                </li>
                @role('ouvidoria|admin')
                    <li>
                        <a href="index.html"><i class="fa fa-building-o"></i> <span class="nav-label"> Cadastros</span> <span
                                    class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="{{ route('seracademico.ouvidoria.psf.index') }}"><i class="material-icons">perm_identity</i> PSF</a></li>
                            <li><a href="{{ route('seracademico.ouvidoria.comunidade.index') }}"><i class="material-icons">perm_identity</i> Comunidade</a></li>
                            <li><a href="{{ route('seracademico.ouvidoria.secretaria.index') }}"><i class="material-icons">perm_identity</i> Secretarias</a></li>
                            <li><a href="{{ route('seracademico.ouvidoria.departamento.index') }}"><i class="material-icons">perm_identity</i> Departamentos</a></li>
                            <li><a href="{{ route('seracademico.ouvidoria.assunto.index') }}"><i class="material-icons">perm_identity</i> Assunto</a></li>
                            <li><a href="{{ route('seracademico.ouvidoria.subassunto.index') }}"><i class="material-icons">perm_identity</i> Subassunto</a></li>
                        </ul>
                    </li>
                @endrole
                @role('ouvidoria|admin')
                    <li>
                        <a href="index.html"><i class="fa fa-file-text-o"></i> <span class="nav-label"> Relatório</span> <span
                                    class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="{{ route('seracademico.ouvidoria.report.viewReportPessoas') }}"><i class="material-icons">perm_identity</i> Pessoas</a></li>
                            <li><a href="{{ route('seracademico.ouvidoria.report.viewReportStatus') }}"><i class="material-icons">perm_identity</i> Status</a></li>
                            <li><a href="{{ route('seracademico.ouvidoria.report.comunidadeView') }}"><i class="material-icons">perm_identity</i> Comunidade</a></li>
                        </ul>
                    </li>
                @endrole
                @role('ouvidoria|admin')
                    <li>
                        <a href="index.html"><i class="fa fa-list-alt"></i> <span class="nav-label"> Tabelas</span> <span
                                    class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="{{ route('seracademico.ouvidoria.tabelas.viewAssuntoClassificacao') }}"><i class="material-icons">perm_identity</i> Assunto class.</a></li>
                            <li><a href="{{ route('seracademico.ouvidoria.tabelas.assuntoView') }}"><i class="material-icons">perm_identity</i> Assuntos x Subass.</a></li>
                            <li><a href="{{ route('seracademico.ouvidoria.tabelas.viewSexo') }}"><i class="material-icons">perm_identity</i> Sexo</a></li>
                            <li><a href="{{ route('seracademico.ouvidoria.tabelas.viewEscolaridade') }}"><i class="material-icons">perm_identity</i> Escolaridade</a></li>
                            <li><a href="{{ route('seracademico.ouvidoria.tabelas.viewMelhorias') }}"><i class="material-icons">perm_identity</i> Melhoria</a></li>
                            <li><a href="{{ route('seracademico.ouvidoria.tabelas.viewComunidadeClassificacao') }}"><i class="material-icons">perm_identity</i> Comunidade class.</a></li>
                        </ul>
                    </li>
                @endrole
                @role('ouvidoria|admin')
                    <li>
                        <a href="index.html"><i class="fa fa-bar-chart-o"></i> <span class="nav-label"> Gráficos</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="{{ route('seracademico.ouvidoria.graficos.caracteristicasView') }}"><i class="material-icons">perm_identity</i> Características</a></li>
                            <li><a href="{{ route('seracademico.ouvidoria.graficos.assuntoView') }}" ><i class="material-icons">perm_identity</i> Assuntos</a></li>
                            <li><a href="{{ route('seracademico.ouvidoria.graficos.subassuntoView') }}" ><i class="material-icons">perm_identity</i> Subassuntos</a></li>
                            <li><a href="{{ route('seracademico.ouvidoria.graficos.meioRegistroView') }}" ><i class="material-icons">perm_identity</i> Meios de registro</a></li>
                            <li><a href="{{ route('seracademico.ouvidoria.graficos.perfilView') }}" ><i class="material-icons">perm_identity</i> Perfis</a></li>
                            <li><a href="{{ route('seracademico.ouvidoria.graficos.escolaridadeView') }}" ><i class="material-icons">perm_identity</i> Escolaridade</a></li>
                            <li><a href="{{ route('seracademico.ouvidoria.graficos.atendimento') }}" ><i class="material-icons">perm_identity</i> Meio Atendi.</a></li>
                            <li><a href="{{ route('seracademico.ouvidoria.graficos.informacao') }}" ><i class="material-icons">perm_identity</i> Calss. Manifestação</a></li>
                            <li><a href="{{ route('seracademico.ouvidoria.graficos.status') }}" ><i class="material-icons">perm_identity</i> Status demanda</a></li>
                            <li><a href="{{ route('seracademico.ouvidoria.graficos.melhorias') }}" ><i class="material-icons">perm_identity</i> Melhorias</a></li>
                            <li><a href="{{ route('seracademico.ouvidoria.graficos.melhoria') }}" ><i class="material-icons">perm_identity</i> Recla. x Melhoria</a></li>
                            <li><a href="{{ route('seracademico.ouvidoria.graficos.demandasView') }}" ><i class="material-icons">perm_identity</i> Demandas</a></li>
                        </ul>
                    </li>
                @endrole
               @role('admin')
                <li><a href="index.html"><i class="material-icons">lock</i> <span class="nav-label">Segurança</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="{{ route('seracademico.user.index') }}"><i class="material-icons">account_circle</i> Usuários</a></li>
                        <li><a href="{{ route('seracademico.role.index') }}"><i class="material-icons">account_box</i> Perfís</a></li>
                    </ul>
                </li>
               @endrole
            </ul>
        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i>
                    </a>
                </div>
                <div class="profile-img">
                    <span>
                        @if(isset(Session::get("user")['img']))
                            <img alt="image" class="img-circle" src="{{asset('/uploads/fotos/'.Session::get("user")['img'])}}" alt="Foto"  height="50" width="50">
                        @endif
                    </span>
                </div>

                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <div class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="text-muted text-xs block">Idioma<b class="caret"></b></span></a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                    <li>
                                        <a rel="alternate" hreflang="{{$localeCode}}" href="{{LaravelLocalization::getLocalizedURL($localeCode) }}">
                                            {{ $properties['native'] }}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                </ul>

                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <div class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="text-muted text-xs block">{{ Auth::user()->name }}<b class="caret"></b></span></a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                {{-- <li><a href="profile.html">Perfil</a></li>
                                 <li><a href="contacts.html">Notificações</a></li>--}}
                                {{--<li class="divider"></li>--}}
                                <li><a href="{{ url('auth/logout') }}">Sair</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mainly scripts -->
<script src="{{ asset('/js/jquery-2.1.1.js')}}"></script>
<script src="{{ asset('/js/jquery-ui.js')}}"></script>
<script src="{{ asset('/js/select2.full.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
<script src="{{ asset('/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{ asset('/js/bootstrapvalidator.js')}}" type="text/javascript"></script>
<script src="{{ asset('/js/jquery.tree.js')}}" type="text/javascript"></script>
<script src="{{ asset('/js/jquery.datetimepicker.js')}}" type="text/javascript"></script>
<script src="{{ asset('/js/jquery.dataTables.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('/js/bootstrap-multiselect.js')}}" type="text/javascript"></script>
<script src="{{ asset('/js/bootbox.min.js')}}" type="text/javascript"></script>

<script src="{{ asset('/js/dataTables.buttons.min.js')}}" type="text/javascript"></script>

<script src="{{ asset('/vendor/datatables/buttons.server-side.js') }}"></script>

{{--<script src="{{ asset('/js/jquery.datatables.customsearch.js')}}" type="text/javascript"></script>--}}

<!-- zTree -->
<script src="{{ asset('/js/plugins/zTree/jquery.ztree.core.min.js')}}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('/js/inspinia.js')}}"></script>
<script src="{{ asset('/js/plugins/pace/pace.min.js')}}"></script>
<script src="{{ asset('/js/plugins/toastr.min.js')}}"></script>
<script src="{{ asset('/js/jasny-bootstrap.js')}}"></script>
<script src="{{ asset('/js/jquery.mask.js')}}"></script>
<script src="{{ asset('/js/mascaras.js')}}"></script>
<script src="{{ asset('/js/sb-admin-2.js')}}"></script>
<script src="{{ asset('/messages.js')}}"></script>
<script src="{{ asset('/js/plugins/sweetalert/sweetalert.min.js')  }}"></script>
<script src="{{ asset('/js/plugins/botao/materialize.min.js')  }}"></script>

<script type="text/javascript">
    $(document).on({
        'show.bs.modal': function () {
            var zIndex = 1040 + (10 * $('.modal:visible').length);
            $(this).css('z-index', zIndex);
            setTimeout(function() {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
        },
        'hidden.bs.modal': function() {
            if ($('.modal:visible').length > 0) {
                // restore the modal-open class to the body element, so that scrolling works
                // properly after de-stacking a modal.
                setTimeout(function() {
                    $(document.body).addClass('modal-open');
                }, 0);
            }
        }
    }, '.modal');

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "progressBar": true,
        "preventDuplicates": false,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "400",
        "hideDuration": "1000",
        "timeOut": "10000",
        "extendedTimeOut": "10000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    verificarNovasDemandas();
    verificarDemandasAtrasadas();

    // Verificar noas demandas
    function verificarNovasDemandas() {
        //Combobox pesquisa turmas por serie via ajax
        $(document).ready(function () {

            jQuery.ajax({
                type: 'POST',
                url: "{!! route('seracademico.ouvidoria.encaminhamento.novosEncaminhanetos') !!}",
                datatype: 'json'
            }).done(function (json) {
                if (json['msg'] === "sucesso") {
                    toastr.info('Você tem novas demandas a serem analisadas','Novas Demandas!');
                    //toastr.clear();
                }
            });

            toastr.options.onclick = function () {
                window.location.href = '{!! route('seracademico.ouvidoria.encaminhamento.encaminhados') !!}'
            };

        });
    }

    // Verificar demandas atrasadas
    function verificarDemandasAtrasadas() {
        //Combobox pesquisa turmas por serie via ajax
        $(document).ready(function () {

            jQuery.ajax({
                type: 'POST',
                url: "{!! route('seracademico.ouvidoria.encaminhamento.demandasAtrasadas') !!}",
                datatype: 'json'
            }).done(function (json) {
                if (json['msg'] === "sucesso") {
                    toastr.warning('Você tem demandas em atraso','Demandas Atrasadas!');
                    //toastr.clear();
                }
            });

            toastr.options.onclick = function () {
                window.location.href = '{!! route('seracademico.ouvidoria.encaminhamento.encaminhados') !!}'
            };

        });
    }

    // Faz um refresh para os alertas
    function myLoop () {           //  vamos criar uma função de loop
        setTimeout(function () {    //  Chama a função a cada 3 segundos
            verificarNovasDemandas();
            verificarDemandasAtrasadas();
            toastr.clear();

        }, 12000)
    }
    myLoop();
    var intervalo = window.setInterval(myLoop, 12000);
</script>

@yield('javascript')
</body>

</html>