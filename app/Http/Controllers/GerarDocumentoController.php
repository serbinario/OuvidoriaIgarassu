<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Repositories\ImportarDocRepository;
use Seracademico\Services\ImportarDocService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;


class GerarDocumentoController extends Controller
{

    /**
     * @var ImportarDocService
     */
    private $service;


    /**
     * @var ImportarDocRepository
     */
    protected $repository;


    /**
     * @param ImportarDocService $service
     * @param ImportarDocRepository $repository
     */
    public function __construct(ImportarDocService $service,
                                ImportarDocRepository $repository)
    {
        $this->service   =  $service;
        $this->repository = $repository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('gerarDocumento.index');
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('impotar_doc')
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
        return view('gerarDocumento.create');
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
