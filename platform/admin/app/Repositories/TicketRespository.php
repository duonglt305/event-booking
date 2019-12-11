<?php


namespace DG\Dissertation\Admin\Repositories;


use DG\Dissertation\Admin\Models\Ticket;
use DG\Dissertation\Admin\Repositories\Interfaces\TicketRepositoryInterface;
use DG\Dissertation\Core\Repositories\Abstracts\EloquentRepositoryAbstract;
use Illuminate\Database\Eloquent\Model;

class TicketRespository extends EloquentRepositoryAbstract implements TicketRepositoryInterface
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
