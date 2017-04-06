<?php

namespace Seracademico\Repositories\Ouvidoria;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\SubassuntoValidator;
use Seracademico\Repositories\Ouvidoria\SubassuntoRepository;
use Seracademico\Entities\Ouvidoria\Subassunto;

/**
 * Class SubassuntoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class SubassuntoRepositoryEloquent extends BaseRepository implements SubassuntoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Subassunto::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
