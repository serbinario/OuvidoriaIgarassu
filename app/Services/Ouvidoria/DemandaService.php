<?php

namespace Seracademico\Services\Ouvidoria;

use Seracademico\Entities\Ouvidoria\Prioridade;
use Seracademico\Repositories\Ouvidoria\DemandaRepository;
use Seracademico\Entities\Ouvidoria\Demanda;
use Seracademico\Repositories\Ouvidoria\EncaminhamentoRepository;
use Illuminate\Support\Facades\Auth;
use Seracademico\Services\Configuracao\ValidarDataDePrevisao;
use Seracademico\Uteis\SerbinarioGerarCodigoSenha;
use Seracademico\Uteis\SerbinarioSendEmail;
use Seracademico\Services\Configuracao\ConfiguracaoGeralService;

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
    private $configuracaoGeralService;

    /**
     * @param DemandaRepository $repository
     */
    public function __construct(DemandaRepository $repository,
                                EncaminhamentoRepository $encaminhamentoRepository,
                                ConfiguracaoGeralService $configuracaoGeralService)
    {
        $this->repository = $repository;
        $this->encaminhamentoRepository = $encaminhamentoRepository;
        $this->configuracaoGeralService = $configuracaoGeralService;
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
            'subassunto.assunto.secretaria',
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
            'encaminhamento',
            'melhoria.secretaria'
        ];

        #Recuperando o registro no banco de dados
        $demanda = $this->repository->with($relacionamentos)->wh();

        #Verificando se o registro foi encontrado
        if(!$demanda) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $demanda;
    }

    /**
     * @param array $data
     * @return Demanda
     * @throws \Exception
     */
    public function store(array $data) : Demanda
    {
        // Pegando o usuário
        $user = Auth::user();

        $data = $this->tratamentoCampos($data);
        $data['encaminhamento'] = $this->tratamentoCampos($data['encaminhamento']);

        $dataObj  = new \DateTime('now');
        $dataObj->setTimezone( new \DateTimeZone('BRT') );
        $dataAtual = $dataObj->format('Y-m-d');
        $this->anoAtual = $dataObj->format('Y');

        // Complementando os dados da demanda
        $data['data'] = $dataObj->format('Y-m-d H:i:s');
        $data['n_protocolo'] = SerbinarioGerarCodigoSenha::gerarProtocolo();
        $data['user_id'] = $user ? $user->id : null;
        $data['status_id'] = '5';
        $data['ouvidoria_id'] = $user->ouvidoria_id;

        #Salvando o registro pincipal
        $demanda =  $this->repository->create($data);
        $encaminhamento = null;


        #### Encaminhamento ###
        if(isset($data['encaminhamento'])
            && (isset($data['encaminhamento']['prioridade_id']) && $data['encaminhamento']['prioridade_id'])
            && $data['secretaria']) {


            $prioridade = Prioridade::where('id', "=", $data['encaminhamento']['prioridade_id'])->first();
            $previsao = ValidarDataDePrevisao::getResult($dataObj, $prioridade->dias);

            $data['encaminhamento']['previsao']   = $previsao;
            $data['encaminhamento']['data']       = $data['data'];
            $data['encaminhamento']['demanda_id'] = $demanda->id;
            $data['encaminhamento']['status_id']  = '1';
            $data['encaminhamento']['user_id']    = $user->id;

            // Validando se não foi encaminhado para um departamento, sendo no caso registrado apenas para secretaria
            if(!isset($data['destinatario_id'])) {
                $data['encaminhamento']['secretaria_id'] = $data['secretaria'];
            }

            $encaminhamento = $this->encaminhamentoRepository->create($data['encaminhamento']);

            //recupera o maior código ja registrado
            $codigo = \DB::table('ouv_demanda')
                ->where('ouv_demanda.codigo', 'like', '%' . $this->anoAtual)
                ->max('codigo');

            // Gerando o código da manifestação
            $codigoMax = $codigo != null ? $codigoMax = $codigo + 1 : $codigoMax = "0001{$this->anoAtual}";
            $codigoAtual = $codigo != null ?  substr($codigoMax, 0, -4) + 1 : substr($codigoMax, 0, -4);
            $this->ultimoAno = substr($codigo, -4);

            // Pegando a demanda atual
            $demanda =  $this->repository->find($demanda->id);
            $demanda->status_id = '1'; # Mudando o status para encaminhado
            $demanda->codigo = $this->tratarCodigo($codigoAtual); #Setando o código na manifestação

            if(isset($data['subassunto_id'])) {
                $demanda->subassunto_id = $data['subassunto_id'];
            }

            $demanda->save();

        }
        
        #Verificando se foi criado no banco de dados
        if(!$demanda) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        $configuracaoGeral = $this->configuracaoGeralService->findConfiguracaoGeral();

        # Envio de email de confirmação de cadastro
        if($demanda->email) {

            SerbinarioSendEmail::enviarEmailCom("emails.paginaDeConfirmacaoDeCadastro",
                compact("demanda", 'configuracaoGeral'), [
                    "destinatario" => $demanda->email,
                    "assunto" => "Registro da Manifestação"
                ]);
        }

        #Retorno
        return $demanda;
    }

    /**
     * @param array $data
     * @param int $id
     * @return Demanda
     * @throws \Exception
     */
    public function update(array $data, int $id) : Demanda
    {

        // Pegando o usuário
        $user = Auth::user();
        
        $data = $this->tratamentoCampos($data);

        // Atualiza o parecer do último encaminhamento
        if(isset($data['id_encaminhamento'])) {
            $encaminhamento = \DB::table('ouv_encaminhamento')
                ->where('id', $data['id_encaminhamento'])
                ->update(['parecer' => $data['encaminhamento']['parecer']]);
        }

        #Atualizando no banco de dados
        $data['user_id'] = $user->id;
        $demanda = $this->repository->update($data, $id);

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
         $data['data_da_ocorrencia'] = $data['data_da_ocorrencia'] ? \DateTime::createFromFormat("d/m/Y", $data['data_da_ocorrencia']) : "";

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

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function arquivar(int $id)
    {
        #arquivando a demanda o curso
        $result = $this->repository->find($id);
        $result->arquivada = '1';
        $result->data_arquivamento = date('Y-m-d');

        $result->save();

        # Verificando se a execução foi bem sucessida
        if(!$result) {
            throw new \Exception('Ocorreu um erro ao tentar remover o curso!');
        }

        #retorno
        return true;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function detalheDaDemanda($protocolo)
    {
        $demanda = \DB::table('ouv_demanda')
            ->leftJoin(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento 
                        where encaminhamento.demanda_id = ouv_demanda.id AND encaminhamento.status_id IN (1,7,2,4,6) ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            })
            ->leftJoin(\DB::raw('ouv_prazo_solucao'), function ($join) {
                $join->on(
                    'ouv_prazo_solucao.id', '=',
                    \DB::raw("(SELECT ouv_prazo_solucao.id FROM ouv_prazo_solucao
                        where ouv_prazo_solucao.encaminhamento_id = ouv_encaminhamento.id ORDER BY ouv_prazo_solucao.id DESC LIMIT 1)")
                );
            })
            ->leftJoin('gen_departamento', 'gen_departamento.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->leftJoin('gen_secretaria', 'gen_secretaria.id', '=', 'gen_departamento.area_id')
            ->leftJoin('gen_secretaria as secretaria_dm', 'secretaria_dm.id', '=', 'ouv_encaminhamento.secretaria_id')
            ->join('ouv_informacao', 'ouv_informacao.id', '=', 'ouv_demanda.informacao_id')
            ->leftJoin('ouv_comunidade', 'ouv_comunidade.id', '=', 'ouv_demanda.comunidade_id')
            ->leftJoin('ouv_subassunto', 'ouv_subassunto.id', '=', 'ouv_demanda.subassunto_id')
            ->leftJoin('ouv_assunto', 'ouv_assunto.id', '=', 'ouv_subassunto.assunto_id')
            ->leftJoin('ouv_idade', 'ouv_idade.id', '=', 'ouv_demanda.idade_id')
            ->leftJoin('gen_sexo', 'gen_sexo.id', '=', 'ouv_demanda.sexos_id')
            ->leftJoin('gen_escolaridade', 'gen_escolaridade.id', '=', 'ouv_demanda.escolaridade_id')
            ->leftJoin('ouv_tipo_demanda', 'ouv_tipo_demanda.id', '=', 'ouv_demanda.tipo_demanda_id')
            ->join('ouv_sigilo', 'ouv_sigilo.id', '=', 'ouv_demanda.sigilo_id')
            ->leftJoin('ouv_anonimo', 'ouv_anonimo.id', '=', 'ouv_demanda.anonimo_id')
            ->leftJoin('ouv_tipo_resposta', 'ouv_tipo_resposta.id', '=', 'ouv_demanda.tipo_resposta_id')
            ->leftJoin('ouv_pessoa', 'ouv_pessoa.id', '=', 'ouv_demanda.pessoa_id')
            ->leftJoin('ouv_status', 'ouv_status.id', '=', 'ouv_demanda.status_id')
            ->leftJoin('ouv_status_externo', 'ouv_status_externo.id', '=', 'ouv_demanda.status_externo_id')
            ->where('ouv_demanda.n_protocolo', '=', $protocolo)
            ->select([
                'ouv_encaminhamento.id as encaminhamento_id',
                \DB::raw('CONCAT (SUBSTRING(ouv_demanda.codigo, 4, 4), "/", SUBSTRING(ouv_demanda.codigo, -4, 4)) as codigo'),
                \DB::raw('DATE_FORMAT(ouv_encaminhamento.data,"%d/%m/%Y") as data'),
                'gen_departamento.nome as destino',
                \DB::raw('IF(gen_secretaria.nome != "", gen_secretaria.nome, secretaria_dm.nome) as area'),
                \DB::raw('DATE_FORMAT(ouv_encaminhamento.previsao,"%d/%m/%Y") as previsao'),
                \DB::raw('DATE_FORMAT(ouv_prazo_solucao.data,"%d/%m/%Y") as prazo_solucao'),
                \DB::raw('DATE_FORMAT(ouv_demanda.data_arquivamento,"%d/%m/%Y") as data_arquivamento'),
                'ouv_demanda.arquivada',
                'ouv_informacao.nome as informacao',
                'ouv_assunto.nome as assunto',
                'ouv_subassunto.nome as subassunto',
                'ouv_demanda.nome as nome',
                'ouv_comunidade.nome as comunidade',
                'ouv_demanda.endereco',
                'ouv_demanda.numero_end',
                'ouv_demanda.fone',
                'ouv_demanda.email',
                'ouv_demanda.relato',
                'ouv_demanda.obs',
                'ouv_demanda.cpf',
                'ouv_demanda.id as demanda_id',
                'ouv_pessoa.nome as perfil',
                'ouv_encaminhamento.resposta',
                'ouv_encaminhamento.resposta_ouvidor',
                'ouv_encaminhamento.resp_publica',
                'ouv_encaminhamento.resp_ouvidor_publica',
                'ouv_encaminhamento.parecer',
                'ouv_sigilo.nome as sigilo',
                'ouv_sigilo.id as sigilo_id',
                'ouv_anonimo.nome as anonimo',
                'ouv_anonimo.id as anonimo_id',
                'ouv_tipo_resposta.nome as tipo_resposta',
                'ouv_idade.nome as idade',
                'gen_sexo.nome as sexo',
                'gen_escolaridade.nome as escolaridade',
                'ouv_demanda.exclusividade_sus_id',
                'ouv_tipo_demanda.nome as tipo_demanda',
                \DB::raw('DATE_FORMAT(ouv_demanda.data,"%d/%m/%Y") as data_demanda'),
                'ouv_demanda.hora_da_ocorrencia',
                'ouv_status.nome as status',
                'ouv_status.id as status_id',
                 'ouv_demanda.n_protocolo',
                'ouv_status_externo.nome as status_externo'
            ])->first();

        return $demanda;
    }

}