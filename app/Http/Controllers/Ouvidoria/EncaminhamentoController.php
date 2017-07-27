<?php

namespace Seracademico\Http\Controllers\Ouvidoria;

use Illuminate\Http\Request;

use Mail;
use Mockery\Exception;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Seracademico\Services\Ouvidoria\EncaminhamentoService;
use Seracademico\Repositories\Ouvidoria\EncaminhamentoRepository;
use Seracademico\Uteis\SerbinarioAlertaDemanda;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\EncaminhamentoValidator;
use Seracademico\Uteis\SerbinarioSendEmail;

class EncaminhamentoController extends Controller
{
    /**
     * @var EncaminhamentoService
     */
    private $service;

    /**
     * @var EncaminhamentoRepository
     */
    private $repository;

    /**
     * @var EncaminhamentoValidator
     */
    private $validator;

    /**
     * @var
     */
    private $user;

    /**
    * @var array
    */
    private $loadFields = [
        'Ouvidoria\Secretaria',
        'Ouvidoria\Status',
        'Ouvidoria\Prioridade',
        'Ouvidoria\Destinatario',
        'Ouvidoria\StatusExterno'
    ];

    /**
     * EncaminhamentoController constructor.
     * @param EncaminhamentoService $service
     * @param EncaminhamentoValidator $validator
     * @param EncaminhamentoRepository $repository
     */
    public function __construct(EncaminhamentoService $service,
                                EncaminhamentoValidator $validator,
                                EncaminhamentoRepository $repository)
    {
        $this->service   =  $service;
        $this->validator =  $validator;
        $this->repository =  $repository;
        $this->user = Auth::user();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function encaminhados(Request $request)
    {
        //Pega o status por acesso a página via get
        $status = $request->has('status') ? $request->get('status') : "0";

        $usuarios = \DB::table('users')->select(['name', 'id'])->get();
        
        return view('encaminhamento.encaminhados', compact('usuarios', 'status'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detalheParaAnaliseDoEncaminhamento($id)
    {
        $respostasPassadas = $this->service->visualizar($id);

        $detalheEncaminhamento = $this->queryParaDetalheEncaminhamento($id);
        $loadFields = $this->service->load($this->loadFields);

        $encaminhamentoAnterior =  \DB::table('ouv_encaminhamento')
            ->leftJoin(\DB::raw('prazo_solucao'), function ($join) {
                $join->on(
                    'prazo_solucao.id', '=',
                    \DB::raw("(SELECT prazo_solucao.id FROM prazo_solucao
                        where prazo_solucao.encaminhamento_id = ouv_encaminhamento.id ORDER BY prazo_solucao.id DESC LIMIT 1)")
                );
            })
            ->where('demanda_id', $detalheEncaminhamento->demanda_id)
            ->where('status_id', '3')
            ->orderBy('id', 'DESC')
            ->select([
                'ouv_encaminhamento.id',
                'ouv_encaminhamento.resposta',
                'ouv_encaminhamento.resposta_ouvidor',
                'ouv_encaminhamento.resp_publica',
                \DB::raw('DATE_FORMAT(prazo_solucao.data,"%d/%m/%Y") as prazo_solucao'),
                \DB::raw('DATE_FORMAT(prazo_solucao.data_cadastro,"%d/%m/%Y") as data_cadastro'),
                'prazo_solucao.status as status_prazo_solucao',
                'prazo_solucao.justificativa as justificativa_prazo_solucao',
            ])->first();

        return view('encaminhamento.detalheDoEncaminhamento',
            compact('detalheEncaminhamento', 'loadFields', 'respostasPassadas', 'encaminhamentoAnterior'));
    }

    /**
     * @param $id
     * @return mixed
     */
    private function queryParaDetalheEncaminhamento($id)
    {
        $query = \DB::table('ouv_encaminhamento')
            ->leftJoin(\DB::raw('prazo_solucao'), function ($join) {
                $join->on(
                    'prazo_solucao.id', '=',
                    \DB::raw("(SELECT prazo_solucao.id FROM prazo_solucao
                        where prazo_solucao.encaminhamento_id = ouv_encaminhamento.id ORDER BY prazo_solucao.id DESC LIMIT 1)")
                );
            })
            ->leftJoin('ouv_demanda', 'ouv_demanda.id', '=', 'ouv_encaminhamento.demanda_id')
            ->leftJoin('ouv_tipo_demanda', 'ouv_tipo_demanda.id', '=', 'ouv_demanda.tipo_demanda_id')
            ->leftJoin('ouv_pessoa', 'ouv_pessoa.id', '=', 'ouv_demanda.pessoa_id')
            ->leftJoin('bairros', 'bairros.id', '=', 'ouv_demanda.bairro_id')
            ->leftJoin('cidades', 'cidades.id', '=', 'bairros.cidades_id')
            ->leftJoin('sexos', 'sexos.id', '=', 'ouv_demanda.sexos_id')
            ->leftJoin('ouv_idade', 'ouv_idade.id', '=', 'ouv_demanda.idade_id')
            ->leftJoin('users as users_demanda', 'users_demanda.id', '=', 'ouv_demanda.user_id')
            ->leftJoin('users as users_encaminhamento', 'users_encaminhamento.id', '=', 'ouv_encaminhamento.user_id')
            ->leftJoin('ouv_prioridade', 'ouv_prioridade.id', '=', 'ouv_encaminhamento.prioridade_id')
            ->leftJoin('ouv_destinatario', 'ouv_destinatario.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->leftJoin('ouv_area', 'ouv_area.id', '=', 'ouv_destinatario.area_id')
            ->leftJoin('ouv_status', 'ouv_status.id', '=', 'ouv_encaminhamento.status_id')
            ->leftJoin('ouv_informacao', 'ouv_informacao.id', '=', 'ouv_demanda.informacao_id')
            ->leftJoin('ouv_subassunto', 'ouv_subassunto.id', '=', 'ouv_demanda.subassunto_id')
            ->leftJoin('ouv_assunto', 'ouv_assunto.id', '=', 'ouv_subassunto.assunto_id')
            ->leftJoin('tipo_resposta', 'tipo_resposta.id', '=', 'ouv_demanda.tipo_resposta_id')
            ->leftJoin('ouv_sigilo', 'ouv_sigilo.id', '=', 'ouv_demanda.sigilo_id')
            ->where('ouv_encaminhamento.id', '=', $id)
            ->select([
                'ouv_encaminhamento.id as id',
                'ouv_demanda.id as demanda_id',
                \DB::raw('CONCAT (SUBSTRING(ouv_demanda.codigo, 4, 4), "/", SUBSTRING(ouv_demanda.codigo, -4, 4)) as codigo'),
                'ouv_prioridade.nome as prioridade',
                'ouv_destinatario.nome as destinatario',
                'ouv_destinatario.id as destinatario_id',
                'ouv_area.nome as area',
                'ouv_area.id as area_id',
                'ouv_status.nome as status',
                'ouv_status.id as status_id',
                'ouv_sigilo.nome as sigilo',
                'ouv_encaminhamento.parecer',
                \DB::raw('DATE_FORMAT(ouv_encaminhamento.data,"%d/%m/%Y") as data'),
                \DB::raw('DATE_FORMAT(ouv_demanda.data,"%d/%m/%Y") as dataCadastro'),
                \DB::raw('DATE_FORMAT(ouv_demanda.data_da_ocorrencia,"%d/%m/%Y") as dataOcorrencia'),
                \DB::raw('DATE_FORMAT(ouv_demanda.data,"%H:%m:%s") as horaCadastro'),
                \DB::raw('DATE_FORMAT(ouv_encaminhamento.previsao,"%d/%m/%Y") as previsao'),
                \DB::raw('DATE_FORMAT(ouv_encaminhamento.data_resposta,"%d/%m/%Y") as data_resposta'),
                \DB::raw('DATE_FORMAT(prazo_solucao.data,"%d/%m/%Y") as prazo_solucao'),
                \DB::raw('DATE_FORMAT(prazo_solucao.data_cadastro,"%d/%m/%Y") as data_cadastro'),
                'prazo_solucao.status as status_prazo_solucao',
                'prazo_solucao.justificativa as justificativa_prazo_solucao',
                'ouv_encaminhamento.encaminhado',
                'ouv_encaminhamento.resposta',
                'ouv_encaminhamento.resposta_ouvidor',
                'ouv_encaminhamento.resp_publica',
                'ouv_encaminhamento.resp_ouvidor_publica',
                'ouv_encaminhamento.status_id as status_id',
                'ouv_encaminhamento.status_prorrogacao',
                'ouv_encaminhamento.justificativa_prorrogacao',
                'ouv_assunto.nome as assunto',
                'ouv_subassunto.nome as subassunto',
                'ouv_informacao.nome as informacao',
                'ouv_demanda.relato',
                'tipo_resposta.nome as tipo_resposta',
                'users_demanda.name as responsavel',
                'users_encaminhamento.name as responsavel_resposta',
                'ouv_demanda.nome as manifestante',
                'ouv_tipo_demanda.nome as tipo_demanda',
                'ouv_demanda.cpf',
                'ouv_demanda.hora_da_ocorrencia as horaOcorrencia',
                'ouv_demanda.fone',
                'ouv_demanda.profissao',
                'ouv_demanda.email',
                'ouv_demanda.rg',
                'ouv_demanda.endereco',
                'ouv_demanda.numero_end',
                'ouv_demanda.cep',
                'ouv_pessoa.nome as identificacao',
                'bairros.nome as bairro',
                'cidades.nome as cidade',
                'ouv_idade.nome as idade',
                'sexos.nome as sexo',
                'ouv_demanda.sigilo_id',
                'ouv_demanda.n_protocolo',
            ])->first();

        return $query;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function responder(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Executando a ação
            $retorno = $this->service->responder($data);

            if($retorno) {
                #Retorno para a view
                return redirect()->back()->with("message", "Encaminhamento respondido com sucesso!");
            } else {
                #Retorno para a view
                return redirect()->back()->with("error", "O prazo para solução da manifestação deve ser maior que a data do encaminhamento!");
            }

        } catch (\Throwable $e) {print_r($e->getMessage()); exit;
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function historicoEncamihamentosGrid(Request $request)
    {
        $rows = \DB::table('ouv_encaminhamento')
            ->join('ouv_demanda', 'ouv_demanda.id', '=', 'ouv_encaminhamento.demanda_id')
            ->join('ouv_prioridade', 'ouv_prioridade.id', '=', 'ouv_encaminhamento.prioridade_id')
            ->join('ouv_destinatario', 'ouv_destinatario.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->join('ouv_area', 'ouv_area.id', '=', 'ouv_destinatario.area_id')
            ->join('ouv_status', 'ouv_status.id', '=', 'ouv_encaminhamento.status_id')
            ->where('ouv_demanda.id', '=', $request->get('id'))
            ->select([
                'ouv_encaminhamento.id as id',
                'ouv_demanda.id as demanda_id',
                \DB::raw('CONCAT (SUBSTRING(ouv_demanda.codigo, 4, 4), "/", SUBSTRING(ouv_demanda.codigo, -4, 4)) as codigo'),
                'ouv_prioridade.nome as prioridade',
                'ouv_destinatario.nome as destinatario',
                'ouv_area.nome as area',
                'ouv_status.nome as status',
                'ouv_encaminhamento.parecer',
                \DB::raw('DATE_FORMAT(ouv_encaminhamento.data,"%d/%m/%Y") as data'),
                \DB::raw('DATE_FORMAT(ouv_encaminhamento.previsao,"%d/%m/%Y") as previsao'),
                'ouv_encaminhamento.encaminhado',
                'ouv_encaminhamento.resposta',
                'ouv_encaminhamento.resposta_ouvidor',
            ]);
        
        return Datatables::of($rows)->make(true);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function demandasAgrupadasGrid(Request $request)
    {
        $rows = \DB::table('demandas_agrupadas')
            ->join('ouv_demanda as principal', 'principal.id', '=', 'demandas_agrupadas.demanda_principal_id')
            ->join('ouv_demanda as agrupada', 'agrupada.id', '=', 'demandas_agrupadas.demanda_agrupada_id')
            ->join('ouv_subassunto', 'ouv_subassunto.id', '=', 'agrupada.subassunto_id')
            ->join('ouv_assunto', 'ouv_assunto.id', '=', 'ouv_subassunto.assunto_id')
            ->join('ouv_area', 'ouv_area.id', '=', 'agrupada.area_id')
            ->join('ouv_status', 'ouv_status.id', '=', 'agrupada.status_id')
            ->where('principal.id', '=', $request->get('id'))
            ->select([
                'demandas_agrupadas.id as id',
                \DB::raw('CONCAT (SUBSTRING(agrupada.codigo, 4, 4), "/", SUBSTRING(agrupada.codigo, -4, 4)) as codigo'),
                'ouv_assunto.nome as assunto',
                'ouv_subassunto.nome as subassunto',
                'ouv_area.nome as area',
                'ouv_status.nome as status',
                \DB::raw('DATE_FORMAT(agrupada.data,"%d/%m/%Y") as data'),
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
           
            $html = '<a data="'.$row->id.'" class="btn btn-xs btn-danger excluir-agrupamento" title="Deletar"><i class="zmdi zmdi-plus-circle-o"></i></a> ';

            return $html;
        })->make(true);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function reencaminar($id)
    {
        try {
            #Recuperando a empresa
            $model = $this->service->find($id);

            #Carregando os dados para o cadastro
            $loadFields = $this->service->load($this->loadFields);

            #retorno para view
            return view('encaminhamento.reencaminhamento', compact('model', 'loadFields'));
        } catch (\Throwable $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reencaminarStore(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();
            
            #Executando a ação
            $returno = $this->service->reencaminarStore($data);

            /*if($returno) {
                $detalhe = $this->queryParaDetalheEncaminhamento($returno->id);
                SerbinarioSendEmail::sendEmailMultiplo($detalhe);
            }*/

            #Retorno para a view
            return redirect()->route('seracademico.ouvidoria.demanda.index')->with("message", "Reencaminhamento realizado com sucesso!");
        } catch (\Throwable $e) {print_r($e->getMessage()); exit;
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function fristEncaminhar($id)
    {
        try {
            #Carregando os dados para o cadastro
            $loadFields = $this->service->load($this->loadFields);

            // Pegando o relato da demanda
            $manifestacao = \DB::table('ouv_demanda')
                ->where('id', $id)
                ->select(['relato'])->first();

            #retorno para view
            return view('encaminhamento.encaminhamento', compact('id','loadFields', 'manifestacao'));
        } catch (\Throwable $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function encaminhar($id)
    {
        try {
            #Recuperando a empresa
            $model = $this->service->find($id);

            #Carregando os dados para o cadastro
            $loadFields = $this->service->load($this->loadFields);

            #retorno para view
            return view('encaminhamento.encaminhamento', compact('model','loadFields'));
        } catch (\Throwable $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function encaminharStore(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Executando a ação
            $returno = $this->service->encaminharStore($data);

            /*if($returno) {
                $detalhe = $this->queryParaDetalheEncaminhamento($returno->id);
                SerbinarioSendEmail::sendEmailMultiplo($detalhe);
            }*/

            #Retorno para a view
            return redirect()->route('seracademico.ouvidoria.demanda.index')->with("message", "Encaminhamento realizado com sucesso!");

        } catch (\Throwable $e) {print_r($e->getMessage()); exit;
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function primeiroEncaminharStore(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Validando a requisição
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            #Executando a ação
            $this->service->encaminharStore($data);

            /*if($returno) {
                $detalhe = $this->queryParaDetalheEncaminhamento($returno->id);
                SerbinarioSendEmail::sendEmailMultiplo($detalhe);
            }*/

            #Retorno para a view
            return redirect()->route('seracademico.ouvidoria.demanda.index')->with("message", "Encaminhamento realizado com sucesso!");

        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        } catch (\Throwable $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function encaminharAjax(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Executando a ação
            $returno = $this->service->encaminharAjax($data);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['error' => $e->getMessage()]);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function finalizar(Request $request, $id)
    {
        try {
            #Recuperando a empresa
            $retorno = $this->service->finalizar($id, $request->get('statusExterno'));

            #Retorno para a view
            return redirect()->back()->with("message", "Manifestação finalizada com sucesso!");
        } catch (\Throwable $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function prorrogarPrazo(Request $request)
    {
        try {

            #Recuperando a empresa
            $this->service->prorrogarPrazo($request->all());

            #Retorno para a view
            return redirect()->back()->with("message", "Manifestação prorrogada com sucesso!");
        } catch (\Throwable $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function prorrogarPrazoSolucao(Request $request)
    {
        try {

            #Recuperando a empresa
            $retorno = $this->service->prorrogarPrazoSolucao($request->all());

            if($retorno) {
                #Retorno para a view
                return redirect()->back()->with("message", "Prazo da solução da manifestação foi prorrogado com sucesso!");
            } else {
                #Retorno para a view
                return redirect()->back()->with("error", "O prazo para solução da manifestação deve ser maior que a data do encaminhamento!");
            }

        } catch (\Throwable $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function verificarAlertasDeDemandas()
    {
        $alertas = SerbinarioAlertaDemanda::alertaDeDemanda();

        return \Illuminate\Support\Facades\Response::json($alertas);
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function agruparDemanda(Request $request)
    {

        //Limpando o código
        $codigo = str_replace("/", '', $request->get('codigo'));

        // Pega a demanda a ser agrupada
        $demanda = \DB::table('ouv_demanda')->where('ouv_demanda.codigo', '=', $codigo)
            ->select(['id'])->first();

        if($demanda) {

            // Pega a demanda a ser agrupada
            $validarAgrupamento = \DB::table('demandas_agrupadas')->where('demanda_principal_id', '=', $request->get('id'))
                ->where('demanda_agrupada_id', '=', $demanda->id)
                ->select(['id'])->first();

            // Valida se essa demanda já foi agrupada
            if(!$validarAgrupamento) {

                \DB::table('demandas_agrupadas')->insert(
                    ['demanda_principal_id' => $request->get('id'), 'demanda_agrupada_id' => $demanda->id]
                );

                $retorno = true;
                $msg     = "Demanda agrupada com sucesso!";
            } else {
                $retorno = false;
                $msg     = "Esta demanda já foi agrupada!";
            }


        } else {
            $retorno = false;
            $msg     = "Demanda não encontrada!";
        }

        return \Illuminate\Support\Facades\Response::json(['retorno' => $retorno, 'msg' => $msg]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function deletarDemandaAgrupada(Request $request)
    {
        
        $result  = \DB::table('demandas_agrupadas')->where('id', '=', $request->get('id'))->delete();

        if($result) {
            $retorno = true;
            $msg     = "Agrupamento deletado!";
        } else {
            $retorno = false;
            $msg     = "Falha ao deletar!";
        }
        
        return \Illuminate\Support\Facades\Response::json(['retorno' => $retorno, 'msg' => $msg]);
    }
}
