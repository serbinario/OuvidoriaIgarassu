<?php

namespace Seracademico\Services\Ouvidoria;

use Seracademico\Repositories\Ouvidoria\ComunidadeRepository;
use Seracademico\Entities\Ouvidoria\Comunidade;

class ComunidadeService
{
    /**
     * @var ComunidadeRepository
     */
    private $repository;

    /**
     * @param ComunidadeRepository $repository
     */
    public function __construct(ComunidadeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        #Recuperando o registro no banco de dados
        $comunidade = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$comunidade) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $comunidade;
    }

    /**
     * @param array $data
     * @return Comunidade
     * @throws \Exception
     */
    public function store(array $data) : Comunidade
    {
        #Salvando o registro pincipal
        $comunidade =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$comunidade) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $comunidade;
    }

    /**
     * @param array $data
     * @param int $id
     * @return Comunidade
     * @throws \Exception
     */
    public function update(array $data, int $id) : Comunidade
    {
        #Atualizando no banco de dados
        $comunidade = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$comunidade) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $comunidade;
    }

    /**
     * @param array $models
     * @return array
     */
    public function load(array $models) : array
    {
        #Declarando variáveis de uso
        $result    = [];
        $expressao = [];

        #Criando e executando as consultas
        foreach ($models as $model) {
            # separando as strings
            $explode   = explode("|", $model);

            # verificando a condição
            if(count($explode) > 1) {
                $model     = $explode[0];
                $expressao = explode(",", $explode[1]);
            }

            #qualificando o namespace
            $nameModel = "\\Seracademico\\Entities\\$model";

            if(count($expressao) > 1) {
                #Recuperando o registro e armazenando no array
                $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->lists('nome', 'id');
            } else {
                #Recuperando o registro e armazenando no array
                $result[strtolower($model)] = $nameModel::lists('nome', 'id');
            }

            # Limpando a expressão
            $expressao = [];
        }

        #retorno
        return $result;
    }
}