<?php

declare(strict_types=1);

namespace Vdlp\Horizon\Console;

use Illuminate\Console\Command;
use October\Rain\Support\Str;
use Vdlp\Horizon\Jobs\Example;

final class PushExampleJobsCommand extends Command
{
    public function __construct()
    {
        $this->name = 'vdlp:horizon:push-example-jobs';
        $this->description = 'Pushes some example jobs to the queue.';

        parent::__construct();
    }

    public function handle(): void
    {
        for ($i = 0; $i < 100; $i++) {
            Example::dispatch(Str::random(10))->onQueue('default');
        }
    }
}
