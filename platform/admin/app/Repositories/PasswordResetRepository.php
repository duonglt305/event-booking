<?php


namespace DG\Dissertation\Admin\Repositories;


use DG\Dissertation\Admin\Models\PasswordReset;
use DG\Dissertation\Admin\Repositories\Interfaces\PasswordResetRepositoryInterface;
use DG\Dissertation\Core\Repositories\Abstracts\EloquentRepositoryAbstract;

class PasswordResetRepository extends EloquentRepositoryAbstract implements PasswordResetRepositoryInterface
{
    /**
     * PasswordResetRepository constructor.
     * @param PasswordReset $model
     */
    public function __construct(PasswordReset $model)
    {
        parent::__construct($model);
    }
}
