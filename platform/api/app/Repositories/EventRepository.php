<?php

namespace DG\Dissertation\Api\Repositories;

use DG\Dissertation\Api\Models\Event;
use DG\Dissertation\Api\Repositories\Interfaces\EventRepositoryInterface;
use DG\Dissertation\Core\Repositories\Abstracts\EloquentRepositoryAbstract;

class EventRepository extends EloquentRepositoryAbstract implements EventRepositoryInterface
{
    public function __construct(Event $model)
    {
        parent::__construct($model);
    }
}
