<?php

declare(strict_types=1);

namespace Vdlp\Horizon\ServiceProviders;

use Cms\Classes\Theme;
use Laravel\Horizon;
use Laravel\Horizon\HorizonServiceProvider as HorizonServiceProviderBase;
use Vdlp\Horizon\Listeners\SendNotification;

final class HorizonServiceProvider extends HorizonServiceProviderBase
{
    public function defineAssetPublishing(): void
    {
        $this->publishes([
            HORIZON_PATH . '/public' => $this->getAssetPath(),
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

    private function getAssetPath(): string
    {
        /** @var Theme $theme */
        $theme = Theme::getActiveTheme();

        if ($theme === null) {
            return '';
        }

        return $theme->getPath(implode(DIRECTORY_SEPARATOR, [
            $theme->getDirName(),
            'assets',
            'horizon',
        ]));
    }
}
