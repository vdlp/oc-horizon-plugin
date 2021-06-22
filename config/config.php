<?php

declare(strict_types=1);

return [

    'mail_notifications_enabled' => env('HORIZON_MAIL_NOTIFICATIONS_ENABLED', false),
    'mail_notifications_to' => env('HORIZON_MAIL_NOTIFICATIONS_TO'),

    'slack_notifications_enabled' => env('HORIZON_SLACK_NOTIFICATIONS_ENABLED', false),
    'slack_notifications_webhook_url' => env('HORIZON_SLACK_NOTIFICATIONS_WEBHOOK_URL'),
    'slack_notifications_channel' => env('HORIZON_SLACK_NOTIFICATIONS_CHANNEL'),

    'sms_notifications_enabled' => env('HORIZON_SMS_NOTIFICATIONS_ENABLED', false),
    'sms_notifications_to' => env('HORIZON_SMS_NOTIFICATIONS_TO'),

    'use_dark_theme' => env('HORIZON_USE_DARK_THEME', true),

];
