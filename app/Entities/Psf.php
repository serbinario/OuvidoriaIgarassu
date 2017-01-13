<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Ouvidoria\Comunidade;

class Psf extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'psf';

    protected $fillable = [ 
		'nome'
	];

    public function comunidades()
    {
        return $this->hasMany(Comunidade::class, 'psf_id');
    }
}