<?php

namespace Seracademico\Repositories\Ouvidoria;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\DemandaValidator;
use Seracademico\Repositories\Ouvidoria\DemandaRepository;
use Seracademico\Entities\Ouvidoria\Demanda;

/**
 * Class DemandaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class DemandaRepositoryEloquent extends BaseRepository implements DemandaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Demanda::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
