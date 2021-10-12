<?php

declare(strict_types=1);

namespace Vdlp\Horizon\Classes;

use Illuminate\Contracts\Routing\UrlGenerator;

final class PathHelper
{
    private UrlGenerator $urlGenerator;

    public function __construct(UrlGenerator $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function getAssetsPath(?string $path = null): string
    {
        $assetsPath = plugins_path('vdlp/horizon/assets');

        if ($path !== null) {
            $assetsPath .= DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR);
        }

        return $assetsPath;
    }

    public function getAssetsUrlPath(?string $path = null): string
    {
        $assetsUrlPath = $this->urlGenerator->asset('plugins/vdlp/horizon/assets');

        if ($path !== null) {
            $assetsUrlPath .= '/' . ltrim($path, '/');
        }

        return $assetsUrlPath;
    }
}
