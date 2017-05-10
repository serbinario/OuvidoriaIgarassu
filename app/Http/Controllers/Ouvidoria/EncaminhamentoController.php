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
        $this->service->visualizar($id);

        $detalheEncaminhamento = $this->queryParaDetalheEncaminhamento($id);
        $loadFields = $this->service->load($this->loadFields);

        return view('encaminhamento.detalheDoEncaminhamento', compact('detalheEncaminhamento', 'loadFields'));
    }

    /**
     * @param $id
     * @return mixed
     */
    private function queryParaDetalheEncaminhamento($id)
    {
        $query = \DB::table('ouv_encaminhamento')
            ->leftJoin('ouv_demanda', 'ouv_demanda.id', '=', 'ouv_encaminhamento.demanda_id')
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
                'ouv_encaminhamento.parecer',
                \DB::raw('DATE_FORMAT(ouv_encaminhamento.data,"%d/%m/%Y") as data'),
                \DB::raw('DATE_FORMAT(ouv_encaminhamento.previsao,"%d/%m/%Y") as previsao'),
                'ouv_encaminhamento.encaminhado',
                'ouv_encaminhamento.resposta',
                'ouv_encaminhamento.resposta_ouvidor',
                'ouv_encaminhamento.resp_publica',
                'ouv_encaminhamento.resp_ouvidor_publica',
                'ouv_encaminhamento.status_id as status_id',
                'ouv_assunto.nome as assunto',
                'ouv_subassunto.nome as subassunto',
                'ouv_informacao.nome as informacao',
                'ouv_demanda.relato',
                'tipo_resposta.nome as tipo_resposta',
                'users_demanda.name as responsavel',
                'users_encaminhamento.name as responsavel_resposta',
                'ouv_demanda.nome as manifestante',
                'ouv_demanda.sigilo_id'
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
            $this->service->responder($data);

            #Retorno para a view
            return redirect()->back()->with("message", "Encaminhamento respondido com sucesso!");
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

            #retorno para view
            return view('encaminhamento.encaminhamento', compact('id','loadFields'));
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function finalizar($id)
    {
        try {
            #Recuperando a empresa
            $retorno = $this->service->finalizar($id);

            try {

                /*if($retorno['demanda']->tipo_resposta_id == '1') {

                    Mail::send('emails.paginaDeNotificacaoParaUsuario', ['demanda' => $retorno['demanda']], function ($m) {
                        $m->from('uchiteste@gmail.com', 'Ouvidoria - Notificação de reposta');

                        $m->to("fabinhobarreto2@gmail.com", 'Fabio');

                        $m->subject('Reposta da manifestação!');
                    });

                }*/
                
                // Enviando e-mail para as demandas agrupadas
                /*foreach ($retorno['demandasAgrupadas'] as $demanda) {

                    if($demanda->tipo_resposta_id == '1') {
                        Mail::send('emails.paginaDeNotificacaoParaUsuario', ['demanda' => $demanda], function ($m) {
                            $m->from('uchiteste@gmail.com', 'Ouvidoria - Notificação de reposta');

                            $m->to("fabinhobarreto2@gmail.com", 'Fabio');

                            $m->subject('Reposta da manifestação!');
                        });
                    }
                }*/
                
            } catch (\Throwable $e) {
                dd($e->getMessage());
            }

            #Retorno para a view
            return redirect()->back()->with("message", "Demanda finalizada com sucesso!");
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
