<?php

declare(strict_types=1);

namespace Vdlp\Horizon\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\Http\Controllers\Controller;
use Vdlp\Horizon\Classes\PathHelper;

final class HomeController extends Controller
{
    /**
     * Single page application catch-all route.
     */
    public function index(PathHelper $pathHelper): Factory|View
    {
        return view('horizon::layout', [
            'assetsAreCurrent' => $pathHelper->assetsAreCurrent(),
            'cssFile' => Horizon::$useDarkTheme ? 'app-dark.css' : 'app.css',
            'horizonScriptVariables' => Horizon::scriptVariables(),
            'isDownForMaintenance' => App::isDownForMaintenance(),
        ]);
    }
}
