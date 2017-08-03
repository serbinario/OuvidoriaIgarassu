<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Cidade extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "gen_cidades";

    protected $fillable = [
        'nome',
        'estados_id'
    ];

    public function bairros()
    {
        return $this->hasMany(Bairro::class, "cidades_id");
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, "estados_id");
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeByEstado($query, $value)
    {
        return $query->where('estados_id', $value);
    }
}
