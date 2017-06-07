<?php

Route::get('/', function () {
    return redirect()->route('auth.login');
});


Route::group(['prefix' => LaravelLocalization::setLocale()], function () {

    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
        Route::post('login', 'Auth\AuthController@postLogin');
        Route::get('logout', 'Auth\AuthController@getLogout');
    });

    Route::get('seracademico/indexPublico'  , ['as' => 'seracademico.indexPublico', 'uses' => 'Ouvidoria\DemandaController@indexPublico']);

    Route::group(['prefix' => 'seracademico', 'middleware' => 'auth', 'as' => 'seracademico.'], function () {

        //Rotas gerais
        Route::get('index'  , ['as' => 'index', 'uses' => 'DefaultController@index']);

        Route::group(['prefix' => 'ouvidoria', 'as' => 'ouvidoria.'], function () {

            Route::group(['prefix' => 'demanda', 'as' => 'demanda.'], function () {
                Route::get('index', ['as' => 'index', 'uses' => 'Ouvidoria\DemandaController@index']);
                Route::post('grid', ['as' => 'grid', 'uses' => 'Ouvidoria\DemandaController@grid']);
                Route::get('create', ['as' => 'create', 'uses' => 'Ouvidoria\DemandaController@create']);
                Route::post('store', ['as' => 'store', 'uses' => 'Ouvidoria\DemandaController@store']);
                Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Ouvidoria\DemandaController@edit']);
                Route::post('update/{id}', ['as' => 'update', 'uses' => 'Ouvidoria\DemandaController@update']);
                Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'Ouvidoria\DemandaController@destroy']);
                Route::get('registro/{id}', ['as' => 'registro', 'uses' => 'Ouvidoria\DemandaController@registro']);
                Route::get('reportPessoas', ['as' => 'reportPessoas', 'uses' => 'Ouvidoria\DemandaController@reportPessoas']);
                Route::get('cartaEcaminhamento/{id}', ['as' => 'cartaEcaminhamento', 'uses' => 'Ouvidoria\DemandaController@cartaEcaminhamento']);
                Route::post('situacaoAjax', ['as' => 'situacaoAjax', 'uses' => 'Ouvidoria\DemandaController@situacaoAjax']);
                Route::get('fristEncaminhar/{id}', ['as' => 'fristEncaminhar', 'uses' => 'Ouvidoria\EncaminhamentoController@fristEncaminhar']);
                Route::get('detalheAnalise/{id}', ['as' => 'detalheAnalise', 'uses' => 'Ouvidoria\EncaminhamentoController@detalheParaAnaliseDoEncaminhamento']);
            });

            Route::group(['prefix' => 'encaminhamento', 'as' => 'encaminhamento.'], function () {
                Route::get('encaminhados', ['as' => 'encaminhados', 'uses' => 'Ouvidoria\EncaminhamentoController@encaminhados']);
                Route::post('encaminhadosGrid', ['as' => 'encaminhadosGrid', 'uses' => 'Ouvidoria\EncaminhamentoController@encaminhadosGrid']);
                Route::post('responder', ['as' => 'responder', 'uses' => 'Ouvidoria\EncaminhamentoController@responder']);
                Route::get('historico/{id}', ['as' => 'historico', 'uses' => 'Ouvidoria\EncaminhamentoController@historicoEncamihamentos']);
                Route::post('historicoGrid', ['as' => 'historicoGrid', 'uses' => 'Ouvidoria\EncaminhamentoController@historicoEncamihamentosGrid']);
                Route::get('reencaminar/{id}', ['as' => 'reencaminar', 'uses' => 'Ouvidoria\EncaminhamentoController@reencaminar']);
                Route::post('reencaminarStore', ['as' => 'reencaminarStore', 'uses' => 'Ouvidoria\EncaminhamentoController@reencaminarStore']);
                Route::get('encaminhar/{id}', ['as' => 'encaminhar', 'uses' => 'Ouvidoria\EncaminhamentoController@encaminhar']);
                Route::post('encaminharStore', ['as' => 'encaminharStore', 'uses' => 'Ouvidoria\EncaminhamentoController@encaminharStore']);
                Route::get('finalizar/{id}', ['as' => 'finalizar', 'uses' => 'Ouvidoria\EncaminhamentoController@finalizar']);
                Route::post('prorrogarPrazo', ['as' => 'prorrogarPrazo', 'uses' => 'Ouvidoria\EncaminhamentoController@prorrogarPrazo']);
                Route::post('prorrogarPrazoSolucao', ['as' => 'prorrogarPrazoSolucao', 'uses' => 'Ouvidoria\EncaminhamentoController@prorrogarPrazoSolucao']);

                #notificações
                Route::post('verificarAlertasDeDemandas', ['as' => 'verificarAlertasDeDemandas', 'uses' => 'Ouvidoria\EncaminhamentoController@verificarAlertasDeDemandas']);

                #Demandas agrupadas
                Route::post('demandasAgrupadasGrid', ['as' => 'demandasAgrupadasGrid', 'uses' => 'Ouvidoria\EncaminhamentoController@demandasAgrupadasGrid']);
                Route::post('agruparDemanda', ['as' => 'agruparDemanda', 'uses' => 'Ouvidoria\EncaminhamentoController@agruparDemanda']);
                Route::post('deleteAgrupamento', ['as' => 'deleteAgrupamento', 'uses' => 'Ouvidoria\EncaminhamentoController@deletarDemandaAgrupada']);

            });

            Route::group(['prefix' => 'secretaria', 'as' => 'secretaria.'], function () {
                Route::get('index', ['as' => 'index', 'uses' => 'SecretariasController@index']);
                Route::post('grid', ['as' => 'grid', 'uses' => 'SecretariasController@grid']);
                Route::get('create', ['as' => 'create', 'uses' => 'SecretariasController@create']);
                Route::post('store', ['as' => 'store', 'uses' => 'SecretariasController@store']);
                Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'SecretariasController@edit']);
                Route::post('update/{id}', ['as' => 'update', 'uses' => 'SecretariasController@update']);
                Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'SecretariasController@destroy']);
            });

            Route::group(['prefix' => 'departamento', 'as' => 'departamento.'], function () {
                Route::get('index', ['as' => 'index', 'uses' => 'DepartamentosController@index']);
                Route::post('grid', ['as' => 'grid', 'uses' => 'DepartamentosController@grid']);
                Route::get('create', ['as' => 'create', 'uses' => 'DepartamentosController@create']);
                Route::post('store', ['as' => 'store', 'uses' => 'DepartamentosController@store']);
                Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'DepartamentosController@edit']);
                Route::post('update/{id}', ['as' => 'update', 'uses' => 'DepartamentosController@update']);
                Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'DepartamentosController@destroy']);
            });

            Route::group(['prefix' => 'assunto', 'as' => 'assunto.'], function () {
                Route::get('index', ['as' => 'index', 'uses' => 'AssuntoController@index']);
                Route::post('grid', ['as' => 'grid', 'uses' => 'AssuntoController@grid']);
                Route::get('create', ['as' => 'create', 'uses' => 'AssuntoController@create']);
                Route::post('storeAjax', ['as' => 'storeAjax', 'uses' => 'AssuntoController@storeAjax']);
                Route::post('store', ['as' => 'store', 'uses' => 'AssuntoController@store']);
                Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'AssuntoController@edit']);
                Route::post('update/{id}', ['as' => 'update', 'uses' => 'AssuntoController@update']);
                Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'AssuntoController@destroy']);
            });

            Route::group(['prefix' => 'subassunto', 'as' => 'subassunto.'], function () {
                Route::get('index', ['as' => 'index', 'uses' => 'SubassuntoController@index']);
                Route::post('grid', ['as' => 'grid', 'uses' => 'SubassuntoController@grid']);
                Route::get('create', ['as' => 'create', 'uses' => 'SubassuntoController@create']);
                Route::post('store', ['as' => 'store', 'uses' => 'SubassuntoController@store']);
                Route::post('storeAjax', ['as' => 'storeAjax', 'uses' => 'SubassuntoController@storeAjax']);
                Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'SubassuntoController@edit']);
                Route::post('update/{id}', ['as' => 'update', 'uses' => 'SubassuntoController@update']);
                Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'SubassuntoController@destroy']);
            });
            
            Route::group(['prefix' => 'report', 'as' => 'report.'], function () {
                Route::get('viewReportPessoas', ['as' => 'viewReportPessoas', 'uses' => 'Ouvidoria\DemandaController@viewReportPessoas']);
                Route::post('reportPessoas', ['as' => 'reportPessoas', 'uses' => 'Ouvidoria\DemandaController@reportPessoas']);
                Route::get('viewReportStatus', ['as' => 'viewReportStatus', 'uses' => 'Ouvidoria\DemandaController@viewReportStatus']);
                Route::post('reportStatus', ['as' => 'reportStatus', 'uses' => 'Ouvidoria\DemandaController@reportStatus']);
                Route::get('comunidadeView', ['as' => 'comunidadeView', 'uses' => 'Ouvidoria\DemandaController@comunidadeView']);
                Route::post('comunidade', ['as' => 'comunidade', 'uses' => 'Ouvidoria\DemandaController@comunidade']);
            });

            Route::group(['prefix' => 'tabelas', 'as' => 'tabelas.'], function () {
                Route::get('viewAssuntoClassificacao', ['as' => 'viewAssuntoClassificacao', 'uses' => 'Ouvidoria\TabelasController@viewAssuntoClassificacao']);
                Route::post('assuntoClassificacao', ['as' => 'assuntoClassificacao', 'uses' => 'Ouvidoria\TabelasController@assuntoClassificacao']);
                Route::get('assuntoView', ['as' => 'assuntoView', 'uses' => 'Ouvidoria\TabelasController@assuntoView']);
                Route::post('assuntos', ['as' => 'assuntos', 'uses' => 'Ouvidoria\TabelasController@assuntos']);
                Route::get('viewSexo', ['as' => 'viewSexo', 'uses' => 'Ouvidoria\TabelasController@viewSexo']);
                Route::post('sexo', ['as' => 'sexo', 'uses' => 'Ouvidoria\TabelasController@sexo']);
                Route::get('viewEscolaridade', ['as' => 'viewEscolaridade', 'uses' => 'Ouvidoria\TabelasController@viewEscolaridade']);
                Route::post('escolaridade', ['as' => 'escolaridade', 'uses' => 'Ouvidoria\TabelasController@escolaridade']);
                Route::get('viewMelhorias', ['as' => 'viewMelhorias', 'uses' => 'Ouvidoria\TabelasController@viewMelhorias']);
                Route::post('melhorias', ['as' => 'melhorias', 'uses' => 'Ouvidoria\TabelasController@melhorias']);
                Route::get('viewComunidadeClassificacao', ['as' => 'viewComunidadeClassificacao', 'uses' => 'Ouvidoria\TabelasController@viewComunidadeClassificacao']);
                Route::post('comunidadeClassificacao', ['as' => 'comunidadeClassificacao', 'uses' => 'Ouvidoria\TabelasController@comunidadeClassificacao']);
            });

            Route::group(['prefix' => 'graficos', 'as' => 'graficos.'], function () {
                Route::get('caracteristicasView', ['as' => 'caracteristicasView', 'uses' => 'Ouvidoria\GraficosController@caracteristicasView']);
                Route::get('caracteristicas', ['as' => 'caracteristicas', 'uses' => 'Ouvidoria\GraficosController@caracteristicas']);
                Route::post('caracteristicasAjax', ['as' => 'caracteristicasAjax', 'uses' => 'Ouvidoria\GraficosController@caracteristicasAjax']);
                Route::get('assuntoView', ['as' => 'assuntoView', 'uses' => 'Ouvidoria\GraficosController@assuntoView']);
                Route::get('assunto', ['as' => 'assunto', 'uses' => 'Ouvidoria\GraficosController@assunto']);
                Route::post('assuntoAjax', ['as' => 'assuntoAjax', 'uses' => 'Ouvidoria\GraficosController@assuntoAjax']);
                Route::get('subassuntoView', ['as' => 'subassuntoView', 'uses' => 'Ouvidoria\GraficosController@subassuntoView']);
                Route::get('subassunto', ['as' => 'subassunto', 'uses' => 'Ouvidoria\GraficosController@subassunto']);
                Route::post('subassuntoAjax', ['as' => 'subassuntoAjax', 'uses' => 'Ouvidoria\GraficosController@subassuntoAjax']);
                Route::get('meioRegistroView', ['as' => 'meioRegistroView', 'uses' => 'Ouvidoria\GraficosController@meioRegistroView']);
                Route::get('meioRegistro', ['as' => 'meioRegistro', 'uses' => 'Ouvidoria\GraficosController@meioRegistro']);
                Route::post('meioRegistroAjax', ['as' => 'meioRegistroAjax', 'uses' => 'Ouvidoria\GraficosController@meioRegistroAjax']);
                Route::get('perfilView', ['as' => 'perfilView', 'uses' => 'Ouvidoria\GraficosController@perfilView']);
                Route::get('perfil', ['as' => 'perfil', 'uses' => 'Ouvidoria\GraficosController@perfil']);
                Route::post('perfilAjax', ['as' => 'perfilAjax', 'uses' => 'Ouvidoria\GraficosController@perfilAjax']);
                Route::get('escolaridadeView', ['as' => 'escolaridadeView', 'uses' => 'Ouvidoria\GraficosController@escolaridadeView']);
                Route::get('escolaridade', ['as' => 'escolaridade', 'uses' => 'Ouvidoria\GraficosController@escolaridade']);
                Route::post('escolaridadeAjax', ['as' => 'escolaridadeAjax', 'uses' => 'Ouvidoria\GraficosController@escolaridadeAjax']);
                Route::get('idade', ['as' => 'idade', 'uses' => 'Ouvidoria\GraficosController@idade']);
                Route::post('idadeAjax', ['as' => 'idadeAjax', 'uses' => 'Ouvidoria\GraficosController@idadeAjax']);
                Route::get('demandasView', ['as' => 'demandasView', 'uses' => 'Ouvidoria\GraficosController@demandasView']);
                Route::post('demandasAjax', ['as' => 'demandasAjax', 'uses' => 'Ouvidoria\GraficosController@demandasAjax']);

                Route::get('atendimento', ['as' => 'atendimento', 'uses' => 'Ouvidoria\GraficosController@atendimento']);
                Route::post('atendimentoAjax', ['as' => 'atendimentoAjax', 'uses' => 'Ouvidoria\GraficosController@atendimentoAjax']);
                Route::get('informacao', ['as' => 'informacao', 'uses' => 'Ouvidoria\GraficosController@informacao']);
                Route::post('informacaoAjax', ['as' => 'informacaoAjax', 'uses' => 'Ouvidoria\GraficosController@informacaoAjax']);
                Route::get('status', ['as' => 'status', 'uses' => 'Ouvidoria\GraficosController@status']);
                Route::post('statusAjax', ['as' => 'statusAjax', 'uses' => 'Ouvidoria\GraficosController@statusAjax']);
                Route::get('melhoria', ['as' => 'melhoria', 'uses' => 'Ouvidoria\GraficosController@melhoria']);
                Route::post('melhoriaAjax', ['as' => 'melhoriaAjax', 'uses' => 'Ouvidoria\GraficosController@melhoriaAjax']);
                Route::get('melhorias', ['as' => 'melhorias', 'uses' => 'Ouvidoria\GraficosController@melhorias']);
                Route::post('melhoriasAjax', ['as' => 'melhoriasAjax', 'uses' => 'Ouvidoria\GraficosController@melhoriasAjax']);
            });

            Route::group(['prefix' => 'psf', 'as' => 'psf.'], function () {
                Route::get('index', ['as' => 'index', 'uses' => 'PsfController@index']);
                Route::post('grid', ['as' => 'grid', 'uses' => 'PsfController@grid']);
                Route::get('create', ['as' => 'create', 'uses' => 'PsfController@create']);
                Route::post('store', ['as' => 'store', 'uses' => 'PsfController@store']);
                Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'PsfController@edit']);
                Route::post('update/{id}', ['as' => 'update', 'uses' => 'PsfController@update']);
                Route::get('destroy/{id}', ['as' => 'edit', 'uses' => 'PsfController@destroy']);
            });

            Route::group(['prefix' => 'comunidade', 'as' => 'comunidade.'], function () {
                Route::get('index', ['as' => 'index', 'uses' => 'Ouvidoria\ComunidadeController@index']);
                Route::post('grid', ['as' => 'grid', 'uses' => 'Ouvidoria\ComunidadeController@grid']);
                Route::get('create', ['as' => 'create', 'uses' => 'Ouvidoria\ComunidadeController@create']);
                Route::post('store', ['as' => 'store', 'uses' => 'Ouvidoria\ComunidadeController@store']);
                Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Ouvidoria\ComunidadeController@edit']);
                Route::post('update/{id}', ['as' => 'update', 'uses' => 'Ouvidoria\ComunidadeController@update']);
                Route::get('destroy/{id}', ['as' => 'edit', 'uses' => 'Ouvidoria\ComunidadeController@destroy']);
            });

            // Rotas referente a 'melhoria'
            Route::group(['prefix' => 'melhoria', 'as' => 'melhoria.'], function () {
                Route::get('index', ['as' => 'index', 'uses' => 'MelhoriaController@index']);
                Route::post('grid', ['as' => 'grid', 'uses' => 'MelhoriaController@grid']);
                Route::get('create', ['as' => 'create', 'uses' => 'MelhoriaController@create']);
                Route::post('store', ['as' => 'store', 'uses' => 'MelhoriaController@store']);
                Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'MelhoriaController@edit']);
                Route::post('update/{id}', ['as' => 'update', 'uses' => 'MelhoriaController@update']);
                Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'MelhoriaController@destroy']);
            });
        });

        //Rotas para componentes de segurança
        Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
            Route::get('index', ['as' => 'index', 'uses' => 'UserController@index']);
            Route::get('grid', ['as' => 'grid', 'uses' => 'UserController@grid']);
            Route::get('create', ['as' => 'create', 'uses' => 'UserController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'UserController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'UserController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'UserController@update']);
        });

        Route::group(['prefix' => 'role', 'as' => 'role.'], function () {
            Route::get('index', ['as' => 'index', 'uses' => 'RoleController@index']);
            Route::get('grid', ['as' => 'grid', 'uses' => 'RoleController@grid']);
            Route::get('create', ['as' => 'create', 'uses' => 'RoleController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'RoleController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'RoleController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'RoleController@update']);
        });

        //Rotas de utilitários
        Route::group(['prefix' => 'util', 'as' => 'util.'], function () {
            Route::post('search', ['as' => 'search', 'uses' => 'UtilController@search']);
            Route::post('select2', ['as' => 'select2', 'uses' => 'UtilController@queryByselect2']);
            Route::post('select2Obra', ['as' => 'select2Obra', 'uses' => 'UtilController@queryByselect2Obra']);
            Route::post('select2personalizado', ['as' => 'select2personalizado', 'uses' => 'UtilController@queryByselect2Personalizado']);
            Route::post('selectsize', ['as' => 'selectsize', 'uses' => 'UtilController@selectsize']);
        });

        // Rotas de configurações
        Route::group(['prefix' => 'configuracao', 'as' => 'configuracao.'], function () {

            // Confirugação geral
            Route::group(['prefix' => 'configuracaoGeral', 'as' => 'configuracaoGeral.'], function () {
                Route::get('edit', ['as' => 'edit', 'uses' => 'Configuracao\ConfiguracaoGeralController@edit']);
                Route::post('update/{id}', ['as' => 'update', 'uses' => 'Configuracao\ConfiguracaoGeralController@update']);
            });

        });
    });

    //Ouvidoria
    Route::get('createPublico', ['as' => 'createPublico', 'uses' => 'Ouvidoria\DemandaController@createPublic']);
    Route::post('storePublico', ['as' => 'storePublico', 'uses' => 'Ouvidoria\DemandaController@storePublic']);
    Route::get('buscarDemanda', ['as' => 'buscarDemanda', 'uses' => 'Ouvidoria\DemandaController@buscarDemanda']);
    Route::post('getDemanda', ['as' => 'getDemanda', 'uses' => 'Ouvidoria\DemandaController@getDemanda']);
});