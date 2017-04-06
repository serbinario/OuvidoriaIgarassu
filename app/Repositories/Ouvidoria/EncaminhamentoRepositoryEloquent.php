<?php

namespace Seracademico\Repositories\Ouvidoria;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\EncaminhamentoValidator;
use Seracademico\Repositories\Ouvidoria\EncaminhamentoRepository;
use Seracademico\Entities\Ouvidoria\Encaminhamento;

/**
 * Class EncaminhamentoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class EncaminhamentoRepositoryEloquent extends BaseRepository implements EncaminhamentoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Encaminhamento::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
