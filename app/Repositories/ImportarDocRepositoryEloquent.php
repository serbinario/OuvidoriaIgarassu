<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Repositories\ImportarDocRepository;
use Seracademico\Entities\ImportarDoc;

/**
 * Class BairroRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ImportarDocRepositoryEloquent extends BaseRepository implements ImportarDocRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ImportarDoc::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
