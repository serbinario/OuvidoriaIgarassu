<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\SecretariaValidator;
use Seracademico\Repositories\Ouvidoria\SecretariaRepository;
use Seracademico\Services\SecretariaService;

class SecretariasController extends Controller
{
    /**
    * @var SecretariaService
    */
    private $service;

    /**
    * @var SecretariaValidator
    */
    private $validator;

    /**
     * @var SecretariaRepository
     */
    protected $repository;

    /**
    * @var array
    */
    private $loadFields = [];

    /**
     * SecretariasController constructor.
     * @param SecretariaService $service
     * @param SecretariaValidator $validator
     * @param SecretariaRepository $repository
     */
    public function __construct(SecretariaService $service,
                                SecretariaValidator $validator,
                                SecretariaRepository $repository)
    {
        $this->service   =  $service;
        $this->validator =  $validator;
        $this->repository = $repository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('secretaria.index');
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('gen_secretaria')->select(['id', 'nome', 'secretario']);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {

            # Recuperando a calendario
            $secretaria = $this->repository->find($row->id);

            $html = "";
            $html .= '<a style="margin-right: 5%;" href="edit/'.$row->id.'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Editar</a>';

            if(count($secretaria->assuntos) == 0 && count($secretaria->departamentos) == 0 && count($secretaria->demandas) == 0) {
                $html .= '<a href="destroy/'.$row->id.'" class="btn btn-xs btn-danger excluir"><i class="fa fa-edit"></i> Deletar</a>';
            }

            return $html;

        })->make(true);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($this->loadFields);

        #Retorno para view
        return view('secretaria.create', compact('loadFields'));
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

            #tratando as rules
            //$this->validator->replaceRules(ValidatorInterface::RULE_UPDATE, ":id", $id);

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

            #retorno para view
            return view('secretaria.edit', compact('model', 'loadFields'));
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
