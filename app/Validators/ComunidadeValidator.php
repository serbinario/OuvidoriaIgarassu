<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class ComunidadeValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

    protected $attributes = [

    ];

    protected $messages = [

    ];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'nome' =>  'required' ,
            'psf_id' => 'required'

        ],
        ValidatorInterface::RULE_UPDATE => [
            
			'nome' =>  'required' ,
            'psf_id' => 'required'
        ],
   ];

}
