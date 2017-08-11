<?php

namespace Seracademico\Services;


use Seracademico\Repositories\RoleRepository;
use Seracademico\Entities\User;
use Seracademico\Repositories\PermissionRepository;
use Seracademico\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class UserService
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * @var PermissionRepository
     */
    private $permissionRepository;

    /**
     * @var string
     */
    private $destinationPath = "images/";

    /**
     * @param UserRepository $repository
     * @param RoleRepository $roleRepository
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(UserRepository $repository,
                                RoleRepository $roleRepository,
                                PermissionRepository $permissionRepository)
    {
        $this->repository           = $repository;
        $this->roleRepository       = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find(int $id) : User
    {
        #Recuperando o registro no banco de dados
        $user = $this->repository->with('roles', 'permissions')->find($id);

        #Verificando se o registro foi encontrado
        if(!$user) {
            throw new \Exception('Usuário não encontrado!');
        }

        #retorno
        return $user;
    }

    /**
     * @param array $data
     * @return User
     * @throws \Exception
     */
    public function store(array $data) : User
    {

        // Pegando o usuário
        $user = Auth::user();

        $data = $this->tratamentoCampos($data);
        
        #tratando a senha
        $data['password'] = \bcrypt($data['password']);

        #tratando a imagem
        if(isset($data['img'])) {
            $file     = $data['img'];
            $fileName = md5(uniqid(rand(), true)) . "." . $file->getClientOriginalExtension();

            #Movendo a imagem
            $file->move($this->destinationPath, $fileName);

            #setando o nome da imagem no model
            $data['path_image'] = $fileName;

            #destruindo o img do array
            unset($data['img']);
        }

        // pegando o id da ouvidoria do administrador da ouvidoria logada
        if($user->is('admin')) {
            $data['ouvidoria_id'] = $user->ouvidoria_id;
        }

        #Salvando o registro pincipal
        //$user =  $this->repository->create($data);
        $user = User::create($data);

        #Verificando se foi criado no banco de dados
        if(!$user) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Recupernado as roles e permissions
        $roles       = $data['role'] ?? [];
        $permissions = $data['permission'] ?? [];

        #Tratando os papéis
        foreach ($roles as $role) {
            #Recuperando os papéis
            $roleObj = $this->roleRepository->find($role);

            #Verificando se o registro foi recuperado
            if(!$user) {
                throw new \Exception('Ocorreu um erro ao cadastrar os perfís!');
            }

            #Vinculando ao usuário
            $user->attachRole($roleObj);
        }

        #Tratando as permissões
        foreach ($permissions as $permission) {
            #Recuperando os papéis
            $permissionObj = $this->permissionRepository->find($permission);

            #Verificando se o registro foi recuperado
            if(!$permissionObj) {
                throw new \Exception('Ocorreu um erro ao cadastrar as permissões!');
            }

            #Vinculando ao usuário
            $user->attachPermission($permissionObj);
        }

        #Retorno
        return $user;
    }


    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : User
    {

        $data = $this->tratamentoCamposUpdate($data);

        #tratando a senha
        if(empty($data['password'])) {
            unset($data['password']);
        } else {
            $newPassword = \bcrypt($data['password']);
        }

        #Salvando o registro pincipal
        $user =  $this->repository->update($data, $id);

        # Alterando a senha do usuário
        if(isset($newPassword)) {
            $user->fill([
                'password' => $newPassword
            ])->save();
        }

        #tratando a imagem
        if(isset($data['img'])) {
            $file     = $data['img'];
            $fileName = md5(uniqid(rand(), true)) . "." . $file->getClientOriginalExtension();

            #removendo a imagem antiga
            if($user->path_image != null) {
                unlink(__DIR__ . "/../../public/" . $this->destinationPath . $user->path_image);
            }

            #Movendo a imagem
            $file->move($this->destinationPath, $fileName);

            #setando o nome da imagem no model
            $user->path_image = $fileName;
            $user->save();

            #destruindo o img do array
            unset($data['img']);
        }

        #Verificando se foi criado no banco de dados
        if(!$user) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #deletando as roles e permissions
        $user->detachAllPermissions();
        $user->detachAllRoles();

        #Recupernado as roles e permissions
        $roles       = $data['role'] ?? [];
        $permissions = $data['permission'] ?? [];

        #Tratando os papéis
        foreach ($roles as $role) {
            #Recuperando os papéis
            $roleObj = $this->roleRepository->find($role);

            #Verificando se o registro foi recuperado
            if(!$user) {
                throw new \Exception('Ocorreu um erro ao cadastrar os perfís!');
            }

            #Vinculando ao usuário
            $user->attachRole($roleObj);
        }

        #Tratando as permissões
        foreach ($permissions as $permission) {
            #Recuperando os papéis
            $permissionObj = $this->permissionRepository->find($permission);

            #Verificando se o registro foi recuperado
            if(!$permissionObj) {
                throw new \Exception('Ocorreu um erro ao cadastrar as permissões!');
            }

            #Vinculando ao usuário
            $user->attachPermission($permissionObj);
        }

        #Retorno
        return $user;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function updatePerfil(array $data, int $id) : User
    {

        $data = $this->tratamentoCamposUpdate($data);

        #tratando a senha
        if(empty($data['password'])) {
            unset($data['password']);
        } else {
            $newPassword = \bcrypt($data['password']);
        }

        #Salvando o registro pincipal
        $user =  $this->repository->update($data, $id);

        # Alterando a senha do usuário
        if(isset($newPassword)) {
            $user->fill([
                'password' => $newPassword
            ])->save();
        }

        #Verificando se foi criado no banco de dados
        if(!$user) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $user;
    }

    /**
     * @param array $models
     * @return array
     */
    public function load(array $models) : array
    {
        #Declarando variáveis de uso
        $result = [];

        #Criando e executando as consultas
        foreach ($models as $model) {
            #qualificando o namespace
            $nameModel = "Seracademico\\Entities\\$model";

            #Recuperando o registro e armazenando no array
            $result[strtolower($model)] = $nameModel::lists('name', 'id');
        }

        #retorno
        return $result;
    }

    /**
     * @param array $models
     * @return array
     */
    public function load2(array $models, $ajax = false) : array
    {
        #Declarando variáveis de uso
        $result    = [];
        $expressao = [];
        #Criando e executando as consultas
        foreach ($models as $model) {
            # separando as strings
            $explode   = explode("|", $model);
            # verificando a condição
            if(count($explode) > 1) {
                $model     = $explode[0];
                $expressao = explode(",", $explode[1]);
            }
            #qualificando o namespace
            $nameModel = "\\Seracademico\\Entities\\$model";
            #Verificando se existe sobrescrita do nome do model
            //$model     = isset($expressao[2]) ? $expressao[2] : $model;
            if ($ajax) {
                if(count($expressao) > 0) {
                    switch (count($expressao)) {
                        case 1 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}()->orderBy('nome', 'asc')->get(['nome', 'id']);
                            break;
                        case 2 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->orderBy('nome', 'asc')->get(['nome', 'id']);
                            break;
                        case 3 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1], $expressao[2])->orderBy('nome', 'asc')->get(['nome', 'id']);
                            break;
                    }
                } else {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::orderBy('nome', 'asc')->get(['nome', 'id']);
                }
            } else {
                if(count($expressao) > 1) {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->orderBy('nome', 'asc')->lists('nome', 'id');
                } else {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::orderBy('nome', 'asc')->lists('nome', 'id');
                }
            }
            # Limpando a expressão
            $expressao = [];
        }
        #retorno
        return $result;
    }

    /**
     * @param array $data
     * @return array
     */
    public function tratamentoCampos(array &$data)
    {
        # Tratamento de campos de chaves estrangeira
        foreach ($data as $key => $value) {
            $explodeKey = explode("_", $key);

            if ($explodeKey[count($explodeKey) -1] == "id" && $value == null ) {
                unset($data[$key]);
            }
        }
        #Retorno
        return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    public function tratamentoCamposUpdate(array &$data)
    {
        # Tratamento de campos de chaves estrangeira
        foreach ($data as $key => $value) {
            $explodeKey = explode("_", $key);

            if ($explodeKey[count($explodeKey) -1] == "id" && $value == null ) {
                $data[$key] = null;
            }
        }
        #Retorno
        return $data;
    }

}