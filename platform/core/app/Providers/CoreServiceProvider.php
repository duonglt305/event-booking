<?php

namespace DG\Dissertation\Core\Providers;

use App\Providers\AppServiceProvider;
use DG\Dissertation\Core\Supports\Helper;
use DG\Dissertation\Core\Supports\PageTitle;
use DG\Dissertation\Core\Traits\LoadAndPublicTrait;

/**
 * Class CoreServiceProvider
 * @package DG\Dissertation\Core\Providers
 */
class CoreServiceProvider extends AppServiceProvider
{
    use LoadAndPublicTrait;

    public function boot()
    {
        Helper::autoload(__DIR__ . '/../../helpers');

        $this->setNamespace('core')
            ->loadAndPublicConfigs(['app', 'common','assets']);

        $this->applyConfig();
    }

    public function register()
    {
        $this->app->singleton('page-title',PageTitle::class);
    }

    public function applyConfig()
    {
        \Config::set([
            'app' => config('core.app'),
            'assets' => config('core.assets')
        ]);
    }
}
