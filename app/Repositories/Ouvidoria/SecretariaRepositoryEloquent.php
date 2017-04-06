<?php

namespace Seracademico\Repositories\Ouvidoria;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Ouvidoria\SecretariaRepository;
use Seracademico\Entities\Ouvidoria\Secretaria;
use Seracademico\Validators\SecretariaValidator;

/**
 * Class SecretariaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class SecretariaRepositoryEloquent extends BaseRepository implements SecretariaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Secretaria::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
