<?php

namespace Seracademico\Entities\Ouvidoria;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class StatusExterno extends Model
{
    use TransformableTrait;

    protected $table = 'ouv_status_externo';

    protected $fillable = [
        'nome'
    ];
}
