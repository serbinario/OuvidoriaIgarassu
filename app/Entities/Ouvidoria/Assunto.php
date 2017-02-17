<?php

namespace Seracademico\Entities\Ouvidoria;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Assunto extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'ouv_assunto';

    protected $fillable = [ 
		'nome',
        'area_id'
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function secretaria()
    {
        return $this->belongsTo(Secretaria::class, 'area_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subassuntos()
    {
        return $this->hasMany(Subassunto::class, 'assunto_id');
    }
}