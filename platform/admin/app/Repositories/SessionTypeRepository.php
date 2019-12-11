<?php


namespace DG\Dissertation\Admin\Repositories;


use DG\Dissertation\Admin\Models\SessionType;
use DG\Dissertation\Admin\Repositories\Interfaces\SessionTypeRepositoryInterface;
use DG\Dissertation\Core\Repositories\Abstracts\EloquentRepositoryAbstract;

class SessionTypeRepository extends EloquentRepositoryAbstract implements SessionTypeRepositoryInterface
{
    public function __construct(SessionType $model)
    {
        parent::__construct($model);
    }
}
