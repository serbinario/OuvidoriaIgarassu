<?php

namespace Seracademico\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Seracademico\Validators\PsfValidator;
use Seracademico\Repositories\PsfRepository;
use Seracademico\Entities\Psf;

/**
 * Class PsfRepositoryEloquent
 * @package namespace App\Repositories;
 */
class PsfRepositoryEloquent extends BaseRepository implements PsfRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Psf::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
