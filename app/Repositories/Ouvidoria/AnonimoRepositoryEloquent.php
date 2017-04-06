<?php

namespace Seracademico\Repositories\Ouvidoria;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Ouvidoria\AnonimoRepository;
use Seracademico\Entities\Ouvidoria\Anonimo;

/**
 * Class AnonimoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class AnonimoRepositoryEloquent extends BaseRepository implements AnonimoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Anonimo::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
