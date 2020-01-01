<?php


namespace DG\Dissertation\Admin\Repositories;


use DG\Dissertation\Admin\Models\Contact;
use DG\Dissertation\Core\Repositories\Abstracts\EloquentRepositoryAbstract;

class ContactRepository extends EloquentRepositoryAbstract
{
    public function __construct(Contact $model)
    {
        parent::__construct($model);
    }
}
