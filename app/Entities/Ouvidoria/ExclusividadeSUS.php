<?php

namespace Seracademico\Entities\Ouvidoria;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ExclusividadeSUS extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'ouv_exclusividade_sus';

    protected $fillable = [ 
		'nome',
	];

}