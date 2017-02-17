<?php

namespace Seracademico\Entities\Ouvidoria;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Situacao extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'ouv_situacao';

    protected $fillable = [ 
		'nome',
	];

}