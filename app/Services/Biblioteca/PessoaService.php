<?php

namespace Seracademico\Services\Biblioteca;

use Seracademico\Repositories\Biblioteca\PessoaRepository;
use Seracademico\Entities\Pessoa;
use Seracademico\Repositories\EnderecoRepository;

//use Carbon\Carbon;

class PessoaService
{
    /**
     * @var PessoaRepository
     */
    private $repository;

    /**
     * @var EnderecoRepository
     */
    private $enderecoRepository;

    /**
     * @param PessoaRepository $repository
     */
    public function __construct(PessoaRepository $repository, EnderecoRepository $enderecoRepository)
    {
        $this->repository = $repository;
        $this->enderecoRepository   = $enderecoRepository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        #Recuperando o registro no banco de dados
        $relacionamentos = [
            'endereco.bairro.cidade.estado',
            'estadoCivil',
            'sexo',
        ];

        #Recuperando o registro no banco de dados
        $pessoa = $this->repository->with($relacionamentos)->find($id);
       // dd('eeee');
        #Verificando se o registro foi encontrado
        if(!$pessoa) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $pessoa;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Pessoa
    {
        $this->tratamentoCampos($data);

        #Criando o endereco e pessoa
        $endereco = $this->enderecoRepository->create($data['endereco']);

        #Salvando o registro pincipal
        $data['enderecos_id'] = $endereco->id;
        $pessoa =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$pessoa) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $pessoa;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Pessoa
    {

        //$this->tratamentoCampos($data);

        #Atualizando no banco de dados
        $pessoa = $this->repository->update($data, $id);

        $this->enderecoRepository->update($data['endereco'], $pessoa->endereco->id);
        
        #Verificando se foi atualizado no banco de dados
        if(!$pessoa) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $pessoa;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id)
    {
        #deletando o curso
        $result = $this->repository->delete($id);

        # Verificando se a execução foi bem sucessida
        if(!$result) {
            throw new \Exception('Ocorreu um erro ao tentar remover o responsável!');
        }

        #retorno
        return true;
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
            $result[strtolower($model)] = $nameModel::lists('nome', 'id');
        }

        #retorno
        return $result;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function tratamentoDatas(array &$data) : array
    {
         #tratando as datas
         //$data[''] = $data[''] ? Carbon::createFromFormat("d/m/Y", $data['']) : "";

         #retorno
         return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    public function tratamentoCampos(array &$data)
    {
        # Tratamento de campos de chaves estrangeira
        foreach ($data as $key => $value) {
            if(is_array($value)) {
                foreach ($value as $key2 => $value2) {
                    $explodeKey2 = explode("_", $key2);

                    if ($explodeKey2[count($explodeKey2) -1] == "id" && $value2 == null ) {
                        $data[$key][$key2] = null;
                    }
                }
            }

            $explodeKey = explode("_", $key);

            if ($explodeKey[count($explodeKey) -1] == "id" && $value == null ) {
                $data[$key] = null;
            }
        }

        #Retorno
        return $data;
    }

}