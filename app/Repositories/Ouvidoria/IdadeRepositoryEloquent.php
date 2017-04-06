<?php

namespace Seracademico\Repositories\Ouvidoria;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Ouvidoria\IdadeRepository;
use Seracademico\Entities\Ouvidoria\Idade;

/**
 * Class IdadeRepositoryEloquent
 * @package namespace App\Repositories;
 */
class IdadeRepositoryEloquent extends BaseRepository implements IdadeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Idade::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
