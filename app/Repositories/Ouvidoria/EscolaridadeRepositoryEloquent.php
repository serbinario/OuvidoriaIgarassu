<?php

namespace Seracademico\Repositories\Ouvidoria;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Ouvidoria\EscolaridadeRepository;
use Seracademico\Entities\Ouvidoria\Escolaridade;

/**
 * Class EscolaridadeRepositoryEloquent
 * @package namespace App\Repositories;
 */
class EscolaridadeRepositoryEloquent extends BaseRepository implements EscolaridadeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Escolaridade::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
