<?php


namespace DG\Dissertation\Admin\Repositories;


use DG\Dissertation\Admin\Models\Attendee;
use DG\Dissertation\Admin\Repositories\Interfaces\AttendeeRepositoryInterface;
use DG\Dissertation\Core\Repositories\Abstracts\EloquentRepositoryAbstract;

class AttendeeRepository extends EloquentRepositoryAbstract implements AttendeeRepositoryInterface
{
    public function __construct(Attendee $model)
    {
        parent::__construct($model);
    }
}
