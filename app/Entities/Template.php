<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Template extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "ouv_templates";

    protected $fillable = [
        'nome',
        'html',
        'documento_id',
        'status'
    ];

}
