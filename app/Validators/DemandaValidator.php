<?php

namespace Seracademico\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class DemandaValidator extends LaravelValidator
{
	use TraitReplaceRulesValidator;

	protected $attributes = [

	];

	protected $messages = [

	];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            
			'nome' =>  '' ,
			'email' =>  '' ,
			'fone' =>  '' ,
			'minicipio' =>  '' ,
			'endereco' =>  '' ,
			'relato' =>  '' ,
			'data' =>  '' ,
			'codigo' =>  '' ,
			'informacao_id' =>  '' ,
			'sigilo_id' =>  '' ,
			'sexos_id' =>  '' ,
			'area_id' =>  '' ,
			'exclusividade_sus_id' =>  '' ,
			'idade_id' =>  '' ,
			'anonimo_id' =>  '' ,
			'escolaridade_id' =>  '' ,

        ],
        ValidatorInterface::RULE_UPDATE => [
            
			'nome' =>  '' ,
			'email' =>  '' ,
			'fone' =>  '' ,
			'minicipio' =>  '' ,
			'endereco' =>  '' ,
			'relato' =>  '' ,
			'data' =>  '' ,
			'codigo' =>  '' ,
			'informacao_id' =>  '' ,
			'sigilo_id' =>  '' ,
			'sexos_id' =>  '' ,
			'area_id' =>  '' ,
			'exclusividade_sus_id' =>  '' ,
			'idade_id' =>  '' ,
			'anonimo_id' =>  '' ,
			'escolaridade_id' =>  '' ,

        ],
   ];

}
