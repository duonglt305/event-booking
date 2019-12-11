<?php


namespace DG\Dissertation\Api\Repositories;


use DG\Dissertation\Api\Models\Ticket;
use DG\Dissertation\Core\Repositories\Abstracts\EloquentRepositoryAbstract;

class TicketRespository extends EloquentRepositoryAbstract
{
    public function __construct(Ticket $ticket)
    {
        parent::__construct($ticket);
    }

    public function with($relations)
    {
        return $this->getModel()::with($relations);
    }
}
