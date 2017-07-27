<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class DemandaValidator extends LaravelValidator
{
	use TraitReplaceRulesValidator;

	protected $attributes = [
		'name' => 'Nome',
		'cpf' =>  'Cpf',
		'email' =>  'E-mail'
	];

	protected $messages = [
		'required' => ':attribute é requerido',
		'between' => ':attribute deve conter no mínimo :min e no máximo :max caracteres',
		'serbinario_alpha_space' => ':attribute deve conter apenas letras e espaços',
		'bank_br' => ':attribute deve conter apenas números e no máximo um hífen (-)',
		'max' => ':attribute deve conter no máximo :size caracteres',
		'cpf_br' => ':attribute deve conter apenas números',
		'integer' => ':attribute deve conter apenas número(s) inteiro(s)',
		'unique' => ':attribute dado já cadastrado, por favor, informe outro',
		'serbinario_date_format:"d/m/Y"' => ':attribute deve estar disposto como: dia/mês/ano',
		'decimal' => ':attribute deve conter um valor acima de 0, máximo uma vírgula e sem pontos',
		'serbinario_array_not_elements_files' => ':attribute é requerido',
		'email' => ':attribute deve estar no formato nome@dominio.com'
	];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
			'nome' =>  '' ,
			'email' =>  'email' ,
			'fone' =>  '' ,
			'minicipio' =>  '' ,
			'endereco' =>  '' ,
			'relato' =>  '' ,
			'data' =>  '' ,
			'codigo' =>  '' ,
			'informacao_id' =>  '' ,
			'sigilo_id' =>  '' ,
			'sexos_id' =>  '' ,
			'area_id' =>  '' ,
			'exclusividade_sus_id' =>  '' ,
			'idade_id' =>  '' ,
			'anonimo_id' =>  '' ,
			'escolaridade_id' =>  '' ,
        ],

        ValidatorInterface::RULE_UPDATE => [
			'nome' =>  '' ,
			'email' =>  '' ,
			'fone' =>  '' ,
			'minicipio' =>  '' ,
			'endereco' =>  '' ,
			'relato' =>  '' ,
			'data' =>  '' ,
			'codigo' =>  '' ,
			'informacao_id' =>  '' ,
			'sigilo_id' =>  '' ,
			'sexos_id' =>  '' ,
			'area_id' =>  '' ,
			'exclusividade_sus_id' =>  '' ,
			'idade_id' =>  '' ,
			'anonimo_id' =>  '' ,
			'escolaridade_id' =>  '' ,
        ],
   ];
}
