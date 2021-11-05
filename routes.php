<?php

declare(strict_types=1);

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Vdlp\Horizon\Classes\PathHelper;

/** @var Router $router */
$router = resolve(Router::class);

/** @var PathHelper $pathHelper */
$pathHelper = resolve(PathHelper::class);

$router->group(['middleware' => ['web']], static function () use ($router, $pathHelper): void {
    $router->get('/vendor/horizon/img/horizon.svg', static function () use ($pathHelper): BinaryFileResponse {
        /** @var ResponseFactory $factory */
        $factory = resolve(ResponseFactory::class);

        return $factory->download($pathHelper->getAssetsPath('img/horizon.svg'), 'horizon.svg', [
            'Content-Type' => 'image/svg+xml',
        ]);
    });
});

if (!$pathHelper->assetsAreCurrent()) {
    $router->group([
        'domain' => config('horizon.domain'),
        'prefix' => config('horizon.path'),
        'middleware' => config('horizon.middleware', 'web'),
    ], static function () use ($router): void {
        $router->get('/{anything?}', static function (Request $request): string {
            if (Laravel\Horizon\Horizon::check($request)) {
                return 'The published Horizon assets are not up-to-date with the installed version. '
                    . 'To update, run:<br/><code>php artisan horizon:assets</code>';
            }

            abort(403);
        })->where('anything', '(.*)');
    });
}
