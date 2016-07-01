<?php

namespace Seracademico\Entities;

use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Uteis\SerbinarioDateFormat;
use Illuminate\Database\Eloquent\Model;


class Pessoa extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * @var string
     */
    protected $table    = "pessoas";

    /**
     * @var array
     */
    protected $dates    = [
        'data_nasciemento'
    ];

    protected $fillable = [
        'nome',
        'email',
        'telefone_fixo',
        'celular',
        'nome_pai',
        'nome_mae',
        'identidade',
        'cpf',
        'data_nasciemento',
        'enderecos_id',
        'sexos_id',
        'estados_civis_id',
        'path_image',
        'ativo',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function endereco()
    {
        return $this->belongsTo(Endereco::class, 'enderecos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sexo()
    {
        return $this->belongsTo(Sexo::class, 'sexos_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estadoCivil()
    {
        return $this->belongsTo(EstadoCivil::class, 'estados_civis_id');
    }
    
    /**
     *
     * @return \DateTime
     */
    public function getDataNasciementoAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_nasciemento']);
    }

    /**
     *
     * @return \DateTime
     */
    public function setDataNasciementoAttribute($value)
    {
        $this->attributes['data_nasciemento'] = SerbinarioDateFormat::toUsa($value);
    }
}