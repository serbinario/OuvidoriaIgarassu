<?php

namespace Seracademico\Entities\Ouvidoria;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Informacao extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'ouv_informacao';

    protected $fillable = [ 
		'nome',
	];

}