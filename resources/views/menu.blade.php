<!DOCTYPE html>
<!--[if IE 9 ]-->
<html class="ie9">
<!--[endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SerOuvidor - Sistema Eletrônico Para Gestão de Ouvidorias</title>

    @if(config('app.debug'))
        <link type="text/css" rel="stylesheet" href="{{ asset('/lib/fullcalendar/dist/fullcalendar.min.css') }}"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('/lib/animate.css/animate.min.css') }}"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('/lib/sweetalert2/dist/sweetalert2.min.css') }}"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('/lib/material-design-iconic-font/dist/css/material-design-iconic-font.min.css') }}"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('/lib/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css') }}"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('/lib/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="{{ asset('/lib/select2/dist/css/select2.min.css')}}" rel="stylesheet"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('/lib/select2-bootstrap-theme/dist/select2-bootstrap.min.css')}}" rel="stylesheet"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('/lib/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}" rel="stylesheet"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('/css/plugins/toastr/toastr.min.css')}}">
        <link type="text/css" rel="stylesheet" href="{{ asset('/lib/chosen/chosen.css') }}" >
        <link type="text/css" rel="stylesheet" href="{{ asset('/lib/summernote/dist/summernote.css') }}">
        <link type="text/css" rel="stylesheet" href="{{ asset('/dist/css/app_1.min.css') }}"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('/dist/css/app_2.min.css') }}"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('/dist/css/demo.css') }}"  media="screen,projection"/>
    @else
        <link rel="stylesheet" href="{{ asset('/dist/prod.min.css') }}">
    @endif


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
            <a href="#">SerOuvidoria</a>
        </li>

        <li class="pull-right">
            <ul class="hi-menu">

                @role('ouvidoria|admin')
                    <li class="dropdown hidden-xs">
                        <a title="Novas manifestações" id="novas-demandas" href="{{route('seracademico.ouvidoria.demanda.index', ['status' => '7' ])}}">
                            <i class="him-icon zmdi zmdi-assignment-o"></i>
                        </a>
                    </li>

                    <li class="dropdown hidden-xs">
                        <a title="Manifestações encaminhadas" id="demandas-encaminhadas" href="{{route('seracademico.ouvidoria.demanda.index', ['status' => '1' ])}}">
                            <i class="him-icon zmdi zmdi-mail-send"></i>
                        </a>
                    </li>
                @endrole

                <li class="dropdown hidden-xs">
                    <a title="Manifestações aguardando resposta" id="demandas-analise" href="{{route('seracademico.ouvidoria.demanda.index', ['status' => '2' ])}}">
                        <i class="him-icon zmdi zmdi-search"></i>
                    </a>
                </li>

                <li class="dropdown hidden-xs">
                    <a title="Manifestações respondidas" id="demandas-concluidas" href="{{route('seracademico.ouvidoria.demanda.index', ['status' => '3' ])}}">
                        <i class="him-icon zmdi zmdi-thumb-up"></i>
                    </a>
                </li>

                @role('ouvidoria|admin')
                    <li class="dropdown hidden-xs">
                        <a title="Manifestações a atrasar" id="demandas-para-atrasar" href="{{route('seracademico.ouvidoria.demanda.index', ['status' => '5' ])}}">
                            <i class="him-icon zmdi zmdi-alarm-check"></i>
                        </a>
                    </li>

                    <li class="dropdown hidden-xs">
                        <a title="Manifestações atrasadas" id="demandas-atrasadas" href="{{route('seracademico.ouvidoria.demanda.index', ['status' => '6' ])}}">
                            <i class="him-icon zmdi zmdi-timer-off"></i>
                        </a>
                    </li>
                @endrole

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
            <a href="#" data-ma-action="profile-menu-toggle">
                <div class="sp-pic">
                   <img src="{{ asset ('/dist/img/demo/profile-pics/Untitled-1.png') }}" alt="">
                    {{--{{dd(Auth::user())}}--}}
                    {{--{{Auth::user()->operador()->get()->first()->nome_operadores}}--}}
                </div>

                <div class="sp-info">
                    {{ Auth::user()->name }}
                    <i class="zmdi zmdi-caret-down"></i>
                </div>
            </a>

            <ul class="main-menu">
                <li>
                    <a href="{{ route('seracademico.user.editPerfil')  }}"><i class="zmdi zmdi-account"></i>Perfil</a>
                </li>
                {{-- <li>
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
            <li><a href="{{ route('indexPublico')  }}" target="_blank"><i class="zmdi zmdi-globe-alt"></i> Acesso Público</a></li>
            <li><a href="{{ route('seracademico.index')  }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
            @role('ouvidoria|admin|secretaria')
                <li><a href="{{ route('seracademico.ouvidoria.demanda.index')  }}"><i class="zmdi zmdi-assignment-o"></i> Manifestação</a></li>
            @endrole
            {{--@role('ouvidoria|secretaria|admin')
                <li><a href="{{ route('seracademico.ouvidoria.encaminhamento.encaminhados') }}"><i class="zmdi zmdi-mail-send"></i> Encaminhamentos</a></li>
            @endrole--}}
            @role('ouvidoria|admin')
            <li><a href="{{ route('seracademico.ouvidoria.demanda.manifestacoesArquivadas')  }}"><i class="zmdi zmdi-archive"></i> Arquivadas</a></li>
            <li class="sub-menu">
                <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-plus"></i> Cadastros</a>
                <ul>
                    {{--<li><a href="{{ route('seracademico.ouvidoria.psf.index')  }}">PSF</a></li>--}}
                    <!--<li><a href="{{ route('seracademico.ouvidoria.comunidade.index')  }}">Comunidade</a></li>-->
                    <li><a href="{{ route('seracademico.ouvidoria.secretaria.index')  }}">Secretarias</a></li>
                    <li><a href="{{ route('seracademico.ouvidoria.departamento.index')  }}">Departamentos</a></li>
                    <li><a href="{{ route('seracademico.ouvidoria.assunto.index')  }}">Assunto</a></li>
                    <li><a href="{{ route('seracademico.ouvidoria.subassunto.index')  }}">Subassunto</a></li>
                    {{--<li><a href="{{ route('seracademico.ouvidoria.melhoria.index')  }}">Melhorias</a></li>--}}
                </ul>
            </li>
            @endrole
            @role('ouvidoria|admin')
            <li class="sub-menu">
                <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-assignment"></i> Relatório</a>
                <ul>
                    <li><a href="{{ route('seracademico.ouvidoria.report.viewReportPessoas')  }}">Pessoas</a></li>
                    <li><a href="{{ route('seracademico.ouvidoria.report.viewReportStatus')  }}">Status</a></li>
                <!--<li><a href="{{ route('seracademico.ouvidoria.report.comunidadeView')  }}">Comunidade</a></li>-->
                </ul>
            </li>
            @endrole
            @role('ouvidoria|admin')
                <li class="sub-menu">
                    <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-view-compact"></i> Tabelas</a>
                    <ul>
                        <li><a href="{{ route('seracademico.ouvidoria.tabelas.viewAssuntoClassificacao')  }}">Assunto class.</a></li>
                        <li><a href="{{ route('seracademico.ouvidoria.tabelas.assuntoView')  }}">Assuntos x Subass.</a></li>
                        <li><a href="{{ route('seracademico.ouvidoria.tabelas.viewSexo')  }}">Sexo</a></li>
                        {{--<li><a href="{{ route('seracademico.ouvidoria.tabelas.viewEscolaridade')  }}">Escolaridade</a></li>
                        <li><a href="{{ route('seracademico.ouvidoria.tabelas.viewMelhorias')  }}">Melhoria</a></li>--}}
                        {{--<li><a href="{{ route('seracademico.ouvidoria.tabelas.viewComunidadeClassificacao')  }}">Comunidade class.</a></li>--}}
                    </ul>
                </li>
            @endrole
            @role('ouvidoria|admin')
            <li class="sub-menu">
                <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-chart"></i> Gráficos</a>
                <ul>
                    <li><a href="{{ route('seracademico.ouvidoria.graficos.caracteristicasView')  }}">Características</a></li>
                    <li><a href="{{ route('seracademico.ouvidoria.graficos.assuntoView')  }}">Assuntos</a></li>
                    <li><a href="{{ route('seracademico.ouvidoria.graficos.subassuntoView')  }}">Subassuntos</a></li>
                    <li><a href="{{ route('seracademico.ouvidoria.graficos.meioRegistroView')  }}">Tipo de manifestação</a></li>
                    <li><a href="{{ route('seracademico.ouvidoria.graficos.perfilView')  }}">Perfis</a></li>
                    {{--<li><a href="{{ route('seracademico.ouvidoria.graficos.escolaridadeView')  }}">Escolaridade</a></li>--}}
                    <li><a href="{{ route('seracademico.ouvidoria.graficos.atendimento')  }}">Meio de registro</a></li>
                    <li><a href="{{ route('seracademico.ouvidoria.graficos.informacao')  }}">Calss. Manifestação</a></li>
                    <li><a href="{{ route('seracademico.ouvidoria.graficos.status')  }}">Status demanda</a></li>
                    {{--<li><a href="{{ route('seracademico.ouvidoria.graficos.melhorias')  }}">Melhorias</a></li>
                    <li><a href="{{ route('seracademico.ouvidoria.graficos.melhoria')  }}">Recla. x Melhoria</a></li>--}}
                    <li><a href="{{ route('seracademico.ouvidoria.graficos.demandasView')  }}">Manifestação</a></li>
                </ul>
            </li>
            @endrole
            @role('ouvidoria|admin')
            <li class="sub-menu">
                <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-shield-security"></i> Segurança</a>
                <ul>
                    <li><a href="{{ route('seracademico.user.index')  }}">Usuários</a></li>
                    {{--<li><a href="{{ route('seracademico.role.index')  }}">Perfís</a></li>--}}
                </ul>
            </li>
            @endrole
            @role('admin')
                <li class="sub-menu">
                    <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-assignment"></i> Configurações</a>
                    <ul>
                        <li><a href="{{ route('seracademico.configuracao.configuracaoGeral.edit')  }}">Geral</a></li>
                        <li><a href="{{ route('seracademico.template.index')  }}">Importar template</a></li>
                    </ul>
                </li>
            @endrole
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

@if(config('app.debug'))
    <script src="{{ asset('/lib/jquery/dist/jquery.js') }}"></script>
    <script src="{{ asset('/lib/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/lib/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ asset('/lib/Waves/dist/waves.min.js') }}"></script>
    <script src="{{ asset('/lib/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('/lib/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/lib/select2/dist/js/select2.full.js') }}"></script>
    <script src="{{ asset('/js/plugins/toastr.min.js')}}"></script>
    {{--<script src="{{ asset('/js/jquery.tree.js')}}" type="text/javascript"></script>--}}
    <script src="{{ asset('/js/jquery.mask.js')}}"></script>
    <script src="{{ asset('/js/mascaras.js')}}"></script>

    <!-- Datepicker e suas dependencias. Sempre importa-lo nessa ordem -->
    <script src="{{ asset('/lib/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('/lib/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('/lib/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

    {{--jquery Validator https://jqueryvalidation.org/ --}}
    <script src="{{ asset('/lib/jquery-validation/dist/jquery.validate.js') }}"></script>
    <script src="{{ asset('/lib/jquery-validation/src/additional/cpfBR.js') }}"></script>

    {{-- Mascaras https://igorescobar.github.io/jQuery-Mask-Plugin/ --}}
    <script src="{{ asset('/lib/jquery-mask-plugin/dist/jquery.mask.js') }}"></script>

    <!-- Placeholder for IE9 -->
    <script type="text/javascript" src={{ asset('/lib/jquery-placeholder/jquery.placeholder.min.js') }}></script>

    {{--<script src="{{ asset('/js/laroute.js') }}"></script>--}}
    <script src="{{ asset('/lib/chosen/chosen.jquery.js') }}"></script>
    <script type="text/javascript" src={{ asset('/dist/js/app.js') }}></script>

    {{--Mensagens personalizadas--}}
    <script type="text/javascript" src="{{ asset('/dist/js/messages_pt_BR.js')  }}"></script>

    {{-- Js para as validações do formulário  --}}
    <script type="text/javascript" src="{{ asset('/dist/js/validacao/adicional/alphaSpace.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/lib/jquery-validation/src/additional/integer.js')  }}"></script>

    {{-- Importes da página de detalhe de encaminhamento  --}}
    <script src="{{ asset('/js/validacoes/encaminhamento.js')}}"></script>
    <script src="{{ asset('/js/validacoes/primeiro_encaminhamento.js')}}"></script>
    <script src="{{ asset('/js/validacoes/reencaminhamento.js')}}"></script>
    <script src="{{ asset('/js/validacoes/modal_responder_ouvidor.js')}}"></script>
    <script src="{{ asset('/js/validacoes/modal_prorrogar_prazo_manifestacao.js')}}"></script>
    <script src="{{ asset('/js/demanda/detalhe_da_manifestacao.js')}}"></script>

    {{-- Importes da página de encaminhamento --}}
    <script src="{{ asset('/js/encaminhamento/create_assunto_subassunto_ajax.js')}}"></script>
    <script src="{{ asset('/js/encaminhamento/encaminhamento.js')}}"></script>

    {{-- Importes da página de create e update e index de demanda --}}
    {{--<script src="{{ asset('/js/validacoes/demanda.js')}}"></script>
    <script src="{{ asset('/js/demanda/create_demanda.js')}}"></script>--}}
    <script src="{{ asset('/js/demanda/index_demanda.js')}}"></script>


    {{-- Importes da página gráficos --}}
    <script src="{{ asset('/js/plugins/highcharts.js')  }}"></script>
    <script src="{{ asset('/js/plugins/exporting.js')  }}"></script>

    {{-- Importes das página de relatórios --}}
    <script src="{{ asset('/js/reports/report_comunidade.js')  }}"></script>

    {{-- Importes das página de tabelas --}}
    <script src="{{ asset('/js/tabelas/tabela_assuntos.js')  }}"></script>

@else
    <script type="text/javascript" src="{{ asset('/dist/prod.min.js') }}"></script>
@endif

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


    verificarAlertasDeDemandas();

    // Função para alerta das demandas
    function verificarAlertasDeDemandas() {
        $(document).ready(function () {

            jQuery.ajax({
                type: 'POST',
                url: "{!! route('seracademico.ouvidoria.encaminhamento.verificarAlertasDeDemandas') !!}",
                datatype: 'json'
            }).done(function (json) {

                if(json['novas']) {
                    var html = "<i class='him-counts novas-demandas-qtd'>"+ json['novas'] +"</i>"
                    $('.novas-demandas-qtd').remove();
                    $('#novas-demandas').append(html);
                }
                if(json['encaminhadas']) {
                    var html = "<i class='him-counts demandas-encaminhadas-qtd'>"+ json['encaminhadas'] +"</i>"
                    $('.demandas-encaminhadas-qtd').remove();
                    $('#demandas-encaminhadas').append(html);
                }
                if(json['emAnalise']) {
                    var html = "<i class='him-counts demandas-analise-qtd'>"+ json['emAnalise'] +"</i>"
                    $('.demandas-analise-qtd').remove();
                    $('#demandas-analise').append(html);
                }
                if(json['concluidas']) {
                    var html = "<i class='him-counts demandas-concluidas-qtd'>"+json['concluidas']+"</i>"
                    $('.demandas-concluidas-qtd').remove();
                    $('#demandas-concluidas').append(html);
                }
                if(json['aAtrasar']) {
                    var html = "<i class='him-counts demandas-para-atrasar-qtd'>" + json['aAtrasar'] + "</i>"
                    $('.demandas-para-atrasar-qtd').remove();
                    $('#demandas-para-atrasar').append(html);
                }
                if(json['atrasadas']) {
                    var html = "<i class='him-counts demandas-atrasadas-qtd'>" + json['atrasadas'] + "</i>"
                    $('.demandas-atrasadas-qtd').remove();
                    $('#demandas-atrasadas').append(html);
                }

            });

        });
    }

    // Faz um refresh para os alertas
    function myLoop () {           //  vamos criar uma função de loop
        setTimeout(function () {    //  Chama a função a cada 3 segundos
            verificarAlertasDeDemandas();
        }, 16000)
    }
    myLoop();
    var intervalo = window.setInterval(myLoop, 16000);
</script>

@yield('javascript')

</body>
</html>