<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class DemandaPublicValidator extends LaravelValidator
{
	use TraitReplaceRulesValidator;

	protected $attributes = [

	];

	protected $messages = [

	];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'sigilo_id' =>  'required',
			'nome' =>  'required',
			'sexos_id' =>  'required',
			'idade_id' =>  'required',
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
			'pessoa_id' =>  'required',
			'informacao_id' =>  'required',
			'relato' =>  'required',
			'g-recaptcha-response' => 'required|captcha'

        ],
   ];

}
