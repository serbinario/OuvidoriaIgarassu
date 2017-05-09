<?php

namespace Seracademico\Services;

use Seracademico\Repositories\Ouvidoria\SecretariaRepository;
use Seracademico\Entities\Ouvidoria\Secretaria;
//use Carbon\Carbon;

class SecretariaService
{
    /**
     * @var SecretariaRepository
     */
    private $repository;

    /**
     * @param SecretariaRepository $repository
     */
    public function __construct(SecretariaRepository $repository)
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
        $secretaria = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$secretaria) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $secretaria;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Secretaria
    {
        #Salvando o registro pincipal
        $secretaria =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$secretaria) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $secretaria;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Secretaria
    {
        #Atualizando no banco de dados
        $secretaria = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$secretaria) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $secretaria;
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