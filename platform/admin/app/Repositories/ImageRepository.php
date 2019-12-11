<?php


namespace DG\Dissertation\Admin\Repositories;


use DG\Dissertation\Admin\Models\Image;
use DG\Dissertation\Admin\Repositories\Interfaces\ImageRepositoryInterface;
use DG\Dissertation\Core\Repositories\Abstracts\EloquentRepositoryAbstract;

class ImageRepository extends EloquentRepositoryAbstract implements ImageRepositoryInterface
{
    public function __construct(Image $model)
    {
        parent::__construct($model);
    }
}
