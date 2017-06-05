<?php

namespace Seracademico\Services\Configuracao;

use Prettus\Validator\Contracts\ValidatorInterface;
use Seracademico\Repositories\ConfiguracaoGeralRepository;
use Seracademico\Validators\Configuracao\ConfiguracaoGeralValidator;

/**
 * Class ConfiguracaoGeralService
 * @package Seracademico\Services\Configuracao
 *
 * @Autor Andrey Fernandes Bernardo da Silva
 */
class ConfiguracaoGeralService
{
    /**
     * @var ConfiguracaoGeralRepository
     */
    private $repository;

    /**
     * @var ConfiguracaoGeralValidator
     */
    private $validator;

    /**
     * ConfiguracaoGeralService constructor.
     * @param ConfiguracaoGeralRepository $repository
     * @param ConfiguracaoGeralValidator $validator
     */
    public function __construct(ConfiguracaoGeralRepository $repository,
                                ConfiguracaoGeralValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * Método responsável por retornar o registro de configuração
     * geral do banco de dados, que deve existir somente um. Caso
     * não exista nenhum ele mesmo se encarrega de criar um registro
     * no banco sem nehuma informação.
     *
     * @return mixed
     * @throws \Exception
     */
    public function findConfiguracaoGeral()
    {
        $configuracoesGerais = $this->repository->all();

        if(count($configuracoesGerais) > 0) {
            return $configuracoesGerais->last();
        }

        $configuracaoGeral = $this->repository->create([]);

        if(!$configuracaoGeral) {
            throw new \Exception("Não foi possível encontrar a configuração ativa,
             contate o suporte.");
        }

        return $configuracaoGeral;
    }

    /**
     * Método responsável por editar os dados da
     * configuração geral no bando de dados.
     *
     * @param $dados
     * @param string $id
     * @return mixed
     * @throws \Exception
     */
    public function update($dados, $id)
    {
        $this->validator->with($dados)->passesOrFail(ValidatorInterface::RULE_UPDATE);

        $configuracaoGeral = $this->repository->update($dados, $id);

        if(!$configuracaoGeral) {
            throw new \Exception("Ocorreu um problema no cadastro dos dados,
                contate o suporte");
        }

        return $configuracaoGeral;
    }
}