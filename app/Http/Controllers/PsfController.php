<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Repositories\PsfRepository;
use Seracademico\Services\PsfService;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Validators\PsfValidator;

class PsfController extends Controller
{
    /**
    * @var PsfService
    */
    private $service;

    /**
    * @var PsfValidator
    */
    private $validator;

    /**
    * @var array
    */
    private $loadFields = [];

    /**
     * @var PsfRepository
     */
    private $repository;

    /**
    * @param PsfService $service
    * @param PsfValidator $validator
    */
    public function __construct(PsfService $service, PsfValidator $validator, PsfRepository $repository)
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
        return view('psf.index');
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $rows = \DB::table('psf')->select(['id', 'nome']);

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {
            # Recuperando a psf
            $psf = $this->repository->find($row->id);

            # Html de edição
            $html = '<a href="edit/'.$row->id.'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Editar</a>';

            # Verificando a possibilidade de exclusão
            if(count($psf->comunidades) == 0) {
                $html .= '<a href="destroy/'.$row->id.'" class="btn btn-xs btn-danger excluir"><i class="fa fa-delete"></i> Deletar</a>';
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
        return view('psf.create', compact('loadFields'));
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
            return view('psf.edit', compact('model', 'loadFields'));
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function destroy($id)
    {
        try {
            # Removendo o registro
            $this->repository->delete($id);

            #retorno para view
            return redirect()->back()->with("message", "Exclusão realizada com sucesso!");
        } catch (\Throwable $e) {dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

}
