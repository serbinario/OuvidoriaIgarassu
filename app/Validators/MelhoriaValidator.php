<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class MelhoriaValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'nome' =>  '' ,
            'area_id' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [
            
			'nome' =>  '' ,
            'area_id' =>  '' ,

        ],
   ];

}
