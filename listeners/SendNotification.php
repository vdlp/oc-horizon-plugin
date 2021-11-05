<?php

declare(strict_types=1);

namespace Vdlp\Horizon\Listeners;

use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Notification;
use Laravel\Horizon;

final class SendNotification
{
    private Horizon\Lock $lock;
    private Mailer $mailer;

    public function __construct(Horizon\Lock $lock, Mailer $mailer)
    {
        $this->lock = $lock;
        $this->mailer = $mailer;
    }

    public function handle(Horizon\Events\LongWaitDetected $event): void
    {
        $notification = $event->toNotification();

        if (!$this->lock->get('notification:' . $notification->signature(), 300)) {
            return;
        }

        Notification::route('slack', Horizon\Horizon::$slackWebhookUrl)
            ->route('nexmo', Horizon\Horizon::$smsNumber)
            ->notify($notification);

        if (Horizon\Horizon::$email) {
            $data = [
                'longWaitQueue' => $notification->longWaitQueue,
                'longWaitConnection' => $notification->longWaitConnection,
                'seconds' => $notification->seconds,
            ];

            $this->mailer->send(
                'vdlp.horizon::mail.long-wait-detected',
                $data,
                static function (Message $message): void {
                    $message
                        ->to(Horizon\Horizon::$email)
                        ->subject(config('app.name') . ': Long Queue Wait Detected');
                });
        }
    }
}
