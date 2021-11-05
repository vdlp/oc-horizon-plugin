<?php

declare(strict_types=1);

namespace Vdlp\Horizon\Models;

use October\Rain\Database\Model;
use System\Behaviors\SettingsModel;

/**
 * @mixin SettingsModel
 */
final class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];
    public string $settingsCode = 'vdlp_horizon_settings';
    public string $settingsFields = 'fields.yaml';

    public function isMailNotificationEnabled(): bool
    {
        /** @noinspection DynamicInvocationViaScopeResolutionInspection */
        return (bool) self::get('mail_notifications_enabled', false);
    }

    public function getMailNotificationRecipient(): string
    {
        /** @noinspection DynamicInvocationViaScopeResolutionInspection */
        return (string) self::get('mail_notifications_to', '');
    }

    public function isSlackNotificationEnabled(): bool
    {
        /** @noinspection DynamicInvocationViaScopeResolutionInspection */
        return (bool) self::get('slack_notifications_enabled', false);
    }

    public function getSlackNotificationWebhookUrl(): string
    {
        /** @noinspection DynamicInvocationViaScopeResolutionInspection */
        return (string) self::get('slack_notifications_webhook_url', '');
    }

    public function getSlackNotificationChannel(): string
    {
        /** @noinspection DynamicInvocationViaScopeResolutionInspection */
        return (string) self::get('slack_notifications_channel', '');
    }

    public function isSmsNotificationEnabled(): bool
    {
        /** @noinspection DynamicInvocationViaScopeResolutionInspection */
        return (bool) self::get('sms_notifications_enabled', false);
    }

    public function getSmsNotificationRecipient(): string
    {
        /** @noinspection DynamicInvocationViaScopeResolutionInspection */
        return (string) self::get('sms_notifications_to', '');
    }
}
