<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ImportarDoc extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "impotar_doc";

    protected $fillable = [
        'nome',
        'conteudo'
    ];

}
