<?php

namespace Seracademico\Http\Controllers\Ouvidoria;

use Illuminate\Http\Request;

use Seracademico\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Seracademico\Repositories\Ouvidoria\DemandaRepository;
use Seracademico\Services\Configuracao\ConfiguracaoGeralService;
use Seracademico\Services\Ouvidoria\DemandaService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\DemandaValidator;
use Seracademico\Validators\DemandaPublicValidator;
use Seracademico\Uteis\SerbinarioDateFormat;

class DemandaController extends Controller
{
    /**
    * @var DemandaService
    */
    private $service;

    /**
     * @var DemandaRepository
     */
    private $repository;

    /**
    * @var DemandaValidator
    */
    private $validator;

    /**
     * @var DemandaPublicValidator
     */
    private $validatorPublic;

    /**
    * @var array
    */
    private $loadFields = [
        'Ouvidoria\Secretaria',
        'Ouvidoria\Anonimo',
        'Ouvidoria\Escolaridade',
        'Ouvidoria\Informacao',
        'Ouvidoria\Sigilo',
        'Ouvidoria\TipoDemanda',
        'Ouvidoria\ExclusividadeSUS',
        'Sexo',
        'Ouvidoria\Situacao',
        'Ouvidoria\TipoDemanda',
        'Ouvidoria\OuvPessoa',
        'Ouvidoria\Melhoria',
        'Ouvidoria\Assunto',
        'Ouvidoria\Subassunto',
        'Ouvidoria\Status',
        'Ouvidoria\Prioridade',
        'Ouvidoria\Destinatario',
        'Ouvidoria\Comunidade',
        'Ouvidoria\TipoResposta',
        'Cidade|byEstado,16'
    ];

    private $loadFields2 = [
        'Ouvidoria\Idade',
    ];

    /**
     * @var
     */
    private $user;

    /**
     * @var ConfiguracaoGeralService
     */
    private $configuracaoGeralService;

    /**
     * DemandaController constructor.
     * @param DemandaService $service
     * @param DemandaValidator $validator
     * @param DemandaRepository $repository
     * @param DemandaPublicValidator $validatorPublic
     * @param ConfiguracaoGeralService $configuracaoGeralService
     */
    public function __construct(DemandaService $service,
                                DemandaValidator $validator,
                                DemandaRepository $repository,
                                DemandaPublicValidator $validatorPublic,
                                ConfiguracaoGeralService $configuracaoGeralService)
    {
        $this->service          =  $service;
        $this->validator        =  $validator;
        $this->repository       =  $repository;
        $this->validatorPublic  =  $validatorPublic;
        $this->user             = Auth::user();
        $this->configuracaoGeralService = $configuracaoGeralService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //Pega o status por acesso a página via get
        $status = $request->has('status') ? $request->get('status') : "0";

        $usuarios = \DB::table('users')->select(['name', 'id'])->get();
        
        return view('ouvidoria.demanda.index', compact('usuarios', 'status'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexPublico()
    {
        return view('ouvidoria.demanda.indexPublico');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function buscarDemanda()
    {
        return view('ouvidoria.demanda.buscarDemanda');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDemanda(Request $request, $protocolo)
    {

        // Pegando o número do protocolo
        $protocolo = $request->get('protocolo') ? $request->get('protocolo') : $protocolo;

        // Consulta os dados da demanda
        $dados = $this->service->detalheDaDemanda($protocolo);

        $encaminhamentos = \DB::table('ouv_encaminhamento')
            ->leftJoin(\DB::raw('prazo_solucao'), function ($join) {
                $join->on(
                    'prazo_solucao.id', '=',
                    \DB::raw("(SELECT prazo_solucao.id FROM prazo_solucao
                        where prazo_solucao.encaminhamento_id = ouv_encaminhamento.id ORDER BY prazo_solucao.id DESC LIMIT 1)")
                );
            })
            ->join('ouv_status', 'ouv_status.id', '=', 'ouv_encaminhamento.status_id')
            ->join('ouv_destinatario', 'ouv_destinatario.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->join('ouv_area', 'ouv_area.id', '=', 'ouv_destinatario.area_id')
            ->where('ouv_encaminhamento.demanda_id', $dados->demanda_id)->select([
                'ouv_encaminhamento.resposta',
                'ouv_encaminhamento.resposta_ouvidor',
                'ouv_encaminhamento.resp_publica',
                'ouv_status.nome as status',
                'ouv_status.id as status_id',
                \DB::raw('DATE_FORMAT(ouv_encaminhamento.data_resposta,"%d/%m/%Y") as data_resposta'),
                \DB::raw('DATE_FORMAT(ouv_encaminhamento.data,"%d/%m/%Y") as data'),
                'ouv_area.nome as secretaria',
                'ouv_area.id as secretaria_id',
                'ouv_destinatario.nome as destino',
                \DB::raw('DATE_FORMAT(prazo_solucao.data,"%d/%m/%Y") as prazo_solucao')
            ])->get();

        return view('ouvidoria.demanda.buscarDemanda', compact('dados', 'encaminhamentos'));
    }

    /**
     * @return mixed
     */
    public function grid(Request $request)
    {

        $dados = $request->request->all();
        $data  = new \DateTime('now');
        
        //Tratando as datas
        $dataIni = SerbinarioDateFormat::toUsa($dados['data_inicio'], 'date');
        $dataFim = SerbinarioDateFormat::toUsa($dados['data_fim'], 'date');

        #Criando a consulta
        $rows = \DB::table('ouv_demanda');

        # Buscanco as demandas pelos últimos encaminhamentos
        if($request->has('status') && ($request->get('status') == 0 && $request->get('statusGet') == "0" )) {
            $rows->leftJoin(\DB::raw('ouv_encaminhamento'), function ($join) {
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

        # Buscanco apenas as novas demandas
        if($request->has('status') && ($request->get('status') == '7' || $request->get('statusGet') == '7')) {
            $rows->leftJoin('ouv_encaminhamento', 'ouv_encaminhamento.demanda_id', '=', 'ouv_demanda.id')
            ->where('ouv_status.id', '=', '5');
        }

        // Estrutura da query em geral
        $rows->leftJoin('ouv_prioridade', 'ouv_prioridade.id', '=', 'ouv_encaminhamento.prioridade_id')
            ->leftJoin('users', 'users.id', '=', 'ouv_demanda.user_id')
            ->leftJoin('ouv_destinatario', 'ouv_destinatario.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->leftJoin('ouv_area as area_destino', 'area_destino.id', '=', 'ouv_destinatario.area_id')
            ->leftJoin('ouv_area as area_ouvidoria', 'area_ouvidoria.id', '=', 'ouv_demanda.area_id')
            ->leftJoin('ouv_informacao', 'ouv_informacao.id', '=', 'ouv_demanda.informacao_id')
            ->leftJoin('ouv_idade', 'ouv_idade.id', '=', 'ouv_demanda.idade_id')
            ->leftJoin('ouv_tipo_demanda', 'ouv_tipo_demanda.id', '=', 'ouv_demanda.tipo_demanda_id')
            ->leftJoin('ouv_status', 'ouv_status.id', '=', 'ouv_demanda.status_id')
            ->leftJoin('ouv_exclusividade_sus', 'ouv_exclusividade_sus.id', '=', 'ouv_demanda.exclusividade_sus_id')
            ->leftJoin('ouv_subassunto', 'ouv_subassunto.id', '=', 'ouv_demanda.subassunto_id')
            ->leftJoin('ouv_assunto', 'ouv_assunto.id', '=', 'ouv_subassunto.assunto_id')
            ->leftJoin('ouv_melhorias', 'ouv_melhorias.id', '=', 'ouv_demanda.melhoria_id')
            ->leftJoin('ouv_comunidade', 'ouv_comunidade.id', '=', 'ouv_demanda.comunidade_id')
            ->select(
                'ouv_demanda.id',
                'ouv_demanda.nome',
                'ouv_encaminhamento.id as encaminhamento_id',
                'ouv_prioridade.nome as prioridade',
                'ouv_destinatario.nome as destino',
                'area_destino.nome as area_destino',
                'area_ouvidoria.nome as area_ouvidoria',
                'users.name as responsavel',
                'ouv_informacao.nome as informacao',
                'ouv_idade.nome as idade',
                'ouv_tipo_demanda.nome as tipo_demanda',
                'ouv_status.nome as status',
                'ouv_status.id as status_id',
                'ouv_exclusividade_sus.nome as exclusividade',
                'ouv_demanda.relato',
                'ouv_demanda.endereco',
                'ouv_demanda.fone',
                'ouv_assunto.nome as assunto',
                'ouv_melhorias.nome as melhoria',
                'ouv_comunidade.nome as comunidade',
                \DB::raw('CONCAT (SUBSTRING(ouv_demanda.codigo, 4, 4), "/", SUBSTRING(ouv_demanda.codigo, -4, 4)) as codigo'),
                \DB::raw('DATE_FORMAT(ouv_demanda.data,"%d/%m/%Y") as data'),
                \DB::raw('DATE_FORMAT(ouv_encaminhamento.previsao,"%d/%m/%Y") as previsao'),
                'ouv_demanda.n_protocolo'
            );

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
        }

        // Validando se o usuário autenticado é de secretaria e adaptando o select para a secretaria do usuário logado
        if(!$this->user->is('admin|ouvidoria') && $this->user->is('secretaria')) {
            $rows->where('area_destino.id', '=', $this->user->secretaria->id);
        }

        // Validando se o usuário autenticado é de secretaria e adaptando o select para a secretaria do usuário logado
        if($this->user->is('admin|ouvidoria') && $request->get('responsavel') != 0) {
            $rows->where('users.id', '=', $request->get('responsavel'));
        }

        
        #Editando a grid
        return Datatables::of($rows)
            ->filter(function ($query) use ($request) {
                // Filtrando Global
                if ($request->has('globalSearch')) {
                    # recuperando o valor da requisição
                    $search = $request->get('globalSearch');

                    #condição
                    $query->where(function ($where) use ($search) {
                        $where->orWhere('ouv_demanda.codigo', 'like', "%$search%")
                            ->orWhere('ouv_demanda.n_protocolo', 'like', "%$search%")
                            ->orWhere('ouv_prioridade.nome', 'like', "%$search%")
                            ->orWhere('ouv_informacao.nome', 'like', "%$search%")
                            ->orWhere('ouv_tipo_demanda.nome', 'like', "%$search%")
                            ->orWhere('ouv_demanda.nome', 'like', "%$search%")
                            ->orWhere('ouv_comunidade.nome', 'like', "%$search%")
                            ->orWhere('area_destino.nome', 'like', "%$search%")
                            ->orWhere('ouv_destinatario.nome', 'like', "%$search%")
                            ->orWhere('ouv_demanda.relato', 'like', "%$search%");
                    });

                }
            })->addColumn('action', function ($row) {

                # Recuperando a calendario
                $demanda = $this->repository->find($row->id);

                // Validando se a demanda está agrupada
                $demandaAgrupada = \DB::table('demandas_agrupadas')
                    ->join('ouv_demanda', 'ouv_demanda.id', '=', 'demandas_agrupadas.demanda_agrupada_id')
                    ->where('ouv_demanda.id', '=', $row->id)
                    ->select('ouv_demanda.id')->first();

                $html   = "";

                if($this->user->is('admin|ouvidoria') && !$this->user->is('secretaria')) {
                    $html .= '<a href="edit/'.$row->id.'" class="btn btn-xs btn-primary waves-effect"><i class="zmdi zmdi-edit" title="Editar"></i></a> ';
                    $html .= '<a href="registro/'.$row->id.'" class="btn btn-xs btn-success waves-effect" target="__blanck" title="Registro"><i class="zmdi zmdi-file"></i></a> ';
                }

                $html .= '<a href="cartaEcaminhamento/'.$row->id.'" class="btn btn-xs btn-warning" target="__blanck" title="Documento"><i class="zmdi zmdi-file-text"></i></a> ';

                if(count($demanda->encaminhamento) == 0 && $this->user->is('admin|ouvidoria') && !$this->user->is('secretaria')) {
                    $html .= '<a href="destroy/'.$row->id.'" class="btn btn-xs btn-danger excluir" title="Deletar"><i class="zmdi zmdi-plus-circle-o"></i></a> ';
                }  if (count($demanda->encaminhamento) == 0 && $this->user->is('admin|ouvidoria') && !$this->user->is('secretaria') && !$demandaAgrupada) {
                    $html .= '<a href="fristEncaminhar/'.$row->id.'" class="btn btn-xs btn-info" title="Encaminhar"><i class="zmdi zmdi-mail-send"></i></a>';
                } else if (!$demandaAgrupada) {
                    $html .= '<a href="detalheAnalise/'.$row->encaminhamento_id.'" class="btn btn-xs btn-primary" title="Visualizar"><i class="zmdi zmdi-search"></i></a>';
                }

                return $html;
        })->addColumn('demandaAgrupada', function ($row) {

                // Validando se a demanda está agrupada
                $demandaAgrupada = \DB::table('demandas_agrupadas')
                    ->join('ouv_demanda', 'ouv_demanda.id', '=', 'demandas_agrupadas.demanda_agrupada_id')
                    ->where('ouv_demanda.id', '=', $row->id)
                    ->select('ouv_demanda.id')->first();
                
                if($demandaAgrupada) {
                    $return = '1';
                } else {
                    $return = '0';
                }
                
                return $return;
            })->make(true);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($this->loadFields);
        $loadFields2 = $this->service->load2($this->loadFields2);

        #Retorno para view
        return view('ouvidoria.demanda.create', compact('loadFields', 'loadFields2'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createPublic()
    {
        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($this->loadFields);
        $loadFields2 = $this->service->load2($this->loadFields2);

        #Retorno para view
        return view('ouvidoria.demanda.createPublic', compact('loadFields', 'loadFields2'));
    }

    /**
     * @param Request $request
     * @return $this|array|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Validando a requisição
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            #Executando a ação
            $this->service->store($data);

            #Retorno para a view
            return redirect()->back()->with("message", "Cadastro realizado com sucesso!");
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        } catch (\Throwable $e) {print_r($e->getMessage()); exit;
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return $this|array|\Illuminate\Http\RedirectResponse
     */
    public function storePublic(Request $request)
    {
        try {

            #Recuperando os dados da requisição
            $data = $request->all();

            #Validando a requisição
            $this->validatorPublic->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            #Executando a ação
            $result = $this->service->store($data);

            $configuracaoGeral = $this->configuracaoGeralService->findConfiguracaoGeral();

            $mensagem = "{$configuracaoGeral->texto_agradecimento} <br><br>
                <b>PROTOCOLO DA MANIFESTAÇÂO: {$result->n_protocolo}</b>";

            #Retorno para a view
            return redirect()->back()->with("message", $mensagem);
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        } catch (\Throwable $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        try {
            #Recuperando a empresa
            $model = $this->service->find($id);

            #Carregando os dados para o cadastro
            $loadFields = $this->service->load($this->loadFields);
            $loadFields2 = $this->service->load2($this->loadFields2);

            #retorno para view
            return view('ouvidoria.demanda.edit', compact('model', 'loadFields', 'loadFields2'));
        } catch (\Throwable $e) {dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #tratando as rules
            $this->validator->replaceRules(ValidatorInterface::RULE_UPDATE, ":id", $id);

            #Validando a requisição
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            #Executando a ação
            $this->service->update($data, $id);

            #Retorno para a view
            return redirect()->back()->with("message", "Alteração realizada com sucesso!");
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        } catch (\Throwable $e) { dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function registro($id)
    {
        $configuracaoGeral = $this->configuracaoGeralService->findConfiguracaoGeral();

        $demanda = \DB::table('ouv_demanda')
            ->leftJoin(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento 
                        where encaminhamento.demanda_id = ouv_demanda.id AND encaminhamento.status_id IN (1,7,2,4,6) ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            })
            ->leftJoin('ouv_destinatario', 'ouv_destinatario.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->leftJoin('ouv_area', 'ouv_area.id', '=', 'ouv_destinatario.area_id')
            ->join('ouv_informacao', 'ouv_informacao.id', '=', 'ouv_demanda.informacao_id')
            ->leftJoin('bairros', 'bairros.id', '=', 'ouv_demanda.bairro_id')
            ->leftJoin('cidades', 'cidades.id', '=', 'bairros.cidades_id')
            ->leftJoin('ouv_subassunto', 'ouv_subassunto.id', '=', 'ouv_demanda.subassunto_id')
            ->leftJoin('ouv_assunto', 'ouv_assunto.id', '=', 'ouv_subassunto.assunto_id')
            ->leftJoin('ouv_idade', 'ouv_idade.id', '=', 'ouv_demanda.idade_id')
            ->leftJoin('sexos', 'sexos.id', '=', 'ouv_demanda.sexos_id')
            ->leftJoin('escolaridade', 'escolaridade.id', '=', 'ouv_demanda.escolaridade_id')
            ->leftJoin('ouv_tipo_demanda', 'ouv_tipo_demanda.id', '=', 'ouv_demanda.tipo_demanda_id')
            ->leftJoin('ouv_pessoa', 'ouv_pessoa.id', '=', 'ouv_demanda.pessoa_id')
            ->leftJoin('ouv_sigilo', 'ouv_sigilo.id', '=', 'ouv_demanda.sigilo_id')
            ->where('ouv_demanda.id', '=', $id)
            ->select([
                'ouv_encaminhamento.id as encaminhamento_id',
                \DB::raw('CONCAT (SUBSTRING(ouv_demanda.codigo, 4, 4), "/", SUBSTRING(ouv_demanda.codigo, -4, 4)) as codigo'),
                \DB::raw('DATE_FORMAT(ouv_encaminhamento.data,"%d/%m/%Y") as data'),
                \DB::raw('DATE_FORMAT(ouv_demanda.data_da_ocorrencia,"%d/%m/%Y") as data_da_ocorrencia'),
                \DB::raw('DATE_FORMAT(ouv_demanda.data,"%d/%m/%Y") as data_cadastro'),
                \DB::raw('DATE_FORMAT(ouv_demanda.data,"%H:%m:%s") as hora_cadastro'),
                'ouv_demanda.hora_da_ocorrencia',
                'ouv_destinatario.nome as destino',
                'ouv_area.nome as area',
                \DB::raw('DATE_FORMAT(ouv_encaminhamento.previsao,"%d/%m/%Y") as previsao'),
                'ouv_informacao.nome as informacao',
                'ouv_assunto.nome as assunto',
                'ouv_subassunto.nome as subassunto',
                'ouv_demanda.nome as nome',
                'bairros.nome as bairro',
                'cidades.nome as cidade',
                'ouv_demanda.endereco',
                'ouv_demanda.n_protocolo',
                'ouv_demanda.numero_end',
                'ouv_demanda.fone',
                'ouv_demanda.relato',
                'ouv_demanda.obs',
                'ouv_demanda.email',
                'ouv_demanda.rg',
                'ouv_demanda.cpf',
                'ouv_demanda.profissao',
                'ouv_demanda.cep',
                'ouv_pessoa.nome as autor',
                'ouv_encaminhamento.resposta',
                'ouv_encaminhamento.parecer',
                'ouv_demanda.sigilo_id',
                'ouv_demanda.anonimo_id',
                'ouv_idade.nome as idade',
                'sexos.nome as sexo',
                'escolaridade.nome as escolaridade',
                'ouv_demanda.exclusividade_sus_id',
                'ouv_tipo_demanda.nome as tipo_demanda',
                'ouv_area.secretario',
                'ouv_area.id as area_id',
                'ouv_sigilo.nome as sigilo',
            ])->first();

        return \PDF::loadView('reports.registroDemanda',
            ['demanda' =>  $demanda, 'configuracaoGeral' => $configuracaoGeral])->stream();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewReportPessoas()
    {
        $loadFields = $this->service->load($this->loadFields);

        #Retorno para view
        return view('ouvidoria.reports.viewReportPessoas', compact('loadFields'));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reportPessoas(Request $request)
    {

        $dados = $request->request->all();

        //Tratando as datas
        $dataIni = SerbinarioDateFormat::toUsa($dados['data_inicio']);
        $dataFim = SerbinarioDateFormat::toUsa($dados['data_fim']);
        $secretaria = isset($dados['secretaria']) ? $dados['secretaria'] : '';

        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('ouv_comunidade', 'ouv_comunidade.id', '=', 'ouv_demanda.comunidade_id')
            ->join('ouv_area', 'ouv_area.id', '=', 'ouv_demanda.area_id')
            ->leftJoin('ouv_subassunto', 'ouv_subassunto.id', '=', 'ouv_demanda.subassunto_id')
            ->select([
                'ouv_demanda.id',
                'ouv_demanda.nome as nome',
                'ouv_demanda.endereco',
                'ouv_comunidade.nome as comunidade',
                'ouv_demanda.fone',
                'ouv_subassunto.nome as subassunto',
            ]);

        if($dataIni && $dataIni) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
        }

        if($secretaria) {
            $rows->where('ouv_area.id', '=', $secretaria);
        }


        return \PDF::loadView('ouvidoria.reports.reportPessoas', ['demandas' =>  $rows->get()])->setOrientation('landscape')->stream();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewReportStatus()
    {
        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($this->loadFields);

        #Retorno para view
        return view('ouvidoria.reports.viewReportStatus', compact('loadFields'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reportStatus(Request $request)
    {
        $dados = $request->request->all();

        //Tratando as datas
        $dataIni = SerbinarioDateFormat::toUsa($dados['data_inicio'], 'date');
        $dataFim = SerbinarioDateFormat::toUsa($dados['data_fim'], 'date');
        $secretaria = isset($dados['secretaria']) ? $dados['secretaria'] : '';

        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('ouv_comunidade', 'ouv_comunidade.id', '=', 'ouv_demanda.comunidade_id')
            ->join('ouv_status', 'ouv_status.id', '=', 'ouv_demanda.status_id')
            ->join('ouv_area', 'ouv_area.id', '=', 'ouv_demanda.area_id')
            ->leftJoin('ouv_subassunto', 'ouv_subassunto.id', '=', 'ouv_demanda.subassunto_id')
            ->where('ouv_status.id', '=', $dados['status'])
            ->select([
                'ouv_demanda.id',
                'ouv_demanda.nome as nome',
                'ouv_status.nome as situacao',
                'ouv_demanda.fone',
                'ouv_subassunto.nome as subassunto',
            ]);

        if($dataIni && $dataIni) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
        };

        if($secretaria) {
            $rows->where('ouv_area.id', '=', $secretaria);
        }

        return \PDF::loadView('ouvidoria.reports.reportStatus', ['demandas' =>  $rows->get()])->setOrientation('landscape')->stream();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cartaEcaminhamento($id)
    {

        $configuracaoGeral = $this->configuracaoGeralService->findConfiguracaoGeral();

        // Estrutura da query em geral
        $rows = \DB::table('ouv_demanda')
            ->leftJoin(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento 
                        where encaminhamento.demanda_id = ouv_demanda.id AND encaminhamento.status_id IN (1,7,2,4,6) ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            })
            ->leftJoin('ouv_prioridade', 'ouv_prioridade.id', '=', 'ouv_encaminhamento.prioridade_id')
            ->leftJoin('ouv_destinatario', 'ouv_destinatario.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->leftJoin('ouv_area', 'ouv_area.id', '=', 'ouv_destinatario.area_id')
            ->leftJoin('ouv_status', 'ouv_status.id', '=', 'ouv_encaminhamento.status_id')
            ->join('ouv_informacao', 'ouv_informacao.id', '=', 'ouv_demanda.informacao_id')
            ->leftJoin('bairros', 'bairros.id', '=', 'ouv_demanda.bairro_id')
            ->leftJoin('ouv_subassunto', 'ouv_subassunto.id', '=', 'ouv_demanda.subassunto_id')
            ->leftJoin('ouv_assunto', 'ouv_assunto.id', '=', 'ouv_subassunto.assunto_id')
            ->join('ouv_tipo_demanda', 'ouv_tipo_demanda.id', '=', 'ouv_demanda.tipo_demanda_id')
            ->join('ouv_pessoa', 'ouv_pessoa.id', '=', 'ouv_demanda.pessoa_id')
            ->where('ouv_demanda.id', '=', $id)
            ->select([
                'ouv_encaminhamento.id as encaminhamento_id',
                \DB::raw('CONCAT (SUBSTRING(ouv_demanda.codigo, 4, 4), "/", SUBSTRING(ouv_demanda.codigo, -4, 4)) as codigo'),
                //\DB::raw('DATE_FORMAT(ouv_encaminhamento.data,"%d/%m/%Y") as data'),
                'ouv_encaminhamento.data',
                'ouv_prioridade.nome as prioridade',
                'ouv_prioridade.dias as prazo',
                'ouv_destinatario.nome as destino',
                'ouv_area.nome as area',
                \DB::raw('DATE_FORMAT(ouv_encaminhamento.previsao,"%d/%m/%Y") as previsao'),
                'ouv_status.nome as status',
                'ouv_status.id as status_id',
                'ouv_informacao.nome as informacao',
                'ouv_assunto.nome as assunto',
                'ouv_subassunto.nome as subassunto',
                'ouv_demanda.nome as nome',
                'bairros.nome as bairro',
                'ouv_demanda.endereco',
                'ouv_demanda.numero_end',
                'ouv_demanda.id',
                'ouv_demanda.fone',
                'ouv_demanda.relato',
                'ouv_demanda.obs',
                'ouv_demanda.n_protocolo',
                'ouv_encaminhamento.resposta',
                'ouv_encaminhamento.parecer',
                'ouv_demanda.sigilo_id',
                'ouv_informacao.nome as tipoManifestacao',
                'ouv_tipo_demanda.nome as origem',
                'ouv_pessoa.nome as tipoUsuario',
                'ouv_area.secretario',
                'ouv_area.id as area_id'
            ])->first();

        $encaminhamento = \DB::table('ouv_encaminhamento')
            ->where('ouv_encaminhamento.demanda_id', $rows->id)->select([
                'ouv_encaminhamento.parecer',
            ])->first();

        return \PDF::loadView('reports.cartaEncaminhamento', ['demanda' =>  $rows,
            'configuracaoGeral' => $configuracaoGeral, 'encaminhamento' => $encaminhamento])->stream();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function situacaoAjax(Request $request)
    {
        $situacao = \DB::table('ouv_situacao')
            ->select([
                'id',
                'nome'
            ])->get();

        return ['situacao' =>  $situacao];
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function comunidadeView()
    {
        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($this->loadFields);

        #Retorno para view
        return view('ouvidoria.reports.viewReportComunidades', compact('loadFields'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function comunidade(Request $request)
    {
        $dados = $request->request->all();

        //Tratando as datas
        $dataIni = SerbinarioDateFormat::toUsa($dados['data_inicio'], 'date');
        $dataFim = SerbinarioDateFormat::toUsa($dados['data_fim'], 'date');
        $secretaria  = isset($dados['secretaria']) ? $dados['secretaria'] : '';
        $bairro      = isset($dados['bairro']) ? $dados['bairro'] : '';

        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->leftJoin('bairros', 'bairros.id', '=', 'ouv_demanda.bairro_id')
            ->join('ouv_area', 'ouv_area.id', '=', 'ouv_demanda.area_id')
            ->leftJoin('ouv_subassunto', 'ouv_subassunto.id', '=', 'ouv_demanda.subassunto_id')
            ->where('bairros.id', '=', $bairro)
            ->select([
                'ouv_demanda.id',
                'ouv_demanda.nome as nome',
                'ouv_demanda.endereco',
                'bairros.nome as bairro',
                'ouv_demanda.fone',
                'ouv_subassunto.nome as subassunto',
            ]);
        

        if($dataIni && $dataIni) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
        }

        if($secretaria) {
            $rows->where('ouv_area.id', '=', $secretaria);
        }
        
        return \PDF::loadView('ouvidoria.reports.reportComunidade', ['demandas' =>  $rows->get()])->setOrientation('landscape')->stream();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            #Executando a ação
            $this->service->destroy($id);

            #Retorno para a view
            return redirect()->back()->with("message", "Remoção realizada com sucesso!");
        } catch (\Throwable $e) {
            dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }
}
