<?php

namespace Seracademico\Services\Ouvidoria;

use Seracademico\Repositories\Ouvidoria\EncaminhamentoRepository;
use Seracademico\Entities\Ouvidoria\Encaminhamento;
use Seracademico\Entities\Ouvidoria\Prioridade;
//use Carbon\Carbon;

class EncaminhamentoService
{
    /**
     * @var EncaminhamentoRepository
     */
    private $repository;

    /**
     * @param EncaminhamentoRepository $repository
     */
    public function __construct(EncaminhamentoRepository $repository)
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
        
        $relacionamentos = [
            'destinatario.area',
            'prioridade',
            'status',
            'demanda'
        ];
        
        #Recuperando o registro no banco de dados
        $encaminhamento = $this->repository->with($relacionamentos)->find($id);

        #Verificando se o registro foi encontrado
        if(!$encaminhamento) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $encaminhamento;
    }

    /**
     * @param array $data
     * @return array
     */
    public function responder(array $data) : Encaminhamento
    {
        $id         = isset($data['id']) ? $data['id'] : "";
        $Resposta   = isset($data['resposta']) ? $data['resposta'] : "";

        $date  = new \DateTime('now');

        if($id && $Resposta) {
            $encaminhamento = $this->find($id);
            $encaminhamento->resposta = $Resposta;
            $encaminhamento->status_id = 4;
            $encaminhamento->data_resposta = $date->format('Y-m-d');
            $encaminhamento->save();

            #Retorno
            return $encaminhamento;
        } else {
            throw new \Exception('Ocorreu um erro ao responder o encaminhamento!');
        }
        
    }

    /**
     * @param array $data
     * @return array
     */
    public function reencaminarStore(array $data) : Encaminhamento
    {
        $date  = new \DateTime('now');
        $dataAtual = $date->format('Y-m-d');

        $prioridade = Prioridade::where('id', "=", $data['prioridade_id'])->first();
        $previsao = $date->add(new \DateInterval("P{$prioridade->dias}D"));

        # preenchendo os dados para o reecaminhamento
        $data['data'] = $dataAtual;
        $data['previsao'] = $previsao->format('Y-m-d');
        $data['status_id'] = 7;

        #Salvando o registro pincipal
        $encaminhamento =  $this->repository->create($data);

        #alterando o status do encaminhamento anterior para fechado
        $encaminhamentoAnterior = $this->find($data['id']);
        $encaminhamentoAnterior->status_id = 3;
        $encaminhamentoAnterior->save();

        #Verificando se foi criado no banco de dados
        if(!$encaminhamento) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $encaminhamento;
    }

    /**
     * @param array $data
     * @return array
     */
    public function encaminharStore(array $data) : Encaminhamento
    {
        $date  = new \DateTime('now');
        $dataAtual = $date->format('Y-m-d');

        $prioridade = Prioridade::where('id', "=", $data['prioridade_id'])->first();
        $previsao = $date->add(new \DateInterval("P{$prioridade->dias}D"));

        # preenchendo os dados para o reecaminhamento
        $data['data'] = $dataAtual;
        $data['previsao'] = $previsao->format('Y-m-d');
        $data['status_id'] = 1;

        #Salvando o registro pincipal
        $encaminhamento =  $this->repository->create($data);

        #alterando o status do encaminhamento anterior para fechado
        $encaminhamentoAnterior = $this->find($data['id']);
        $encaminhamentoAnterior->status_id = 3;
        $encaminhamentoAnterior->save();

        #Verificando se foi criado no banco de dados
        if(!$encaminhamento) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $encaminhamento;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Encaminhamento
    {
        #Atualizando no banco de dados
        $encaminhamento = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$encaminhamento) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $encaminhamento;
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

}