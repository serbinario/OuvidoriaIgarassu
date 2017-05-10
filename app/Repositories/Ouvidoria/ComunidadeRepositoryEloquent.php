<?php

namespace Seracademico\Repositories\Ouvidoria;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Ouvidoria\ComunidadeRepository;
use Seracademico\Entities\Ouvidoria\Comunidade;
use Seracademico\Validators\ComunidadeValidator;

/**
 * Class ComunidadeRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ComunidadeRepositoryEloquent extends BaseRepository implements ComunidadeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Comunidade::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
