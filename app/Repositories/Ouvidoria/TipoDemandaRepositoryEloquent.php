<?php

namespace Seracademico\Repositories\Ouvidoria;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Ouvidoria\TipoDemandaRepository;
use Seracademico\Entities\Ouvidoria\TipoDemanda;

/**
 * Class TipoDemandaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TipoDemandaRepositoryEloquent extends BaseRepository implements TipoDemandaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TipoDemanda::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
