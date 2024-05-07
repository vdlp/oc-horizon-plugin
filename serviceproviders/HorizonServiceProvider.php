<?php

declare(strict_types=1);

namespace Vdlp\Horizon\ServiceProviders;

use Laravel\Horizon;
use Laravel\Horizon\HorizonServiceProvider as HorizonServiceProviderBase;
use Vdlp\Horizon\Listeners\SendNotification;

final class HorizonServiceProvider extends HorizonServiceProviderBase
{
    protected function registerEvents(): void
    {
        $this->events[Horizon\Events\LongWaitDetected::class] = [
            SendNotification::class,
        ];

        parent::registerEvents();
    }
}
