<?php

namespace Seracademico\Entities\Ouvidoria;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Secretaria extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "ouv_area";

    protected $fillable = [
        'nome',
        'secretario'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assuntos()
    {
        return $this->hasMany(Assunto::class, 'area_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function departamentos()
    {
        return $this->hasMany(Destinatario::class, 'area_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function demandas()
    {
        return $this->hasMany(Demanda::class, 'area_id');
    }

}
