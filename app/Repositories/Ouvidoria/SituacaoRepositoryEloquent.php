<?php

namespace Seracademico\Repositories\Ouvidoria;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Ouvidoria\SituacaoRepository;
use Seracademico\Entities\Ouvidoria\Situacao;

/**
 * Class SituacaoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class SituacaoRepositoryEloquent extends BaseRepository implements SituacaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Situacao::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
