<?php

declare(strict_types=1);

namespace Vdlp\Horizon\Classes;

use Cms\Classes\Theme;
use Cms\Facades\Cms;

final class PathHelper
{
    /**
     * @var Theme|null
     */
    private $theme;

    public function __construct()
    {
        $this->theme = Theme::getActiveTheme();
    }

    private function hasActiveTheme(): bool
    {
        return $this->theme !== null;
    }

    public function getAssetsPath(?string $path = null): string
    {
        if (!$this->hasActiveTheme()) {
            return (string) $path;
        }

        $assetsPath = $this->theme->getPath(
            $this->theme->getDirName()
            . DIRECTORY_SEPARATOR
            . 'assets'
            . DIRECTORY_SEPARATOR
            . 'horizon'
        );

        if ($path !== null) {
            $assetsPath .= DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR);
        }

        return $assetsPath;
    }

    public function getAssetsUrlPath(?string $path = null): string
    {
        if (!$this->hasActiveTheme()) {
            return (string) $path;
        }

        $assetsUrlPath = Cms::url('/themes/' . $this->theme->getDirName() . '/assets/horizon');

        if ($path !== null) {
            $assetsUrlPath .= '/' . ltrim($path, '/');
        }

        return $assetsUrlPath;
    }
}
