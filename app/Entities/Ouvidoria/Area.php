<?php

namespace Seracademico\Entities\Ouvidoria;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Area extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'gen_secretaria';

    protected $fillable = [ 
		'nome',
        'secretario'
	];

}