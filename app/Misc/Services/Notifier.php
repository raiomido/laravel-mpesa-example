<?php


namespace App\Misc\Services;


use App\Notifications\MpesaCallbackFailedNotification;
use Illuminate\Support\Facades\Notification;

class Notifier
{
    public function sendSlackNotification(string $message)
    {
        if ($slack_webhook = config('misc.settings.slack_webhook')) {
            Notification::route('slack', $slack_webhook)
                ->notify(new MpesaCallbackFailedNotification($message));
        }
    }
}
