<?php

namespace Seracademico\Repositories\Ouvidoria;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Ouvidoria\AreaRepository;
use Seracademico\Entities\Ouvidoria\Area;

/**
 * Class AreaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class AreaRepositoryEloquent extends BaseRepository implements AreaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Area::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
