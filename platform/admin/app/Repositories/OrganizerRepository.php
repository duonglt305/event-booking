<?php


namespace DG\Dissertation\Admin\Repositories;


use DG\Dissertation\Admin\Models\Organizer;
use DG\Dissertation\Admin\Repositories\Interfaces\OrganizerRepositoryInterface;
use DG\Dissertation\Core\Repositories\Abstracts\EloquentRepositoryAbstract;

class OrganizerRepository extends EloquentRepositoryAbstract implements OrganizerRepositoryInterface
{
    public function __construct(Organizer $model)
    {
        parent::__construct($model);
    }
}
