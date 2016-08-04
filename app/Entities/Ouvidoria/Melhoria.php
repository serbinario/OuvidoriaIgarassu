<?php

namespace Seracademico\Entities\Ouvidoria;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Melhoria extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'ouv_melhorias';

    protected $fillable = [ 
		'nome',
	];

}