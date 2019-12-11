<?php

namespace DG\Dissertation\Table\Providers;

use App\Providers\AppServiceProvider;
use DG\Dissertation\Core\Traits\LoadAndPublicTrait;
use Illuminate\Support\Facades\Config;

class TableServiceProvider extends AppServiceProvider
{
    use LoadAndPublicTrait;

    public function boot()
    {
        $this->setNamespace('table')
            ->loadAndPublicConfigs(['datatables-html'])
            ->loadLang()
            ->loadView();

        $this->applyConfig();
    }

    public function register()
    {
    }

    public function applyConfig(){
        Config::set([
            'datatables-html' => config('table.datatables-html')
        ]);
    }
}
