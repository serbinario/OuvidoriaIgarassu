<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Repositories\TemplateRepository;
use Seracademico\Services\TemplateService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;


class TemplateController extends Controller
{

    /**
     * @var TemplateService
     */
    private $service;

    /**
     * @var TemplateRepository
     */
    protected $repository;

    /**
     * @var array
     */
    private $loadFields = [
        'Documento'
    ];

    /**
     * @param TemplateService $service
     * @param TemplateRepository $repository
     */
    public function __construct(TemplateService $service,
                                TemplateRepository $repository)
    {
        $this->service    =  $service;
        $this->repository = $repository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('template.index');
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('templates')
            ->select([
                'nome',
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {

            //$html = "";
           // $html .= '<a style="margin-right: 5%;" href="edit/'.$row->id.'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Editar</a>';

            return "";

        })->make(true);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {

        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($this->loadFields);

        return view('template.create', compact('loadFields'));
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {

            #Recuperando os dados da requisição
            $data = $request->all();

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
}
