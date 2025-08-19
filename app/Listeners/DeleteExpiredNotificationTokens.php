<?php

namespace App\Listeners;

use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Support\Arr;
use NotificationChannels\Fcm\FcmChannel;

class DeleteExpiredNotificationTokens
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NotificationFailed $event): void
    {
        if ($event->channel == FcmChannel::class) {
            $report = Arr::get($event->data, 'report');
            $target = $report->target();

            $event->notifiable->notificationTokens()
                ->where('fcm_token', $target)
                ->delete();
        }
    }
}
