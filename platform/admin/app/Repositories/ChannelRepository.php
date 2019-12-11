<?php


namespace DG\Dissertation\Admin\Repositories;


use DG\Dissertation\Admin\Models\Channel;
use DG\Dissertation\Admin\Repositories\Interfaces\ChannelRepositoryInterface;
use DG\Dissertation\Core\Repositories\Abstracts\EloquentRepositoryAbstract;

class ChannelRepository extends EloquentRepositoryAbstract implements ChannelRepositoryInterface
{
    public function __construct(Channel $channel)
    {
        parent::__construct($channel);
    }


    public function with($relations)
    {
        return $this->getModel()::with($relations);
    }
}
