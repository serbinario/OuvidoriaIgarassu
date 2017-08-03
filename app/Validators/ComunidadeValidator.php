<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Seracademico\Validators\TraitReplaceRulesValidator;

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
            'ouv_psf_id' => 'required'

        ],
        ValidatorInterface::RULE_UPDATE => [
            
			'nome' =>  'required' ,
            'ouv_psf_id' => 'required'
        ],
   ];

}
