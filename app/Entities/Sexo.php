<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Sexo extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * @var string
     */
    protected $table    = "gen_sexo";

    protected $fillable = [
        'nome'
    ];

}
