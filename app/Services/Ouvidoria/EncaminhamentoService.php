<?php

namespace Seracademico\Services\Ouvidoria;

use Seracademico\Repositories\Ouvidoria\EncaminhamentoRepository;
use Seracademico\Repositories\Ouvidoria\DemandaRepository;
use Seracademico\Entities\Ouvidoria\Encaminhamento;
use Seracademico\Entities\Ouvidoria\Prioridade;
use Illuminate\Support\Facades\Auth;

class EncaminhamentoService
{
    /**
     * @var EncaminhamentoRepository
     */
    private $repository;

    /**
     * @var EncaminhamentoRepository
     */
    private $demandaPepository;

    /**
     * @var
     */
    private $user;

    /**
     * @param EncaminhamentoRepository $repository
     */
    public function __construct(EncaminhamentoRepository $repository,
                                DemandaRepository $demandaPepository)
    {
        $this->repository = $repository;
        $this->demandaPepository = $demandaPepository;
        $this->user = Auth::user();
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
            $encaminhamento->user_id = $this->user->id;
            $encaminhamento->save();

            // Alterando a situação da demanda para concluído
            $demanda = $this->demandaPepository->find($encaminhamento->demanda_id);
            $demanda->status_id = 4;
            $demanda->save();

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
        $data['user_id'] = $this->user->id;

        #Salvando o registro pincipal
        $encaminhamento =  $this->repository->create($data);

        #alterando o status do encaminhamento anterior para fechado
        $encaminhamentoAnterior = $this->find($data['id']);
        $encaminhamentoAnterior->status_id = 3;
        $encaminhamentoAnterior->save();

        // Alterando a situação da demanda para reecaminhado
        $demanda = $this->demandaPepository->find($encaminhamento->demanda_id);
        $demanda->status_id = 7;
        $demanda->save();

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
        $data['user_id'] = $this->user->id;

        #Salvando o registro pincipal
        $encaminhamento =  $this->repository->create($data);

        #alterando o status do encaminhamento anterior para fechado
        $encaminhamentoAnterior = $this->find($data['id']);
        $encaminhamentoAnterior->status_id = 3;
        $encaminhamentoAnterior->save();

        // Alterando a situação da demanda para reecaminhado
        $demanda = $this->demandaPepository->find($encaminhamento->demanda_id);
        $demanda->status_id = 1;
        $demanda->save();

        #Verificando se foi criado no banco de dados
        if(!$encaminhamento) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $encaminhamento;
    }

    /**
 * @param $id
 * @return mixed
 * @throws \Exception
 */
    public function finalizar($id)
    {
        #Recuperando o registro no banco de dados
        $encaminhamento = $this->repository->find($id);
        $encaminhamento->status_id = 6;
        $encaminhamento->user_id = $this->user->id;
        $encaminhamento->save();

        $demanda = $this->demandaPepository->find($encaminhamento->demanda_id);
        $demanda->status_id = 6;
        $demanda->save();

        #Verificando se o registro foi encontrado
        if(!$encaminhamento || !$demanda) {
            throw new \Exception('Não fio possível finalizar a demanda!');
        }

        #retorno
        return $encaminhamento;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function visualizar($id)
    {
        $date  = new \DateTime('now');

        #Recuperando o registro no banco de dados e marcando como em análise e inserindo data de recebimento
        $encaminhamento = $this->repository->find($id);
        $demanda = $this->demandaPepository->find($encaminhamento->demanda_id);

        if($encaminhamento->status_id == '1' || $encaminhamento->status_id == '7') {
            $encaminhamento->data_recebimento = $date->format('Y-m-d');
            $encaminhamento->status_id = 2; // Alterando o status do encaminhamento para em análise
            $demanda->status_id = 2; // Alterando o status da demanda para em análise

            $encaminhamento->save();
            $demanda->save();
        }
        
        #Verificando se o registro foi encontrado
        if(!$encaminhamento || !$demanda) {
            throw new \Exception('Não fio possível visualizar a demanda!');
        }

        #retorno
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