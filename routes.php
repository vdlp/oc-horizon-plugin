<?php

declare(strict_types=1);

use Illuminate\Routing\Router;
use Vdlp\Horizon\Classes\PathHelper;

/** @var Router $router */
$router = resolve(Router::class);

$router->group(['middleware' => ['web']], static function () use ($router) {
    $router->get('/vendor/horizon/img/horizon.svg', static function () {
        /** @var PathHelper $helper */
        $helper = resolve(PathHelper::class);

        return response()->download($helper->getAssetsPath('img/horizon.svg'), 'horizon.svg', [
            'Content-Type' => 'image/svg+xml',
        ]);
    });
});
