<?php


namespace DG\Dissertation\Admin\Repositories;


use DG\Dissertation\Admin\Models\Registration;
use DG\Dissertation\Admin\Repositories\Interfaces\RegistrationRepositoryInterface;
use DG\Dissertation\Core\Repositories\Abstracts\EloquentRepositoryAbstract;

class RegistrationRepository extends EloquentRepositoryAbstract implements RegistrationRepositoryInterface
{
    public function __construct(Registration $model)
    {
        parent::__construct($model);
    }
}
