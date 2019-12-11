<?php


namespace DG\Dissertation\Api\Repositories;


use DG\Dissertation\Api\Models\Registration;
use DG\Dissertation\Core\Repositories\Abstracts\EloquentRepositoryAbstract;

class RegistrationRepository extends EloquentRepositoryAbstract
{
    public function __construct(Registration $model)
    {
        parent::__construct($model);
    }
}
