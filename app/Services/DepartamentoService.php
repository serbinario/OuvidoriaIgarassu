<?php

namespace Seracademico\Services;

use Seracademico\Repositories\Ouvidoria\DepartamentoRepository;
use Seracademico\Entities\Ouvidoria\Destinatario;
//use Carbon\Carbon;

class DepartamentoService
{
    /**
     * @var DepartamentoRepository
     */
    private $repository;

    /**
     * @param DepartamentoRepository $repository
     */
    public function __construct(DepartamentoRepository $repository)
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
        $departamento = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$departamento) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $departamento;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Destinatario
    {
        #Salvando o registro pincipal
        $departamento =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$departamento) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $departamento;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Destinatario
    {
        #Atualizando no banco de dados
        $departamento = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$departamento) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $departamento;
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

    /**
     * @param array $data
     * @return mixed
     */
    public function tratamentoDatas(array &$data) : array
    {
         #tratando as datas
         //$data[''] = $data[''] ? Carbon::createFromFormat("d/m/Y", $data['']) : "";

         #retorno
         return $data;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function destroy(int $id)
    {
        #deletando o curso
        $result = $this->repository->delete($id);

        # Verificando se a execução foi bem sucessida
        if(!$result) {
            throw new \Exception('Ocorreu um erro ao tentar remover o curso!');
        }

        #retorno
        return true;
    }
}