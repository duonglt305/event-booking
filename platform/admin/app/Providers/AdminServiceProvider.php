<?php


namespace DG\Dissertation\Admin\Providers;


use DG\Dissertation\Admin\Http\Middleware\Authenticate;
use DG\Dissertation\Admin\Http\Middleware\EventShare;
use DG\Dissertation\Admin\Http\Middleware\RedirectIfAuthenticated;
use DG\Dissertation\Core\Traits\LoadAndPublicTrait;
use Illuminate\Support\ServiceProvider;

/**
 * Class AdminServiceProvider
 * @package DG\Dissertation\Admin\Providers
 */
class AdminServiceProvider extends ServiceProvider
{
    use LoadAndPublicTrait;

    public function register()
    {
        $this->app->singleton(\DG\Dissertation\Admin\Services\EventImageService::class, function () {
            return new \DG\Dissertation\Admin\Services\EventImageService('storage');
        });
    }

    public function boot()
    {
        $this->setNamespace('admin')
            ->loadAndPublicConfigs(['auth','mail'])
            ->loadLang()
            ->loadView()
            ->loadMigration()
            ->applyMiddleware('guest', RedirectIfAuthenticated::class)
            ->applyMiddleware('auth', Authenticate::class);
        $this->applyConfig();
    }

    private function applyConfig()
    {
        \Config::set([
            'auth' => config('admin.auth'),
            'mail' => config('admin.mail')
        ]);
    }

}
