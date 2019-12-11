<?php


namespace DG\Dissertation\Api\Providers;

use DG\Dissertation\Api\Exceptions\Handler;
use DG\Dissertation\Core\Supports\Helper;
use DG\Dissertation\Core\Traits\LoadAndPublicTrait;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    use  LoadAndPublicTrait;

    public function register()
    {
    }

    public function boot()
    {
        Helper::autoload(platform_path('api/helpers'));
        $this->setNamespace('api')
            ->loadAndPublicConfigs(['auth', 'jwt', 'paypal'])
            ->loadView();
        $this->mergeConfigs('api.jwt', 'jwt');
        $this->mergeConfigs('api.auth', 'auth');
        $this->app->singleton(ExceptionHandler::class, Handler::class);
        Validator::extend('base64image', function ($attribute, $value, $parameters, $validator) {
            $explode = explode(',', $value);
            $allow = ['png', 'jpg', 'svg'];
            $format = str_replace(
                [
                    'data:image/',
                    ';',
                    'base64',
                ],
                [
                    '', '', '',
                ],
                $explode[0]
            );
            // check file format
            if (!in_array($format, $allow)) {
                return false;
            }
            // check base64 format
            if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1])) {
                return false;
            }
            return true;
        });

    }

    protected function mergeConfigs(string $fromGroup, string $toGroup): void
    {
        $fromConfigs = \Config::get($fromGroup);
        if (is_array($fromConfigs)) {
            foreach ($fromConfigs as $fKey => $fromConfig) {
                $this->mergeConfigs($fromGroup . '.' . $fKey, $toGroup . '.' . $fKey);
            }
        } else \Config::set($toGroup, \Config::get($fromGroup));
    }

}
