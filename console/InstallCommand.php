<?php

declare(strict_types=1);

namespace Vdlp\Horizon\Console;

use Illuminate\Console\Command;

final class InstallCommand extends Command
{
    public function __construct()
    {
        $this->signature = 'horizon:install';
        $this->description = 'Install all of the Horizon resources';

        parent::__construct();
    }

    public function handle(): void
    {
        $this->comment('Publishing Horizon Assets...');
        $this->callSilent('vendor:publish', ['--tag' => 'horizon-assets']);

        $this->comment('Publishing Horizon Configuration...');
        $this->callSilent('vendor:publish', ['--tag' => 'horizon-config']);

        $this->info('Horizon scaffolding installed successfully.');
    }
}
