<?php

namespace Seracademico\Repositories\Ouvidoria;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Ouvidoria\SigiloRepository;
use Seracademico\Entities\Ouvidoria\Sigilo;

/**
 * Class SigiloRepositoryEloquent
 * @package namespace App\Repositories;
 */
class SigiloRepositoryEloquent extends BaseRepository implements SigiloRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Sigilo::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
