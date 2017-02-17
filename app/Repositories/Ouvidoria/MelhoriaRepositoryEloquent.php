<?php

namespace Seracademico\Repositories\Ouvidoria;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\MelhoriaValidator;
use Seracademico\Repositories\Ouvidoria\MelhoriaRepository;
use Seracademico\Entities\Ouvidoria\Melhoria;

/**
 * Class MelhoriaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class MelhoriaRepositoryEloquent extends BaseRepository implements MelhoriaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Melhoria::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return MelhoriaValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
