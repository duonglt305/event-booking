<?php

namespace DG\Dissertation\Core\Facades;

use DG\Dissertation\Core\Supports\PageTitle;
use Illuminate\Support\Facades\Facade;

class PageTitleFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'page-title';
    }
}
