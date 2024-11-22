<?php

declare(strict_types=1);

namespace Vdlp\Horizon\Console;

use Artisan;
use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;

final class ClearQueuesCommand extends Command
{
    public function __construct()
    {
        $this->name = 'vdlp:horizon:clear-queues';
        $this->description = 'Clears all the Horizon queues with one command.';

        parent::__construct();
    }

    public function handle(Repository $config): void
    {
        $supervisors = $config->get('horizon.defaults');

        foreach ($supervisors as $supervisor) {
            foreach ($supervisor['queue'] as $queue) {
                Artisan::call('horizon:clear', ['--queue' => $queue]);

                $this->comment(preg_replace('/\R+/', ' ', Artisan::output()));
            }
        }
    }
}
