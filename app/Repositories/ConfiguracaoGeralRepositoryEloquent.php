<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\ConfiguracaoGeralRepository;
use Seracademico\Entities\Configuracao\ConfiguracaoGeral;

/**
 * Class ConfiguracaoGeralRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ConfiguracaoGeralRepositoryEloquent extends BaseRepository implements ConfiguracaoGeralRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ConfiguracaoGeral::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
