<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class DepartamentoValidator extends LaravelValidator
{

    use TraitReplaceRulesValidator;

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            

        ],
        ValidatorInterface::RULE_UPDATE => [
            

        ],
    ];
}
