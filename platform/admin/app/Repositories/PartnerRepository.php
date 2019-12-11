<?php


namespace DG\Dissertation\Admin\Repositories;


use DG\Dissertation\Admin\Models\Partner;
use DG\Dissertation\Admin\Repositories\Interfaces\PartnerRepositoryInterface;
use DG\Dissertation\Core\Repositories\Abstracts\EloquentRepositoryAbstract;

class PartnerRepository extends EloquentRepositoryAbstract implements PartnerRepositoryInterface
{
    public function __construct(Partner $model)
    {
        parent::__construct($model);
    }
}
