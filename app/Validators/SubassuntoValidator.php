<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class SubassuntoValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'nome' =>  '' ,
			'assunto_id' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [
            
			'nome' =>  '' ,
			'assunto_id' =>  '' ,

        ],
   ];

}
