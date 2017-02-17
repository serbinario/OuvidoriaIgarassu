<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class AssuntoValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

    protected $attributes = [

    ];

    protected $messages = [

    ];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'nome' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [
            
			'nome' =>  '' ,

        ],
   ];

}
