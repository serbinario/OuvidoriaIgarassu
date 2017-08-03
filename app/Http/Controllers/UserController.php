<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;
use Seracademico\Services\UserService;
use Seracademico\Validators\UserValidator;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    private $service;

    /**
     * @var UserValidator
     */
    private $validator;

    /**
     * @var array
     */
    private $loadFields = [
        'Role',
        'Permission',
    ];

    /**
     * @var array
     */
    private $loadFields2 = [
        'Ouvidoria\Secretaria'
    ];

    /**
     * @var
     */
    private $user;

    /**
     * @param UserService $service
     * @param UserValidator $validator
     */
    public function __construct(UserService $service, UserValidator $validator)
    {
        $this->service   = $service;
        $this->validator = $validator;
        $this->user      = Auth::user();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('user.index');
    }

    /**
     * @return mixed
     */
    public function grid()
    {
        #Criando a consulta
        $users = \DB::table('users')
            ->leftJoin('gen_secretaria', 'gen_secretaria.id', '=', 'users.area_id')
            ->select([
                'users.id',
                'users.name',
                'users.email',
                'users.active as ativo',
                'gen_secretaria.nome as secretaria'
            ]);

        #Editando a grid
        return Datatables::of($users)->addColumn('action', function ($user) {

            return '<a href="edit/'.$user->id.'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Editar</a>';

        })->addColumn('ativo', function ($user) {

            if($user->ativo) {
                return "Ativo";
            } else {
                return "Desativado";
            }

        })->make(true);
    }

    public function create()
    {
        #Carregando os dados para o cadastro
        $loadFields = $this->service->load($this->loadFields);
        $loadFields2 = $this->service->load2($this->loadFields2);

        #Retorno para view
        return view('user.create', compact('loadFields', 'loadFields2'));
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

            # Validando se o perfil secretaria foi marcado sem selecioanar uma secretaria
            if(isset($data['role'])) {
                foreach ($data['role'] as $role) {
                    if($role == '3' && !$data['area_id']) {
                        return redirect()->back()->with("warning", "Para o perfil de Secretaria deve ser selecionado uma secretaria!");
                    }
                }
            }

            #Validando a requisição
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            #Executando a ação
            $this->service->store($data);

            #Retorno para a view
            return redirect()->back()->with("message", "Cadastro realizado com sucesso!");
        } catch (ValidatorException $e) {print_r($e->getMessage()); exit;
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
            #Recuperando o aluno
            $user = $this->service->find($id);

            #Carregando os dados para o cadastro
            $loadFields = $this->service->load($this->loadFields);
            $loadFields2 = $this->service->load2($this->loadFields2);

            #retorno para view
            return view('user.edit', compact('user', 'loadFields', 'loadFields2'));
        } catch (\Throwable $e) {dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function editPerfil()
    {
        try {
            #Recuperando o aluno
            $user = $this->service->find($this->user->id);

            #retorno para view
            return view('user.edit_perfil', compact('user'));
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

            # Validando se o perfil secretaria foi marcado sem selecioanar uma secretaria
            if(isset($data['role'])) {
                foreach ($data['role'] as $role) {
                    if($role == '3' && !$data['area_id']) {
                        return redirect()->back()->with("warning", "Para o perfil de Secretaria deve ser selecionado uma secretaria!");
                    }
                }
            }

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
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function updatePerfil(Request $request, $id)
    {
        try {
            #Recuperando os dados da requisição
            $data = $request->all();

            #Validando a requisição
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            #Executando a ação
            $this->service->updatePerfil($data, $id);

            #Retorno para a view
            return redirect()->back()->with("message", "Alteração realizada com sucesso!");
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        } catch (\Throwable $e) { dd($e);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }
}
