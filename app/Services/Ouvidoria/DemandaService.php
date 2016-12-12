<?php

namespace Seracademico\Services\Ouvidoria;

use Seracademico\Entities\Ouvidoria\Prioridade;
use Seracademico\Repositories\Ouvidoria\DemandaRepository;
use Seracademico\Entities\Ouvidoria\Demanda;
use Seracademico\Repositories\Ouvidoria\EncaminhamentoRepository;

//use Carbon\Carbon;

class DemandaService
{
    /**
     * @var DemandaRepository
     */
    private $repository;

    /**
     * @var EncaminhamentoRepository
     */
    private $encaminhamentoRepository;

    /**
     * @var
     */
    private $anoAtual;

    /**
     * @var
     */
    private $ultimoAno;

    /**
     * @var
     */
    private $tombo;

    /**
     * @param DemandaRepository $repository
     */
    public function __construct(DemandaRepository $repository, EncaminhamentoRepository $encaminhamentoRepository)
    {
        $this->repository = $repository;
        $this->encaminhamentoRepository = $encaminhamentoRepository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {

        $relacionamentos = [
            'sexo',
            'sigilo',
            'anonimo',
            'informacao',
            'area',
            'exclusividadeSUS',
            'idade',
            'escolaridade',
            'tipoDemanda',
            'subassunto.assunto',
            'encaminhamento'
        ];

        #Recuperando o registro no banco de dados
        $demanda = $this->repository->with($relacionamentos)->find($id);

        #Verificando se o registro foi encontrado
        if(!$demanda) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $demanda;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function all()
    {

        $relacionamentos = [
            'sexo',
            'sigilo',
            'anonimo',
            'informacao',
            'area',
            'exclusividadeSUS',
            'idade',
            'escolaridade',
            'tipoDemanda',
            'subassunto.assunto',
            'encaminhamento'
        ];

        #Recuperando o registro no banco de dados
        $demanda = $this->repository->with($relacionamentos)->all();

        #Verificando se o registro foi encontrado
        if(!$demanda) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $demanda;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Demanda
    {

        $data = $this->tratamentoCampos($data);

        //recupera o maior código ja registrado
        $codigo = \DB::table('ouv_demanda')->max('codigo');
        $dataObj  = new \DateTime('now');
        $this->anoAtual = $dataObj->format('Y');
        $codigoMax = $codigo != null ? $codigoMax = $codigo + 1 : $codigoMax = "0001{$this->anoAtual}";
        $codigoAtual = $codigo != null ?  substr($codigoMax, 0, -4) + 1 : substr($codigoMax, 0, -4);
        $this->ultimoAno = substr($codigo, -4);

        $data['data'] = $dataObj->format('Y-m-d');
        $data['codigo'] = $this->tratarCodigo($codigoAtual);

        #Salvando o registro pincipal
        $demanda =  $this->repository->create($data);

        #### Encaminhamento ###
        if($data['encaminhamento']['prioridade_id'] && $data['encaminhamento']['destinatario_id']) {

            $prioridade = Prioridade::where('id', "=", $data['encaminhamento']['prioridade_id'])->first();
            $previsao = $dataObj->add(new \DateInterval("P{$prioridade->dias}D"));

            $data['encaminhamento']['previsao'] = $previsao->format('Y-m-d');
            $data['encaminhamento']['data'] = $data['data'];
            $data['encaminhamento']['demanda_id'] = $demanda->id;

            $encaminhamento = $this->encaminhamentoRepository->create($data['encaminhamento']);
        }

        
        #Verificando se foi criado no banco de dados
        if(!$demanda) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $demanda;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Demanda
    {
        $data = $this->tratamentoCampos($data);

        #Atualizando no banco de dados
        $demanda = $this->repository->update($data, $id);

        $enc = $this->encaminhamentoRepository->findWhere(['demanda_id' => $demanda->id]);

        if(count($enc) > 0) {
            $encaminhamento = $this->encaminhamentoRepository->update($data['encaminhamento'], $enc[0]->id);
        } else if (count($enc) <= 0 && $data['encaminhamento']['prioridade_id'] != ""
            && $data['encaminhamento']['destinatario_id'] != "") {

            $dataObj  = new \DateTime('now');
            $date     = $dataObj->format('Y-m-d');

            $prioridade = Prioridade::where('id', "=", $data['encaminhamento']['prioridade_id'])->first();
            $previsao = $dataObj->add(new \DateInterval("P{$prioridade->dias}D"));

            $data['encaminhamento']['previsao'] = $previsao->format('Y-m-d');
            $data['encaminhamento']['data'] = $date;
            $data['encaminhamento']['demanda_id'] = $demanda->id;

            $encaminhamento = $this->encaminhamentoRepository->create($data['encaminhamento']);
        }


        #Verificando se foi atualizado no banco de dados
        if(!$demanda) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $demanda;
    }

    /**
     * @param array $models
     * @return array
     */
    public function load(array $models, $ajax = false) : array
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
            #Verificando se existe sobrescrita do nome do model
            //$model     = isset($expressao[2]) ? $expressao[2] : $model;
            if ($ajax) {
                if(count($expressao) > 0) {
                    switch (count($expressao)) {
                        case 1 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}()->orderBy('nome', 'asc')->get(['nome', 'id']);
                            break;
                        case 2 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->orderBy('nome', 'asc')->get(['nome', 'id']);
                            break;
                        case 3 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1], $expressao[2])->orderBy('nome', 'asc')->get(['nome', 'id']);
                            break;
                    }
                } else {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::orderBy('nome', 'asc')->get(['nome', 'id']);
                }
            } else {
                if(count($expressao) > 1) {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->orderBy('nome', 'asc')->lists('nome', 'id');
                } else {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::orderBy('nome', 'asc')->lists('nome', 'id');
                }
            }
            # Limpando a expressão
            $expressao = [];
        }
        #retorno
        return $result;
    }

    /**
     * @param array $models
     * @return array
     */
    public function load2(array $models, $ajax = false) : array
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
            #Verificando se existe sobrescrita do nome do model
            //$model     = isset($expressao[2]) ? $expressao[2] : $model;
            if ($ajax) {
                if(count($expressao) > 0) {
                    switch (count($expressao)) {
                        case 1 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}()->get(['nome', 'id']);
                            break;
                        case 2 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->get(['nome', 'id']);
                            break;
                        case 3 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1], $expressao[2])->get(['nome', 'id']);
                            break;
                    }
                } else {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::orderBy('nome', 'asc')->get(['nome', 'id']);
                }
            } else {
                if(count($expressao) > 1) {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->lists('nome', 'id');
                } else {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::lists('nome', 'id');
                }
            }
            # Limpando a expressão
            $expressao = [];
        }
        #retorno
        return $result;
    }

    /**
     * @param array $data
     * @return array
     */
    public function tratamentoCampos(array &$data)
    {
        # Tratamento de campos de chaves estrangeira
        foreach ($data as $key => $value) {
            $explodeKey = explode("_", $key);

            if ($explodeKey[count($explodeKey) -1] == "id" && $value == null ) {
                unset($data[$key]);
            }
        }
        #Retorno
        return $data;
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
     * @param $codigo
     * @return string
     */
    public function tratarCodigo($codigo)
    {
        if($codigo <= 1 || $this->anoAtual != $this->ultimoAno) {
            $newCod2  = '1'.$this->anoAtual;
        } else {
            $newCod = $codigo;
            $newCod2 = $newCod.$this->anoAtual;
        }

        $newCod2 = str_pad($newCod2,8,"0",STR_PAD_LEFT);

        return $newCod2;
    }

}