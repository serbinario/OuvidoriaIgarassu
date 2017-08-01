<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Documento extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "ouv_documentos";

    protected $fillable = [
        'nome',
        'tipo_template_id'
    ];

}
