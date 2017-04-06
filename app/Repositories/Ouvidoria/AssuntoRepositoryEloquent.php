<?php

namespace Seracademico\Repositories\Ouvidoria;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\AssuntoValidator;
use Seracademico\Repositories\Ouvidoria\AssuntoRepository;
use Seracademico\Entities\Ouvidoria\Assunto;

/**
 * Class AssuntoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class AssuntoRepositoryEloquent extends BaseRepository implements AssuntoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Assunto::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
