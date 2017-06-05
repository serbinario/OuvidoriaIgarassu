<?php

namespace Seracademico\Entities\Configuracao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ConfiguracaoGeral extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'configuracao_geral';

    protected $fillable = [
        'nome',
        'instituicao',
        'cnpj',
        'nome_ouvidor',
        'cargo',
        'texto_agradecimento',
        'texto_ende_horario_atend',
        'telefone1',
        'telefone2',
        'pagina_principal',
        'email',
        'senha',
        'acesso_principal',
        'consulta_externa'
    ];

}
