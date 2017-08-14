<?php

namespace Seracademico\Entities\Ouvidoria;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Encaminhamento extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'ouv_encaminhamento';

    protected $fillable = [ 
		'previsao',
		'data',
		'parecer',
		'resposta',
		'destinatario_id',
		'status_id',
		'prioridade_id',
		'demanda_id',
		'encaminhado',
		'copia',
		'user_id',
		'data_recebimento',
		'data_resposta',
		'resposta_ouvidor',
		'resp_publica',
		'resp_ouvidor_publica',
		'status_prorrogacao',
		'justificativa_prorrogacao',
		'data_finalizacao',
		'secretaria_id'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function prioridade()
	{
		return $this->belongsTo(Prioridade::class, 'prioridade_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function status()
	{
		return $this->belongsTo(Status::class, 'status_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function destinatario()
	{
		return $this->belongsTo(Destinatario::class, 'destinatario_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function demanda()
	{
		return $this->belongsTo(Demanda::class, 'demanda_id');
	}

}