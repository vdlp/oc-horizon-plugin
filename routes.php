<?php

declare(strict_types=1);

use Illuminate\Routing\Router;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Vdlp\Horizon\Classes\PathHelper;

/** @var Router $router */
$router = resolve(Router::class);

/** @var PathHelper $pathHelper */
$pathHelper = resolve(PathHelper::class);

$router->group(['middleware' => ['web']], static function () use ($router, $pathHelper): void {
    $router->get('/vendor/horizon/img/horizon.svg', static function () use ($pathHelper): BinaryFileResponse {
        return response()->download($pathHelper->getAssetsPath('img/horizon.svg'), 'horizon.svg', [
            'Content-Type' => 'image/svg+xml',
        ]);
    });
});

if (!file_exists($pathHelper->getAssetsPath('mix-manifest.json'))) {
    $router->group([
        'domain' => config('horizon.domain'),
        'prefix' => config('horizon.path'),
        'middleware' => config('horizon.middleware', 'web'),
    ], function () use ($router): void {
        $router->get('/{dashboard?}', function (): string {
            return 'The published Horizon assets are not up-to-date with the installed version. '
                . 'To update, run:<br/><code>php artisan horizon:install</code>';
        });
    });
}
