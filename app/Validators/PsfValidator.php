<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class PsfValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

    protected $messages   = [
        'nome' => ''
    ];

    protected $attributes = [
        'nome' => ''
    ];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'nome' => 'required'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'nome' => ''
        ],
    ];

}
