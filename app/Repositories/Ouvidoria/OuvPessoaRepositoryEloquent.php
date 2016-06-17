<?php

namespace Seracademico\Repositories\Ouvidoria;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\Ouvidoria\OuvPessoaRepository;
use Seracademico\Entities\Ouvidoria\OuvPessoa;

/**
 * Class OuvPessoaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class OuvPessoaRepositoryEloquent extends BaseRepository implements OuvPessoaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OuvPessoa::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

         return OuvPessoaValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
