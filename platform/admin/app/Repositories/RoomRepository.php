<?php


namespace DG\Dissertation\Admin\Repositories;


use DG\Dissertation\Admin\Models\Room;
use DG\Dissertation\Admin\Repositories\Interfaces\RoomRepositoryInterface;
use DG\Dissertation\Core\Repositories\Abstracts\EloquentRepositoryAbstract;

class RoomRepository extends EloquentRepositoryAbstract implements RoomRepositoryInterface
{
    public function __construct(Room $room)
    {
        parent::__construct($room);
    }

    public function with($relations)
    {
        return $this->getModel()::with($relations);
    }

}
