<?php


namespace DG\Dissertation\Admin\Repositories;


use DG\Dissertation\Admin\Models\Session;
use DG\Dissertation\Admin\Repositories\Interfaces\SessionRepositoryInterfacce;
use DG\Dissertation\Core\Repositories\Abstracts\EloquentRepositoryAbstract;

class SessionRepository extends EloquentRepositoryAbstract implements SessionRepositoryInterfacce
{
    public function __construct(Session $session)
    {
        parent::__construct($session);
    }

    public function with(array $relations)
    {
        return $this->getModel()::with($relations);
    }
}
