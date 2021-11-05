<?php

declare(strict_types=1);

namespace Vdlp\Horizon\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Psr\Log\LoggerInterface;

final class Example implements ShouldQueue
{
    use Dispatchable;
    use Queueable;

    private string $fooBar;

    public function __construct(string $fooBar)
    {
        $this->fooBar = $fooBar;
    }

    /**
     * @throws Exception
     */
    public function handle(LoggerInterface $log): void
    {
        usleep(random_int(1000000, 10000000));

        $log->debug($this->fooBar);
    }

    public function tags(): array
    {
        return [
            'test',
        ];
    }
}
