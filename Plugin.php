<?php

declare(strict_types=1);

namespace Vdlp\Horizon;

use Backend\Classes\AuthManager;
use Backend\Helpers\Backend;
use Backend\Models\User;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Notifications\NotificationServiceProvider;
use Laravel\Horizon\Horizon;
use System\Classes\PluginBase;
use Vdlp\Horizon\Console\PushExampleJobs;
use Vdlp\Horizon\ServiceProviders\HorizonServiceProvider;

final class Plugin extends PluginBase
{
    /**
     * @var Backend
     */
    private $backend;

    public function __construct($app)
    {
        parent::__construct($app);

        $this->backend = resolve(Backend::class);
    }

    public function pluginDetails(): array
    {
        return [
            'name' => 'Horizon',
            'description' => 'Laravel Horizon integration for OctoberCMS',
            'author' => 'Van der Let & Partners',
            'icon' => 'icon-area-chart',
            'homepage' => 'https://octobercms.com/plugin/vdlp-horizon',
        ];
    }

    public function boot(): void
    {
        config()->set('app.env', $this->app->environment());

        Horizon::auth(static function () {
            /** @var User $user */
            $user = AuthManager::instance()->getUser();

            if ($user === null) {
                return false;
            }

            return $user->hasPermission('vdlp.horizon.access_dashboard')
                || $user->isSuperUser();
        });

        Horizon::$useDarkTheme = config('vdlp.horizon::use_dark_theme', true);

        $this->bootNotificationSettings();

        if (config('app.debug') === true) {
            $this->registerConsoleCommand(PushExampleJobs::class, PushExampleJobs::class);
        }
    }

    public function register(): void
    {
        $this->app->register(HorizonServiceProvider::class);
        $this->app->register(NotificationServiceProvider::class);

        AliasLoader::getInstance()->alias('Horizon', 'Laravel\Horizon\Horizon');
    }

    public function registerSchedule($schedule): void
    {
        $schedule->command('horizon:snapshot')->everyFiveMinutes();
    }

    public function registerPermissions(): array
    {
        return array_merge(
            (array) parent::registerPermissions(),
            [
                'vdlp.horizon.access_dashboard' => [
                    'tab' => 'Horizon',
                    'label' => 'Access to the Horizon dashboard',
                    'roles' => ['developer'],
                ],
            ]
        );
    }

    public function registerNavigation(): array
    {
        return array_merge(
            (array) parent::registerNavigation(),
            [
                'dashboard' => [
                    'label' => 'Horizon',
                    'url' => $this->backend->url('vdlp/horizon/dashboard'),
                    'iconSvg' => '/plugins/vdlp/horizon/assets/icons/horizon.svg',
                    'permissions' => ['vdlp.horizon.access_dashboard'],
                    'order' => 500,
                ],
            ]
        );
    }

    public function registerMailTemplates(): array
    {
        return [
            'vdlp.horizon::mail.long-wait-detected' => 'Long Queue Wait Detected',
        ];
    }

    private function bootNotificationSettings(): void
    {
        if (config('vdlp.horizon::mail_notifications_enabled', false)) {
            Horizon::routeMailNotificationsTo(
                config('vdlp.horizon::mail_notifications_to')
            );
        }

        if (config('vdlp.horizon::slack_notifications_enabled', false)) {
            Horizon::routeSlackNotificationsTo(
                config('vdlp.horizon::slack_notifications_webhook_url'),
                config('vdlp.horizon::slack_notifications_channel')
            );
        }

        if (config('vdlp.horizon::sms_notifications_enabled', false)) {
            Horizon::routeSmsNotificationsTo(
                config('vdlp.horizon::sms_notifications_to')
            );
        }
    }
}
