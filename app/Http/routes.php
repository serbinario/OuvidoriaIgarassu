<?php

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::get('login', 'Auth\AuthController@getLogin');
        Route::post('login', 'Auth\AuthController@postLogin');
        Route::get('logout', 'Auth\AuthController@getLogout');
    });

    Route::group(['prefix' => 'seracademico', 'middleware' => 'auth', 'as' => 'seracademico.'], function () {
        Route::group(['prefix' => 'matricula', 'as' => 'matricula.'], function () {
            Route::get('index', ['as' => 'index', 'uses' => 'MatriculaAlunoController@index']);
            Route::get('gridAluno', ['as' => 'gridAluno', 'uses' => 'MatriculaAlunoController@gridAluno']);
            Route::get('gridDisciplina/{idAluno}', ['as' => 'gridDisciplina', 'uses' => 'MatriculaAlunoController@gridDisciplina']);
            Route::get('gridHorario/{idAluno}', ['as' => 'gridHorario', 'uses' => 'MatriculaAlunoController@gridHorario']);
            Route::post('getTurmas', ['as' => 'getTurmas', 'uses' => 'MatriculaAlunoController@getTurmas']);
            Route::post('adicionarHorarioAluno', ['as' => 'adicionarHorarioAluno', 'uses' => 'MatriculaAlunoController@adicionarHorarioAluno']);
        });

        Route::group(['prefix' => 'parametro', 'as' => 'parametro.'], function () {
            Route::get('index', ['as' => 'index', 'uses' => 'ParametroController@index']);
            Route::get('grid', ['as' => 'grid', 'uses' => 'ParametroController@grid']);
            Route::get('create', ['as' => 'create', 'uses' => 'ParametroController@create']);
            Route::post('store', ['as' => 'store', 'uses' => 'ParametroController@store']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'ParametroController@edit']);
            Route::post('update/{id}', ['as' => 'update', 'uses' => 'ParametroController@update']);

            Route::group(['prefix' => 'itens', 'as' => 'itens.'], function () {
                Route::get('grid/{idParametro}', ['as' => 'grid', 'uses' => 'ParametroController@gridItens']);
                Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'ParametroController@deleteItem']);
                Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'ParametroController@editItem']);
                Route::post('update/{id}', ['as' => 'update', 'uses' => 'ParametroController@updateItem']);
            });
        });


        //Rotas gerais
        Route::get('index'  , ['as' => 'index', 'uses' => 'DefaultController@index']);

        Route::group(['prefix' => 'ouvidoria', 'as' => 'ouvidoria.'], function () {

            Route::group(['prefix' => 'demanda', 'as' => 'demanda.'], function () {
                Route::get('index', ['as' => 'index', 'uses' => 'Ouvidoria\DemandaController@index']);
                Route::get('grid', ['as' => 'grid', 'uses' => 'Ouvidoria\DemandaController@grid']);
                Route::get('create', ['as' => 'create', 'uses' => 'Ouvidoria\DemandaController@create']);
                Route::post('store', ['as' => 'store', 'uses' => 'Ouvidoria\DemandaController@store']);
                Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'Ouvidoria\DemandaController@edit']);
                Route::post('update/{id}', ['as' => 'update', 'uses' => 'Ouvidoria\DemandaController@update']);
                Route::get('delete/{id}', ['as' => 'edit', 'uses' => 'Ouvidoria\DemandaController@delete']);
                Route::get('registro/{id}', ['as' => 'registro', 'uses' => 'Ouvidoria\DemandaController@registro']);
            });

        });


        Route::group(['prefix' => 'biblioteca', 'as' => 'biblioteca.'], function () {
            
            Route::get('indexResponsavel', ['as' => 'indexResponsavel', 'uses' => 'Biblioteca\ResponsavelController@index']);
            Route::get('createResponsavel', ['as' => 'createResponsavel', 'uses' => 'Biblioteca\ResponsavelController@create']);
            Route::get('gridResponsavel', ['as' => 'gridResponsavel', 'uses' => 'Biblioteca\ResponsavelController@grid']);
            Route::get('editResponsavel/{id}', ['as' => 'editResponsavel', 'uses' => 'Biblioteca\ResponsavelController@edit']);
            Route::post('storeResponsavel', ['as' => 'storeResponsavel', 'uses' => 'Biblioteca\ResponsavelController@store']);
            Route::post('storeAjaxResponsavel', ['as' => 'storeAjaxResponsavel', 'uses' => 'Biblioteca\ResponsavelController@storeAjax']);
            Route::post('updateResponsavel/{id}', ['as' => 'updateResponsavel', 'uses' => 'Biblioteca\ResponsavelController@update']);
            Route::get('deleteResponsavel/{id}', ['as' => 'deleteResponsavel', 'uses' => 'Biblioteca\ResponsavelController@delete']);

            Route::get('indexEditora', ['as' => 'indexEditora', 'uses' => 'Biblioteca\EditoraController@index']);
            Route::get('createEditora', ['as' => 'createEditora', 'uses' => 'Biblioteca\EditoraController@create']);
            Route::get('gridEditora', ['as' => 'gridEditora', 'uses' => 'Biblioteca\EditoraController@grid']);
            Route::get('editEditora/{id}', ['as' => 'editEditora', 'uses' => 'Biblioteca\EditoraController@edit']);
            Route::post('storeEditora', ['as' => 'storeEditora', 'uses' => 'Biblioteca\EditoraController@store']);
            Route::post('storeAjaxEditora', ['as' => 'storeAjaxEditora', 'uses' => 'Biblioteca\EditoraController@storeAjax']);
            Route::post('updateEditora/{id}', ['as' => 'updateEditora', 'uses' => 'Biblioteca\EditoraController@update']);
            Route::get('deleteEditora/{id}', ['as' => 'deleteEditora', 'uses' => 'Biblioteca\EditoraController@delete']);
            Route::post('validarNome', ['as' => 'validarNome', 'uses' => 'Biblioteca\EditoraController@validarNome']);

            Route::get('indexAcervo', ['as' => 'indexAcervo', 'uses' => 'Biblioteca\ArcevoController@index']);
            Route::get('createAcervo', ['as' => 'createAcervo', 'uses' => 'Biblioteca\ArcevoController@create']);
            Route::get('gridAcervo', ['as' => 'gridAcervo', 'uses' => 'Biblioteca\ArcevoController@grid']);
            Route::get('editAcervo/{id}', ['as' => 'editAcervo', 'uses' => 'Biblioteca\ArcevoController@edit']);
            Route::post('storeAcervo', ['as' => 'storeAcervo', 'uses' => 'Biblioteca\ArcevoController@store']);
            Route::post('updateAcervo/{id}', ['as' => 'updateAcervo', 'uses' => 'Biblioteca\ArcevoController@update']);
            Route::get('deleteAcervo/{id}', ['as' => 'deleteAcervo', 'uses' => 'Biblioteca\ArcevoController@delete']);

            Route::get('indexExemplar', ['as' => 'indexExemplar', 'uses' => 'Biblioteca\ExemplarController@index']);
            Route::get('createExemplar', ['as' => 'createExemplar', 'uses' => 'Biblioteca\ExemplarController@create']);
            Route::get('gridExemplar', ['as' => 'gridExemplar', 'uses' => 'Biblioteca\ExemplarController@grid']);
            Route::get('editExemplar/{id}', ['as' => 'editExemplar', 'uses' => 'Biblioteca\ExemplarController@edit']);
            Route::post('storeExemplar', ['as' => 'storeExemplar', 'uses' => 'Biblioteca\ExemplarController@store']);
            Route::post('updateExemplar/{id}', ['as' => 'updateExemplar', 'uses' => 'Biblioteca\ExemplarController@update']);
            Route::get('deleteExemplar/{id}', ['as' => 'deleteExemplar', 'uses' => 'Biblioteca\ExemplarController@delete']);

            Route::get('dashboardBliblioteca', ['as' => 'dashboardBliblioteca', 'uses' => 'DashboardController@dashboardBliblioteca']);
            
            Route::get('indexConsulta', ['as' => 'indexConsulta', 'uses' => 'Biblioteca\ConsultaController@index']);
            Route::post('seachSimple', ['as' => 'seachSimple', 'uses' => 'Biblioteca\ConsultaController@seachSimple']);
            Route::get('seachSimplePage', ['as' => 'seachSimplePage', 'uses' => 'Biblioteca\ConsultaController@seachSimplePage']);
            Route::get('seachDetalhe/exemplar/{id}', ['as' => 'seachDetalhe', 'uses' => 'Biblioteca\ConsultaController@seachDetalhe']);
            Route::get('meusEmprestimos', ['as' => 'meusEmprestimos', 'uses' => 'Biblioteca\ConsultaController@meusEmprestimos']);

            Route::get('indexEmprestimo', ['as' => 'indexEmprestimo', 'uses' => 'Biblioteca\EmprestarController@index']);
            Route::get('gridEmprestimo', ['as' => 'gridEmprestimo', 'uses' => 'Biblioteca\EmprestarController@grid']);
            Route::post('storeEmprestimo', ['as' => 'storeEmprestimo', 'uses' => 'Biblioteca\EmprestarController@store']);
            Route::post('dataDevolucaoEmprestimo', ['as' => 'dataDevolucaoEmprestimo', 'uses' => 'Biblioteca\EmprestarController@dataDevolucao']);
            Route::get('viewDevolucaoEmprestimo', ['as' => 'viewDevolucaoEmprestimo', 'uses' => 'Biblioteca\EmprestarController@viewDevolucao']);
            Route::get('devolucaoEmprestimo', ['as' => 'devolucaoEmprestimo', 'uses' => 'Biblioteca\EmprestarController@gridDevolucao']);
            Route::get('confirmarDevolucao/{id}', ['as' => 'confirmarDevolucao', 'uses' => 'Biblioteca\EmprestarController@confirmarDevolucao']);
            Route::get('renovacao/{id}', ['as' => 'renovacao', 'uses' => 'Biblioteca\EmprestarController@renovacao']);
            
            Route::get('indexReserva', ['as' => 'indexReserva', 'uses' => 'Biblioteca\ReservaController@index']);
            Route::get('gridReserva', ['as' => 'gridReserva', 'uses' => 'Biblioteca\ReservaController@grid']);
            Route::post('storeReserva', ['as' => 'storeReserva', 'uses' => 'Biblioteca\ReservaController@store']);
            Route::get('reservados', ['as' => 'reservados', 'uses' => 'Biblioteca\ReservaController@reservados']);
            Route::get('gridReservados', ['as' => 'gridReservados', 'uses' => 'Biblioteca\ReservaController@gridReservados']);
            Route::post('saveEmprestimo', ['as' => 'saveEmprestimo', 'uses' => 'Biblioteca\ReservaController@saveEmprestimo']);

            Route::get('indexPessoa', ['as' => 'indexPessoa', 'uses' => 'Biblioteca\PessoaController@index']);
            Route::get('createPessoa', ['as' => 'createPessoa', 'uses' => 'Biblioteca\PessoaController@create']);
            Route::get('gridPessoa', ['as' => 'gridPessoa', 'uses' => 'Biblioteca\PessoaController@grid']);
            Route::get('editPessoa/{id}', ['as' => 'editPessoa', 'uses' => 'Biblioteca\PessoaController@edit']);
            Route::post('storePessoa', ['as' => 'storePessoa', 'uses' => 'Biblioteca\PessoaController@store']);
            Route::post('updatePessoa/{id}', ['as' => 'updatePessoa', 'uses' => 'Biblioteca\PessoaController@update']);
            Route::get('deletePessoa/{id}', ['as' => 'deletePessoa', 'uses' => 'Biblioteca\PessoaController@delete']);
            
        });

        //Rotas para componentes de segurança
        Route::group(['prefix' => 'portal', 'as' => 'portal.'], function () {
            Route::get('indexPortal', ['as' => 'indexPortal', 'uses' => 'Portal\PortalController@index']);
            Route::post('login', ['as' => 'login', 'uses' => 'Portal\PortalController@login']);
            Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'Portal\PortalController@Dashboard']);
            Route::get('academico', ['as' => 'academico', 'uses' => 'Portal\PortalController@Academico']);
            Route::get('financeiro', ['as' => 'financeiro', 'uses' => 'Portal\PortalController@Financeiro']);
            Route::get('secretaria', ['as' => 'secretaria', 'uses' => 'Portal\PortalController@Secretaria']);
            Route::get('disciplina', ['as' => 'disciplina', 'uses' => 'Portal\PortalController@Disciplina']);
            Route::get('avaliacao', ['as' => 'avaliacao', 'uses' => 'Portal\PortalController@Avaliacao']);
            Route::get('boleto', ['as' => 'boleto', 'uses' => 'Portal\PortalController@Boleto']);
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

    Route::get('indexConsulta', ['as' => 'indexConsulta', 'uses' => 'Biblioteca\ConsultaController@index']);
    Route::post('seachSimple', ['as' => 'seachSimple', 'uses' => 'Biblioteca\ConsultaController@seachSimple']);
    Route::get('seachSimplePage', ['as' => 'seachSimplePage', 'uses' => 'Biblioteca\ConsultaController@seachSimplePage']);
    Route::get('seachDetalhe/exemplar/{id}', ['as' => 'seachDetalhe', 'uses' => 'Biblioteca\ConsultaController@seachDetalhe']);
    Route::get('meusEmprestimos', ['as' => 'meusEmprestimos', 'uses' => 'Biblioteca\ConsultaController@meusEmprestimos']);

    //Ouvidoria
    Route::get('createPublico', ['as' => 'createPublico', 'uses' => 'Ouvidoria\DemandaController@createPublic']);
    Route::post('storePublico', ['as' => 'storePublico', 'uses' => 'Ouvidoria\DemandaController@storePublic']);
});