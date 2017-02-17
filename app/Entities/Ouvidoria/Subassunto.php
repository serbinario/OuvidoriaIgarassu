<?php

namespace Seracademico\Entities\Ouvidoria;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Subassunto extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'ouv_subassunto';

    protected $fillable = [ 
		'nome',
		'assunto_id',
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assunto()
    {
        return $this->belongsTo(Assunto::class, 'assunto_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function demandas()
    {
        return $this->hasMany(Demanda::class, 'subassunto_id');
    }
    
}