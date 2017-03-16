<?php

namespace Seracademico\Http\Controllers\Ouvidoria;

use Illuminate\Http\Request;

use Mail;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Seracademico\Services\Ouvidoria\EncaminhamentoService;
use Seracademico\Repositories\Ouvidoria\EncaminhamentoRepository;
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
     * @return mixed
     */
    public function encaminhadosGrid(Request $request)
    {
        $data  = new \DateTime('now');

        #Criando a consulta
        $rows = \DB::table('ouv_demanda');

        # Buscanco as demandas pelos últimos encaminhamentos
        if($request->has('status') && ($request->get('status') == 0 && $request->get('statusGet') == "0" )) {
            $rows->join(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento 
                    where encaminhamento.demanda_id = ouv_demanda.id AND encaminhamento.status_id IN (1,7,2,4,6) ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            });

        }

        # Buscanco apenas as demandas encaminhadas e reencaminhadas
        if($request->has('status') && ($request->get('status') == '1' || $request->get('statusGet') == '1')) {
            $rows ->join(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento 
                    where encaminhamento.demanda_id = ouv_demanda.id AND encaminhamento.status_id IN (1,7) ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            });
        }

        # Buscanco apenas as demandas em análise
        if($request->has('status') && ($request->get('status') == '2' || $request->get('statusGet') == '2')) {
            $rows ->join(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento 
                    where encaminhamento.demanda_id = ouv_demanda.id AND encaminhamento.status_id = 2 ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            });
        }

        # Buscanco apenas as demandas concluídas
        if($request->has('status') && ($request->get('status') == '3' || $request->get('statusGet') == '3')) {
            $rows ->join(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento 
                    where encaminhamento.demanda_id = ouv_demanda.id AND encaminhamento.status_id = 4 ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            });
        }

        # Buscanco apenas as demandas finalizadas
        if($request->has('status') && $request->get('status') != 0 && $request->get('status') == '4') {
            $rows ->join(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento 
                    where encaminhamento.demanda_id = ouv_demanda.id AND encaminhamento.status_id = 6 ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            });
        }

        # Buscanco apenas as demandas a atrasar em 15 dias
        if($request->has('status') && ($request->get('status') == '5' || $request->get('statusGet') == '5')) {
            $rows ->join(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento 
                    where encaminhamento.demanda_id = ouv_demanda.id AND encaminhamento.status_id IN (1,7,2) ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            })->where(\DB::raw('DATEDIFF(ouv_encaminhamento.previsao, CURDATE())'), '<=', '15');

        }
        
        # Buscanco apenas as demandas atrasadas
        if($request->has('status') && ($request->get('status') == '6' || $request->get('statusGet') == '6')) {
            $rows ->join(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento 
                    where encaminhamento.demanda_id = ouv_demanda.id AND encaminhamento.status_id IN (1,7,2) ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            })->where('ouv_encaminhamento.previsao', '<', $data->format('Y-m-d'));

        }

        // Estrutura da query em geral
        $rows->leftJoin('ouv_prioridade', 'ouv_prioridade.id', '=', 'ouv_encaminhamento.prioridade_id')
            ->join('users', 'users.id', '=', 'ouv_demanda.user_id')
            ->leftJoin('ouv_destinatario', 'ouv_destinatario.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->leftJoin('ouv_area', 'ouv_area.id', '=', 'ouv_destinatario.area_id')
            ->leftJoin('ouv_status', 'ouv_status.id', '=', 'ouv_encaminhamento.status_id')
            ->select([
                'ouv_demanda.id as id',
                'ouv_encaminhamento.id as encaminhamento_id',
                \DB::raw('CONCAT (SUBSTRING(ouv_demanda.codigo, 4, 4), "/", SUBSTRING(ouv_demanda.codigo, -4, 4)) as codigo'),
                \DB::raw('DATE_FORMAT(ouv_encaminhamento.data,"%d/%m/%Y") as data'),
                'ouv_prioridade.nome as prioridade',
                'ouv_destinatario.nome as destino',
                'ouv_area.nome as area',
                \DB::raw('DATE_FORMAT(ouv_encaminhamento.previsao,"%d/%m/%Y") as previsao'),
                'ouv_status.nome as status',
                'ouv_status.id as status_id',
                'users.name as responsavel'
            ]);

        // Validando se o usuário autenticado é de secretaria e adaptando o select para a secretaria do usuário logado
        if(!$this->user->is('admin|ouvidoria') && $this->user->is('secretaria')) {
            $rows->where('ouv_area.id', '=', $this->user->secretaria->id);
        }

        // Validando se o usuário autenticado é de secretaria e adaptando o select para a secretaria do usuário logado
        if($this->user->is('admin|ouvidoria') && $request->get('responsavel') != 0) {
            $rows->where('users.id', '=', $request->get('responsavel'));
        }

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            $html = "";
            if($row->encaminhamento_id) {
                $html .= '<a href="detalheAnalise/'.$row->encaminhamento_id.'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Visualizar</a>';
            }
            /*if ($this->user->is('admin|ouvidoria') && !$row->encaminhamento_id) {
                $html .= '<a href="fristEncaminhar/'.$row->id.'" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> Encaminhar</a>';
            }*/

            return $html;
        })->make(true);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detalheParaAnaliseDoEncaminhamento($id)
    {
        $this->service->visualizar($id);

        $detalheEncaminhamento = $this->queryParaDetalheEncaminhamento($id);

        return view('encaminhamento.detalheDoEncaminhamento', compact('detalheEncaminhamento'));
    }

    /**
     * @param $id
     * @return mixed
     */
    private function queryParaDetalheEncaminhamento($id)
    {
        $query = \DB::table('ouv_encaminhamento')
            ->join('ouv_demanda', 'ouv_demanda.id', '=', 'ouv_encaminhamento.demanda_id')
            ->leftJoin('users', 'users.id', '=', 'ouv_demanda.user_id')
            ->join('ouv_prioridade', 'ouv_prioridade.id', '=', 'ouv_encaminhamento.prioridade_id')
            ->join('ouv_destinatario', 'ouv_destinatario.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->join('ouv_area', 'ouv_area.id', '=', 'ouv_destinatario.area_id')
            ->join('ouv_status', 'ouv_status.id', '=', 'ouv_encaminhamento.status_id')
            ->join('ouv_informacao', 'ouv_informacao.id', '=', 'ouv_demanda.informacao_id')
            ->leftJoin('ouv_subassunto', 'ouv_subassunto.id', '=', 'ouv_demanda.subassunto_id')
            ->leftJoin('ouv_assunto', 'ouv_assunto.id', '=', 'ouv_subassunto.assunto_id')
            ->where('ouv_encaminhamento.id', '=', $id)
            ->select([
                'ouv_encaminhamento.id as id',
                'ouv_demanda.id as demanda_id',
                \DB::raw('CONCAT (SUBSTRING(ouv_demanda.codigo, 4, 4), "/", SUBSTRING(ouv_demanda.codigo, -4, 4)) as codigo'),
                'ouv_prioridade.nome as prioridade',
                'ouv_destinatario.nome as destinatario',
                'ouv_area.nome as area',
                'ouv_area.id as area_id',
                'ouv_status.nome as status',
                'ouv_encaminhamento.parecer',
                \DB::raw('DATE_FORMAT(ouv_encaminhamento.data,"%d/%m/%Y") as data'),
                \DB::raw('DATE_FORMAT(ouv_encaminhamento.previsao,"%d/%m/%Y") as previsao'),
                'ouv_encaminhamento.encaminhado',
                'ouv_encaminhamento.resposta',
                'ouv_encaminhamento.status_id as status_id',
                'ouv_assunto.nome as assunto',
                'ouv_subassunto.nome as subassunto',
                'ouv_informacao.nome as informacao',
                'ouv_demanda.relato',
                'users.name as responsavel'
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
    public function historicoEncamihamentos($id)
    {
        $encaminhamentos = \DB::table('ouv_encaminhamento')
            ->join('ouv_demanda', 'ouv_demanda.id', '=', 'ouv_encaminhamento.demanda_id')
            ->join('ouv_prioridade', 'ouv_prioridade.id', '=', 'ouv_encaminhamento.prioridade_id')
            ->join('ouv_destinatario', 'ouv_destinatario.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->join('ouv_area', 'ouv_area.id', '=', 'ouv_destinatario.area_id')
            ->join('ouv_status', 'ouv_status.id', '=', 'ouv_encaminhamento.status_id')
            ->where('ouv_demanda.id', '=', $id)
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
            ])->get();

        return view('encaminhamento.historicoDaDemanda', compact('encaminhamentos'));
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

            //$detalhe = $this->queryParaDetalheEncaminhamento($data['id']);
            //return view('emails.paginaDeNotificacao', compact('detalhe'));
            
            #Executando a ação
            $returno = $this->service->reencaminarStore($data);

            if($returno) {
                $detalhe = $this->queryParaDetalheEncaminhamento($returno->id);
                SerbinarioSendEmail::sendEmailMultiplo($detalhe);
            }

            #Retorno para a view
            return redirect()->route('seracademico.ouvidoria.encaminhamento.encaminhados')->with("message", "Reencaminhamento realizado com sucesso!");
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

            if($returno) {
                $detalhe = $this->queryParaDetalheEncaminhamento($returno->id);
                SerbinarioSendEmail::sendEmailMultiplo($detalhe);
            }

            if($request->has('primeiro_encaminhamento') && $request->get('primeiro_encaminhamento') == '1') {
                #Retorno para a view
                return redirect()->route('seracademico.ouvidoria.demanda.index')->with("message", "Encaminhamento realizado com sucesso!");
            } else {
                #Retorno para a view
                return redirect()->route('seracademico.ouvidoria.encaminhamento.encaminhados')->with("message", "Encaminhamento realizado com sucesso!");
            }

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
            $this->service->finalizar($id);

            #Retorno para a view
            return redirect()->back()->with("message", "Demanda finalizada com sucesso!");
        } catch (\Throwable $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function novosDemandas(Request $request)
    {
        
        $encaminhamentos = \DB::table('ouv_demanda')
            ->join('ouv_status', 'ouv_status.id', '=', 'ouv_demanda.status_id')
            ->where('ouv_status.id', '=','5')
            ->select([
                'ouv_demanda.id as id',
            ]);

        if(count($encaminhamentos->get()) > 0) {
            $msg = "sucesso";
        } else {
            $msg = "nao";
        }

        return \Illuminate\Support\Facades\Response::json(['msg' => $msg]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function demandasEncaminhadas(Request $request)
    {

        $encaminhamentos = \DB::table('ouv_encaminhamento')
            ->join('ouv_demanda', 'ouv_demanda.id', '=', 'ouv_encaminhamento.demanda_id')
            ->join('ouv_destinatario', 'ouv_destinatario.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->join('ouv_area', 'ouv_area.id', '=', 'ouv_destinatario.area_id')
            ->join('ouv_status', 'ouv_status.id', '=', 'ouv_encaminhamento.status_id')
            ->whereIn('ouv_status.id', [1,7])
            ->select([
                'ouv_encaminhamento.id as id',
            ]);

        // Validando se o usuário autenticado é de secretaria e adaptando o select para a secretaria do usuário logado
        if(!$this->user->is('admin|ouvidoria') && $this->user->is('secretaria')) {
            $encaminhamentos->where('ouv_area.id', '=', $this->user->secretaria->id);
        }

        if(count($encaminhamentos->get()) > 0) {
            $msg = "sucesso";
        } else {
            $msg = "nao";
        }

        return \Illuminate\Support\Facades\Response::json(['msg' => $msg]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function demandasAtrasadas(Request $request)
    {

        $data  = new \DateTime('now');

        $encaminhamentos = \DB::table('ouv_demanda')
            ->join(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento 
                    where encaminhamento.demanda_id = ouv_demanda.id AND encaminhamento.status_id IN (1,7,2)  ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            })
            ->join('ouv_status', 'ouv_status.id', '=', 'ouv_encaminhamento.status_id')
            ->join('ouv_destinatario', 'ouv_destinatario.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->join('ouv_area', 'ouv_area.id', '=', 'ouv_destinatario.area_id')
            ->whereIn('ouv_encaminhamento.status_id', [1,7,2])
            ->where('ouv_encaminhamento.previsao', '<', $data->format('Y-m-d'))
            ->select([
                'ouv_encaminhamento.id as id',
            ]);
        // Validando se o usuário autenticado é de secretaria e adaptando o select para a secretaria do usuário logado
        if(!$this->user->is('admin|ouvidoria') && $this->user->is('secretaria')) {
            $encaminhamentos->where('ouv_area.id', '=', $this->user->secretaria->id);
        }

        if(count($encaminhamentos->get()) > 0) {
            $msg = "sucesso";
        } else {
            $msg = "nao";
        }

        return \Illuminate\Support\Facades\Response::json(['msg' => $msg]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function demandasAAtrasar(Request $request)
    {

        $encaminhamentos = \DB::table('ouv_demanda')
            ->join(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento 
                    where encaminhamento.demanda_id = ouv_demanda.id AND encaminhamento.status_id IN (1,7,2)  ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            })
            ->join('ouv_status', 'ouv_status.id', '=', 'ouv_encaminhamento.status_id')
            ->join('ouv_destinatario', 'ouv_destinatario.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->join('ouv_area', 'ouv_area.id', '=', 'ouv_destinatario.area_id')
            ->whereIn('ouv_encaminhamento.status_id', [1,7,2])
            ->where(\DB::raw('DATEDIFF(ouv_encaminhamento.previsao, CURDATE())'), '<=', '15')
            ->select([
                'ouv_encaminhamento.id as id',
            ]);

        // Validando se o usuário autenticado é de secretaria e adaptando o select para a secretaria do usuário logado
        if(!$this->user->is('admin|ouvidoria') && $this->user->is('secretaria')) {
            $encaminhamentos->where('ouv_area.id', '=', $this->user->secretaria->id);
        }

        if(count($encaminhamentos->get()) > 0) {
            $msg = "sucesso";
        } else {
            $msg = "nao";
        }

        return \Illuminate\Support\Facades\Response::json(['msg' => $msg]);
    }

}
