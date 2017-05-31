<?php

namespace Seracademico\Validators\Configuracao;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

class ConfiguracaoGeralValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

    protected $attributes = [
        'nome' => 'Nome',
        'instituicao' => 'Instituição',
        'cnpj' => 'CNPJ',
        'nome_ouvidor' => 'Nome do ouvidor',
        'cargo' => 'Cargo',
        'telefone1' => 'Telefone1',
        'telefone2' => 'Telefone2',
        'email' => 'E-mail',
        'senha' => 'Senha'
    ];

    protected $messages = [
        'required' => ':attribute é requerido',
        'numeric' => ':attribute dever conter só números'
    ];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [],
        ValidatorInterface::RULE_UPDATE => [
            'nome' => 'required',
            'instituicao' => 'required',
            'cnpj' => 'required|numeric',
            'nome_ouvidor' => 'required',
            'cargo' => 'required',
            'telefone1' => 'numeric',
            'telefone2' => 'numeric',
            'email' => 'required',
            'senha' => 'required'
        ],
   ];
}
