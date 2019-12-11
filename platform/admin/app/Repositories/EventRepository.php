<?php

namespace DG\Dissertation\Admin\Repositories;

use DG\Dissertation\Admin\Models\Event;
use DG\Dissertation\Admin\Repositories\Interfaces\EventRepositoryInterface;
use DG\Dissertation\Core\Repositories\Abstracts\EloquentRepositoryAbstract;

class EventRepository extends EloquentRepositoryAbstract implements EventRepositoryInterface
{
    public function __construct(Event $event)
    {
        parent::__construct($event);
    }

    public function insert(array $attribute)
    {
        $attribute['organizer_id'] = \Auth::id();
        return parent::insert($attribute);
    }


    public function with($relations)
    {
        return $this->getModel()::with($relations);
    }

}
