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
        'area_id'
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function secretaria()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function demanda()
    {
        return $this->hasOne(Demanda::class, 'melhoria_id', 'id');
    }
    
}