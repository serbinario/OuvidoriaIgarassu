<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Ouvidoria\Demanda;

class Bairro extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "gen_bairros";

    protected $fillable = [
        'nome',
        'cidades_id'
    ];

    public function enderecos()
    {
        return $this->hasMany(Endereco::class, "bairros_id");
    }

    public function cidade()
    {
        return $this->belongsTo(Cidade::class, "cidades_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function demanda()
    {
        return $this->hasMany(Demanda::class, 'bairro_id', 'id');
    }
}
