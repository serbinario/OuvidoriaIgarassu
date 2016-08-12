<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class EncaminhamentoValidator extends LaravelValidator
{
    use TraitReplaceRulesValidator;

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'previsao' =>  '' ,
			'data' =>  '' ,
			'parecer' =>  '' ,
			'resposta' =>  '' ,
			'destinatario_id' =>  '' ,
			'status_id' =>  '' ,
			'prioridade_id' =>  '' ,
			'demanda_id' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [
            
			'previsao' =>  '' ,
			'data' =>  '' ,
			'parecer' =>  '' ,
			'resposta' =>  '' ,
			'destinatario_id' =>  '' ,
			'status_id' =>  '' ,
			'prioridade_id' =>  '' ,
			'demanda_id' =>  '' ,

        ],
   ];

}
