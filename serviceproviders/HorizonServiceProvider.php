<?php

declare(strict_types=1);

namespace Vdlp\Horizon\ServiceProviders;

use Illuminate\Support\Facades\Route;
use Laravel\Horizon;
use Laravel\Horizon\HorizonServiceProvider as HorizonServiceProviderBase;
use Vdlp\Horizon\Listeners\SendNotification;

final class HorizonServiceProvider extends HorizonServiceProviderBase
{
    public function defineAssetPublishing(): void
    {
        $this->publishes([
            HORIZON_PATH . '/public' => plugins_path('vdlp/horizon/assets'),
        ], 'horizon-assets');
    }

    protected function registerEvents(): void
    {
        $this->events[Horizon\Events\LongWaitDetected::class] = [
            SendNotification::class,
        ];

        parent::registerEvents();
    }

    protected function registerResources(): void
    {
        $this->loadViewsFrom(plugins_path('vdlp/horizon/views'), 'horizon');
    }

    protected function registerRoutes(): void
    {
        parent::registerRoutes();

        Route::group([
            'domain' => config('horizon.domain'),
            'prefix' => config('horizon.path'),
            'namespace' => 'Vdlp\Horizon\Http\Controllers',
            'middleware' => config('horizon.middleware', 'web'),
        ], static function (): void {
            Route::get('/{view?}', 'HomeController@index')
                ->where('view', '(.*)')
                ->name('horizon.index');
        });
    }
}
