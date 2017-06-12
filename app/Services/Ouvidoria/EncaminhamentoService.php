<?php

namespace Seracademico\Services\Ouvidoria;

use Seracademico\Repositories\Ouvidoria\EncaminhamentoRepository;
use Seracademico\Repositories\Ouvidoria\DemandaRepository;
use Seracademico\Entities\Ouvidoria\Encaminhamento;
use Seracademico\Entities\Ouvidoria\Prioridade;
use Illuminate\Support\Facades\Auth;
use Seracademico\Services\Configuracao\ValidarDataDePrevisao;

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
    public function responder(array $data)
    {
        $id                 = isset($data['id']) ? $data['id'] : "";
        $resposta           = isset($data['resposta']) ? $data['resposta'] : "";
        $respostaOuvidor    = isset($data['resposta_ouvidor']) ? $data['resposta_ouvidor'] : "";
        $tipoResposta       = isset($data['tipo_resposta']) ? $data['tipo_resposta'] : "";

        //Pegando um objeto da data de solução
        $dataSolucao = \DateTime::createFromFormat('d/m/Y', $data['data']);
        $dataSolucao = $dataSolucao->format('Y-m-d');

        # Pegando a data atual
        $date  = new \DateTime('now');

        if($id && ($resposta || $respostaOuvidor)) {

            // Pegando o encaminhamento
            $encaminhamento = $this->find($id);

            // Valida se a data de solução está sendo maior que a data do encaminhamento
            if(strtotime($encaminhamento->data) >= strtotime($dataSolucao)) {
                return false;
            }

            # Validando se a resposta foi de uma secretaria ou da própria ouvidoria
            if($tipoResposta == '1') {
                $encaminhamento->resposta           = $resposta;
            } else {
                $encaminhamento->resposta_ouvidor   = $respostaOuvidor;
            }


            # Alterando os dados do encaminhamento como situação de respondida
            $encaminhamento->status_id              = 4;
            $encaminhamento->data_resposta          = $date->format('Y-m-d');
            $encaminhamento->resp_publica           = isset($data['resp_publica']) ? $data['resp_publica'] : '0';
            $encaminhamento->resp_ouvidor_publica   = isset($data['resp_ouvidor_publica']) ? $data['resp_ouvidor_publica'] : "0";

            # Setando o usuário se caso a resposta foi da secretaria
            if($tipoResposta == '1') {
                $encaminhamento->user_id = $this->user->id;
            }

            // Salvando o encaminhamento
            $encaminhamento->save();

            #Salvando o prazo de solução
            $prazo = \DB::table('prazo_solucao')->insert([
                'data' => $dataSolucao,
                'encaminhamento_id' => $encaminhamento->id
            ]);


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

        #alterando o status do encaminhamento anterior para fechado
        $encaminhamentoAnterior = $this->find($data['id']);
        $encaminhamentoAnterior->status_id = 3;
        $encaminhamentoAnterior->save();

        $prioridade = Prioridade::where('id', "=", $encaminhamentoAnterior->prioridade_id)->first();
        $previsao = ValidarDataDePrevisao::getResult($date, $prioridade->dias);

        # preenchendo os dados para o reecaminhamento
        $data['data'] = $dataAtual;
        $data['previsao'] = $previsao;
        $data['status_id'] = 7;
        $data['user_id'] = $this->user->id;
        $data['prioridade_id'] = $encaminhamentoAnterior->prioridade_id;

        #Salvando o registro principal
        $encaminhamento =  $this->repository->create($data);

        // Alterando a situação da demanda para reecaminhado
        $demanda = $this->demandaPepository->find($encaminhamento->demanda_id);
        $demanda->status_id = 7;
        $demanda->user_id = $this->user->id;
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
        $date->setTimezone( new \DateTimeZone('BRT') );
        $dataAtual = $date->format('Y-m-d');
        $this->anoAtual = $date->format('Y');

        #alterando o status do encaminhamento anterior para fechado
        if($data['id']) {

            $encaminhamentoAnterior = $this->find($data['id']);
            $encaminhamentoAnterior->status_id = 3;
            $encaminhamentoAnterior->save();

            $prioridade = Prioridade::where('id', "=", $encaminhamentoAnterior->prioridade_id)->first();

        } else {

            $prioridade = Prioridade::where('id', "=", $data['prioridade_id'])->first();


        }

        # Pegando a data de previsão
        $previsao = ValidarDataDePrevisao::getResult($date, $prioridade->dias);

        # preenchendo os dados para o reecaminhamento
        $data['data'] = $dataAtual;
        $data['previsao'] = $previsao;
        $data['status_id'] = 1;
        $data['user_id'] = $this->user->id;
        $data['prioridade_id'] = $prioridade->id;

        #Salvando o registro pincipal
        $encaminhamento =  $this->repository->create($data);

        // Alterando a situação da demanda para reecaminhado e editando algumas informações
        $demanda = $this->demandaPepository->find($encaminhamento->demanda_id);

        # Inserinfo o subassunto caso seja informádo no encaminhamento
        if (isset($data['subassunto_id'])) {
            $demanda->subassunto_id = $data['subassunto_id'];
        }

        // Verifica se ja houve algum ancaminhamento anterior, caso não é gerado um código para manifestação
        if(!$data['id']) {

            //recupera o maior código ja registrado
            $codigo = \DB::table('ouv_demanda')
                ->where('ouv_demanda.codigo', 'like', '%'.$this->anoAtual)
                ->max('codigo');

            // Gerando o código da manifestação
            $codigoMax = $codigo != null ? $codigoMax = $codigo + 1 : $codigoMax = "0001{$this->anoAtual}";
            $codigoAtual = $codigo != null ?  substr($codigoMax, 0, -4) + 1 : substr($codigoMax, 0, -4);
            $this->ultimoAno = substr($codigo, -4);

            #Setando o código na manifestação
            $demanda->codigo = $this->tratarCodigo($codigoAtual);
        }

        $demanda->status_id = 1;
        $demanda->user_id = $this->user->id;
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
     * @param $status_exter
     * @return array
     * @throws \Exception
     */
    public function finalizar($id, $status_externo_id = null)
    {
        #Recuperando o registro no banco de dados
        $encaminhamento = $this->repository->find($id);
        $encaminhamento->status_id = 6;
        $encaminhamento->save();

        $demanda = $this->demandaPepository->find($encaminhamento->demanda_id);
        $demanda->status_id = 6;
        $demanda->status_externo_id = $status_externo_id;
        $demanda->user_id   = $this->user->id;
        $demanda->save();

        // Pegando demandas está agrupada
        $demandaAgrupada = \DB::table('demandas_agrupadas')
            ->join('ouv_demanda as principal', 'principal.id', '=', 'demandas_agrupadas.demanda_principal_id')
            ->join('ouv_demanda as agrupada', 'agrupada.id', '=', 'demandas_agrupadas.demanda_agrupada_id')
            ->where('principal.id', '=',$demanda->id)
            ->select([
                    'demandas_agrupadas.demanda_agrupada_id',
                    'agrupada.n_protocolo',
                    'agrupada.tipo_resposta_id'
                ]
            )->get();

        // Percorre as demandas que estão agrupadas
        foreach ($demandaAgrupada as $value) {

            // Pegas a demanda agrupada
            $dm = $this->demandaPepository->with(['encaminhamento'])->find($value->demanda_agrupada_id);
            $dm->status_id = 6;
            $dm->user_id   = $this->user->id;
            $dm->save();

            // Valida se a demanda teve algum encaminhamento
            // Caso tenha é feita a edição do mesmo, caso não, é criado um encaminhamento para a demanda
            if($dm->encaminhamento) {
                $enc = $this->repository->find($dm->encaminhamento->id);
                $enc->resposta              = $encaminhamento->resposta;
                $enc->resposta_ouvidor      = $encaminhamento->resposta_ouvidor;
                $enc->resp_publica          = $encaminhamento->resp_publica;
                $enc->resp_ouvidor_publica  = $encaminhamento->resp_ouvidor_publica;
                $enc->status_id             = 6;
                $enc->user_id               = $encaminhamento->user_id;
                $enc->save();
            } else {
                $array = [];
                $array['resposta']              = $encaminhamento->resposta;
                $array['resposta_ouvidor']      = $encaminhamento->resposta_ouvidor;
                $array['resp_publica']          = $encaminhamento->resp_publica;
                $array['resp_ouvidor_publica']  = $encaminhamento->resp_ouvidor_publica;
                $array['status_id']             = 6;
                $array['data']                  = $encaminhamento->data;
                $array['previsao']              = $encaminhamento->previsao;
                $array['parecer']               = $encaminhamento->parecer;
                $array['destinatario_id']       = $encaminhamento->destinatario_id;
                $array['prioridade_id']         = $encaminhamento->prioridade_id;
                $array['demanda_id']            = $dm->id;
                $array['user_id']               = $encaminhamento->user_id;
                $array['data_recebimento']      = $encaminhamento->demanda_id;
                $array['data_resposta']         = $encaminhamento->user_id;

                $enc =  $this->repository->create($array);
            }

        }

        #Verificando se o registro foi encontrado
        if(!$encaminhamento || !$demanda) {
            throw new \Exception('Não fio possível finalizar a demanda!');
        }

        #retorno
        return ['demanda' => $demanda, 'encaminhamento' => $encaminhamento, 'demandasAgrupadas' => $demandaAgrupada];
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function prorrogarPrazo(array $data)
    {

        #alterando o status do encaminhamento para prorrogado
        $encaminhamento = $this->find($data['id']);

        #Pegando os dias de prioridade do encaminhamento
        $prioridade = Prioridade::where('id', "=", $encaminhamento->prioridade_id)->first();

        //Pegando um objeto da data de previsão para gerar uma nova data
        $dataPrevisao = \DateTime::createFromFormat('Y-m-d', $encaminhamento->previsao);

        # Pegando a data de previsão
        $previsao = ValidarDataDePrevisao::getResult($dataPrevisao, $prioridade->dias);

        #alterando a situação do encaminhamento de acordo com a manifestação
        $encaminhamento->status_prorrogacao = 1;
        $encaminhamento->previsao = $previsao;
        $encaminhamento->justificativa_prorrogacao = $data['justificativa'];
        $encaminhamento->save();

        #Verificando se foi criado no banco de dados
        if(!$encaminhamento) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $encaminhamento;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function prorrogarPrazoSolucao(array $data)
    {

        #alterando o status do encaminhamento para prorrogado
        $encaminhamento = $this->find($data['id']);

        //Pegando um objeto da data de previsão para gerar uma nova data
        $novoPrazo = \DateTime::createFromFormat('d/m/Y', $data['data']);
        $novoPrazo = $novoPrazo->format('Y-m-d');

        // Valida se a data de solução está sendo maior que a data do encaminhamento
        if(strtotime($encaminhamento->data) >= strtotime($novoPrazo)) {
            return false;
        }

        #Salvando o prazo de solução
        $prazo = \DB::table('prazo_solucao')->insert([
            'data' => $novoPrazo,
            'encaminhamento_id' => $encaminhamento->id,
            'status' => '1',
            'justificativa' => $data['justificativa']
        ]);

        #Verificando se foi criado no banco de dados
        if(!$prazo) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $prazo;
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

        // Pegando as repostas dos encaminhamentos passados
        $repostasPassadas = \DB::table('ouv_encaminhamento')
            ->where('ouv_encaminhamento.demanda_id', '=', $encaminhamento->demanda_id)
            ->whereNotIn('ouv_encaminhamento.id', [$id])
            ->select([
                'ouv_encaminhamento.resposta',
                'ouv_encaminhamento.resposta_ouvidor',
                \DB::raw('DATE_FORMAT(ouv_encaminhamento.data_resposta,"%d/%m/%Y") as data'),
            ])
            ->get();

        #Verificando se o registro foi encontrado
        if(!$encaminhamento || !$demanda) {
            throw new \Exception('Não fio possível visualizar a demanda!');
        }

        #retorno
        return $repostasPassadas;
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