<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class MelhoriaValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

    protected $messages   = [
    ];

    protected $attributes = [
    ];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [],
        ValidatorInterface::RULE_UPDATE => [],
    ];

}
