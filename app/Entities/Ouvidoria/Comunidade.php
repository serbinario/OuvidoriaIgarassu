<?php

namespace Seracademico\Entities\Ouvidoria;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Comunidade extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'ouv_comunidade';

    protected $fillable = [ 
		'nome',
        'psf_id'
	];
    
    public function demandas()
    {
        return $this->hasMany(Demanda::class, 'comunidade_id');
    }
}