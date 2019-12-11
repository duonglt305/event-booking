<?php


namespace DG\Dissertation\Admin\Repositories;


use DG\Dissertation\Admin\Models\Speaker;
use DG\Dissertation\Admin\Repositories\Interfaces\SpeakerRepositoryInterface;
use DG\Dissertation\Core\Repositories\Abstracts\EloquentRepositoryAbstract;

class SpeakerRepository extends EloquentRepositoryAbstract implements SpeakerRepositoryInterface
{
    public function __construct(Speaker $model)
    {
        parent::__construct($model);
    }
}
