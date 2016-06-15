<?php

namespace Seracademico\Repositories\Ouvidoria;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Ouvidoria\ExclusividadeSUSRepository;
use Seracademico\Entities\ExclusividadeSUS;

/**
 * Class ExclusividadeSUSRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ExclusividadeSUSRepositoryEloquent extends BaseRepository implements ExclusividadeSUSRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ExclusividadeSUS::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return ExclusividadeSUSValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
