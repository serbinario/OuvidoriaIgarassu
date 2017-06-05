<?php

namespace Seracademico\Http\Controllers\Configuracao;

use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Repositories\ConfiguracaoGeralRepository;
use Seracademico\Services\Configuracao\ConfiguracaoGeralService;

/**
 * Class ConfiguracaoGeralController
 * @package Seracademico\Http\Controllers\Configuracao
 *
 * @Autor Andrey Fernandes Bernardo da Silva
 */
class ConfiguracaoGeralController extends Controller
{
    /**
     * @var ConfiguracaoGeralRepository
     */
    private $repository;

    /**
     * @var ConfiguracaoGeralService
     */
    private $service;

    /**
     * ConfiguracaoGeralController constructor.
     * @param ConfiguracaoGeralRepository $repository
     * @param ConfiguracaoGeralService $service
     */
    public function __construct(ConfiguracaoGeralRepository $repository,
                                ConfiguracaoGeralService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Método controlador responsável por retornar
     * a view de edição da configuração geral.
     */
    public function edit()
    {
        try {
            $configuracaoGeral = $this->service->findConfiguracaoGeral();

            return view("configuracao.configuracaoGeral.edit", compact('configuracaoGeral'));
        } catch (\Throwable $e) { dd($e);
            return redirect()->back()->withErrors($e->getMessage());
        }
    }


    /**
     * Método controlador responsável por executar os processos
     * para atualização dos dados da cofiguração geral no banco de dados.
     *
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $this->service->update($request->all(), $id);

            return redirect()->back()->with("message", "Dados alterados com sucesso!");
        }catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag());
        } catch (\Throwable $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

}
