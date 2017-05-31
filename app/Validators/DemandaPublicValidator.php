<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class DemandaPublicValidator extends LaravelValidator
{
	use TraitReplaceRulesValidator;

	protected $attributes = [
		'g-recaptcha-response' => 'Voc� precisa marcar'
	];

	protected $messages = [
		'required' => ':attribute � requerido',
		'max' => ':attribute s� pode ter no m�ximo :max caracteres',
		'serbinario_alpha_space' => ' :attribute deve conter apenas letras e espa�os entre palavras',
		'numeric' => ':attribute deve conter apenas n�meros',
		'email' => ':attribute deve seguir esse exemplo: exemplo@dominio.com',
		'digits_between' => ':attribute deve ter entre :min - :max.',
		'cpf_br' => ':attribute deve ser um n�mero de CPF v�lido',
		'unique' => ':attribute j� se encontra cadastrado'
	];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'sigilo_id' =>  'required',
			'nome' =>  'required',
			'sexos_id' =>  'required',
			'idade_id' =>  'required',
			'cpf' =>  'required',
			'rg' =>  'required',
			'fone' =>  'required',
			'profissao' =>  'required',
			'endereco' =>  'required',
			'numero_end' =>  'required',
			'cidade' =>  'required',
			'bairro_id' =>  'required',

			'pessoa_id' =>  'required',
			'informacao_id' =>  'required',
			'relato' =>  'required',
			'g-recaptcha-response' => 'required|captcha'

        ],
        ValidatorInterface::RULE_UPDATE => [

			'sigilo_id' =>  'required',
			'nome' =>  'required',
			'sexos_id' =>  'required',
			'idade_id' =>  'required',
			'cpf' =>  'required',
			'rg' =>  'required',
			'fone' =>  'required',
			'profissao' =>  'required',
			'endereco' =>  'required',
			'numero_end' =>  'required',
			'cidade' =>  'required',
			'bairro_id' =>  'required',

			'pessoa_id' =>  'required',
			'informacao_id' =>  'required',
			'relato' =>  'required',
			'g-recaptcha-response' => 'required|captcha'

        ],
   ];

}
