<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Services\SubassuntoService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\SubassuntoValidator;
use Seracademico\Repositories\Ouvidoria\SubassuntoRepository;

class SubassuntoController extends Controller
{
    /**
    * @var SubassuntoService
    */
    private $service;

    /**
    * @var SubassuntoValidator
    */
    private $validator;

    /**
     * @var AssuntoRepository
     */
    protected $repository;

    /**
    * @var array
    */
    private $loadFields = [
        'Ouvidoria\Assunto',
        'Ouvidoria\Secretaria'
    ];

    /**
    * @param SubassuntoService $service
    * @param SubassuntoValidator $validator
    */
    public function __construct(SubassuntoService $service,
                                SubassuntoValidator $validator,
                                SubassuntoRepository $repository)
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
        return view('subassunto.index');
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('ouv_subassunto')
            ->join('ouv_assunto', 'ouv_assunto.id', '=', 'ouv_subassunto.assunto_id')
            ->join('gen_secretaria', 'gen_secretaria.id', '=', 'ouv_assunto.area_id')
            ->select([
                'ouv_subassunto.id as id',
                'ouv_subassunto.nome as nome',
                'ouv_assunto.nome as assunto',
                'gen_secretaria.nome as area'
            ]);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {

            # Recuperando a calendario
            $subassunto = $this->repository->find($row->id);

            $html = "";
            $html .= '<a style="margin-right: 5%;" href="edit/'.$row->id.'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Editar</a>';

            if(count($subassunto->demandas) == 0) {
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
        return view('subassunto.create', compact('loadFields'));
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
            return view('subassunto.edit', compact('model', 'loadFields'));
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

    /**
     * @param Request $request
     * @return $this|array|\Illuminate\Http\RedirectResponse
     */
    public function storeAjax(Request $request)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Validando a requisição
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            #Executando a ação
            $this->service->store($data);

            #Retorno para a view
            return \Illuminate\Support\Facades\Response::json(['success' => true]);
        } catch (\Throwable $e) {
            return \Illuminate\Support\Facades\Response::json(['error' => $e->getMessage()]);
        }
    }
}
