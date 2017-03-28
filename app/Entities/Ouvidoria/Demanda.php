<?php

namespace Seracademico\Entities\Ouvidoria;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Uteis\SerbinarioDateFormat;
use Seracademico\Entities\Pessoa;
use Seracademico\Entities\Sexo;

class Demanda extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'ouv_demanda';

    protected $fillable = [ 
		'nome',
		'email',
		'fone',
		'minicipio',
		'endereco',
		'relato',
		'data',
		'codigo',
		'informacao_id',
		'sigilo_id',
		'sexos_id',
		'area_id',
		'exclusividade_sus_id',
		'idade_id',
		'anonimo_id',
		'escolaridade_id',
		'tipo_demanda_id',
		'melhorias',
		'obs',
		'status_id',
		'pessoa_id',
		'numero_end',
		'subassunto_id',
		'melhoria_id',
		'comunidade_id',
		'user_id',
		'tipo_resposta_id',
		'data_da_ocorrencia',
		'hora_da_ocorrencia'
	];

	/**
	 * @return string
	 */
	public function getDataDaOcorrenciaAttribute()
	{
		return SerbinarioDateFormat::toBrazil($this->attributes['data_da_ocorrencia']);
	}

	/**
	 *
	 * @return \DateTime
	 */
	public function setDataDaOcorrenciaAttribute($value)
	{
		$this->attributes['data_da_ocorrencia'] = SerbinarioDateFormat::toUsa($value);
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
	public function sigilo()
	{
		return $this->belongsTo(Sigilo::class, 'sigilo_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function anonimo()
	{
		return $this->belongsTo(Anonimo::class, 'anonimo_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function informacao()
	{
		return $this->belongsTo(Informacao::class, 'informacao_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function area()
	{
		return $this->belongsTo(Area::class, 'area_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function exclusividadeSUS()
	{
		return $this->belongsTo(ExclusividadeSUS::class, 'exclusividade_sus_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function idade()
	{
		return $this->belongsTo(Idade::class, 'idade_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function escolaridade()
	{
		return $this->belongsTo(Escolaridade::class, 'escolaridade_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function tipoDemanda()
	{
		return $this->belongsTo(TipoDemanda::class, 'tipo_demanda_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function situacao()
	{
		return $this->belongsTo(Status::class, 'status_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function pessoa()
	{
		return $this->belongsTo(Pessoa::class, 'pessoa_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function subassunto()
	{
		return $this->belongsTo(Subassunto::class, 'subassunto_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function melhoria()
	{
		return $this->belongsTo(Melhoria::class, 'melhoria_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function encaminhamento()
	{
		return $this->hasOne(Encaminhamento::class, 'demanda_id', 'id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function comunidade()
	{
		return $this->belongsTo(Comunidade::class, 'comunidade_id', 'id');
	}
}