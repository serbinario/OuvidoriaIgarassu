<?php

namespace Seracademico\Entities\Ouvidoria;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Destinatario extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'gen_departamento';

    protected $fillable = [ 
		'nome',
        'area_id'
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function encaminhamentos()
    {
        return $this->hasMany(Encaminhamento::class, 'destinatario_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function area()
    {
        return $this->belongsTo(Secretaria::class, 'area_id');
    }
}