<?php

namespace Seracademico\Services;

use Seracademico\Repositories\TemplateRepository;
use Seracademico\Entities\Template;

class TemplateService
{
    /**
     * @var TemplateRepository
     */
    private $repository;

    /**
     * @param TemplateRepository $repository
     */
    public function __construct(TemplateRepository $repository)
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
        $retorno = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$retorno) {
            throw new \Exception('não encontrada!');
        }

        #retorno
        return $retorno;
    }

    /**
     * @param array $data
     * @return Template
     * @throws \Exception
     */
    public function store(array $data) : Template
    {

        // Pegando o conteúdo do arquivo importado transformando em string para insert no banco de dados
        $data['html'] = isset($data['file']) ? file_get_contents($data['file']->getPathname()) : "";

        #Salvando o registro pincipal
        $retorno =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$retorno) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $retorno;
    }

    /**
     * @param array $data
     * @param int $id
     * @return Template
     * @throws \Exception
     */
    public function update(array $data, int $id) : Template
    {
        #Atualizando no banco de dados
        $retorno = $this->repository->update($data, $id);

        #Verificando se foi atualizado no banco de dados
        if(!$retorno) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $retorno;
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
        $retorno = $this->repository->delete($id);

        # Verificando se a execução foi bem sucessida
        if(!$retorno) {
            throw new \Exception('Ocorreu um erro ao tentar remover o curso!');
        }

        #retorno
        return true;
    }
}