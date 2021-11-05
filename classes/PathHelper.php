<?php

declare(strict_types=1);

namespace Vdlp\Horizon\Classes;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Filesystem\Filesystem;
use Throwable;

final class PathHelper
{
    private UrlGenerator $urlGenerator;
    private Filesystem $filesystem;

    public function __construct(UrlGenerator $urlGenerator, Filesystem $filesystem)
    {
        $this->urlGenerator = $urlGenerator;
        $this->filesystem = $filesystem;
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

    public function assetsAreCurrent(): bool
    {
        $publishedPath = $this->getAssetsPath('mix-manifest.json');
        $vendorPath = base_path('vendor/laravel/horizon/public/mix-manifest.json');

        try {
            return $this->filesystem->get($publishedPath) === $this->filesystem->get($vendorPath);
        } catch (Throwable $exception) {
            return false;
        }
    }
}
