<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Encaminhamento extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'encaminhamento';

    protected $fillable = [ 
		'previsao',
		'data',
		'parecer',
		'resposta',
		'destinatario_id',
		'status_id',
		'prioridade_id',
		'demanda_id',
	];

}