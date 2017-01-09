<?php

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::get('login', 'Auth\AuthController@getLogin');
        Route::post('login', 'Auth\AuthController@postLogin');
        Route::get('logout', 'Auth\AuthController@getLogout');
    });

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
                Route::get('delete/{id}', ['as' => 'edit', 'uses' => 'Ouvidoria\DemandaController@delete']);
                Route::get('registro/{id}', ['as' => 'registro', 'uses' => 'Ouvidoria\DemandaController@registro']);
                Route::get('reportPessoas', ['as' => 'reportPessoas', 'uses' => 'Ouvidoria\DemandaController@reportPessoas']);
                Route::get('cartaEcaminhamento/{id}', ['as' => 'cartaEcaminhamento', 'uses' => 'Ouvidoria\DemandaController@cartaEcaminhamento']);
                Route::post('situacaoAjax', ['as' => 'situacaoAjax', 'uses' => 'Ouvidoria\DemandaController@situacaoAjax']);
            });

            Route::group(['prefix' => 'report', 'as' => 'report.'], function () {
                Route::get('reportPessoas', ['as' => 'reportPessoas', 'uses' => 'Ouvidoria\DemandaController@reportPessoas']);
                Route::get('viewReportStatus', ['as' => 'viewReportStatus', 'uses' => 'Ouvidoria\DemandaController@viewReportStatus']);
                Route::post('reportStatus', ['as' => 'reportStatus', 'uses' => 'Ouvidoria\DemandaController@reportStatus']);
                Route::get('comunidadeView', ['as' => 'comunidadeView', 'uses' => 'Ouvidoria\DemandaController@comunidadeView']);
                Route::post('comunidade', ['as' => 'comunidade', 'uses' => 'Ouvidoria\DemandaController@comunidade']);
            });

            Route::group(['prefix' => 'tabelas', 'as' => 'tabelas.'], function () {
                Route::get('assuntoClassificacao', ['as' => 'assuntoClassificacao', 'uses' => 'Ouvidoria\TabelasController@assuntoClassificacao']);
                Route::get('assuntoView', ['as' => 'assuntoView', 'uses' => 'Ouvidoria\TabelasController@assuntoView']);
                Route::post('assuntos', ['as' => 'assuntos', 'uses' => 'Ouvidoria\TabelasController@assuntos']);
                Route::get('sexo', ['as' => 'sexo', 'uses' => 'Ouvidoria\TabelasController@sexo']);
                Route::get('escolaridade', ['as' => 'escolaridade', 'uses' => 'Ouvidoria\TabelasController@escolaridade']);
                Route::get('melhorias', ['as' => 'melhorias', 'uses' => 'Ouvidoria\TabelasController@melhorias']);
                Route::get('comunidadeClassificacao', ['as' => 'comunidadeClassificacao', 'uses' => 'Ouvidoria\TabelasController@comunidadeClassificacao']);
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
        });
    });

    //Ouvidoria
    Route::get('createPublico', ['as' => 'createPublico', 'uses' => 'Ouvidoria\DemandaController@createPublic']);
    Route::post('storePublico', ['as' => 'storePublico', 'uses' => 'Ouvidoria\DemandaController@storePublic']);
});