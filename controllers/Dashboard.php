<?php

declare(strict_types=1);

namespace Vdlp\Horizon\Controllers;

use Backend\Classes\Controller;
use Backend\Classes\NavigationManager;

final class Dashboard extends Controller
{
    public $requiredPermissions = ['vdlp.horizon.access_dashboard'];
    public $bodyClass = 'compact-container';

    public function __construct()
    {
        parent::__construct();

        NavigationManager::instance()->setContext('Vdlp.Horizon', 'dashboard');
    }

    public function index(): void
    {
        $this->pageTitle = 'Laravel Horizon';
    }
}
