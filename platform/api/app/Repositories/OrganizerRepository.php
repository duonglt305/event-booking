<?php


namespace DG\Dissertation\Api\Repositories;


use DG\Dissertation\Api\Models\Organizer;
use DG\Dissertation\Api\Repositories\Interfaces\OrganizerRepositoryInterface;
use DG\Dissertation\Core\Repositories\Abstracts\EloquentRepositoryAbstract;

class OrganizerRepository extends EloquentRepositoryAbstract implements OrganizerRepositoryInterface
{
    public function __construct(Organizer $model)
    {
        parent::__construct($model);
    }
}
