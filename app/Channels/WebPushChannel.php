<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

class WebPushChannel
{
    /**
     * Send the given notification.
     */
    public function send($notifiable, Notification $notification)
    {
        if (! method_exists($notification, 'toWebPush')) {
            return;
        }

        $payload = $notification->toWebPush($notifiable);
        $tokens = $notifiable->routeNotificationForWebPush();

        if (empty($tokens)) {
            return;
        }

        $auth = [
            'VAPID' => [
                'subject' => env('VAPID_ADMIN_EMAIL', 'mailto:admin@veyangoda.lk'),
                'publicKey' => env('VAPID_PUBLIC_KEY'),
                'privateKey' => env('VAPID_PRIVATE_KEY'),
            ],
        ];

        $webPush = new WebPush($auth);

        foreach ($tokens as $tokenObj) {
            $subscription = Subscription::create([
                'endpoint' => $tokenObj->endpoint,
                'publicKey' => $tokenObj->keys['p256dh'],
                'authToken' => $tokenObj->keys['auth'],
            ]);

            $webPush->queueNotification($subscription, json_encode($payload));
        }

        $reports = $webPush->flush();
        
        foreach ($reports as $report) {
            if (!$report->isSuccess()) {
                // If token expired, delete it
                if ($report->isSubscriptionExpired()) {
                    $notifiable->deviceTokens()->where('token', $report->getRequest()->getUri()->__toString())->delete();
                }
                \Log::warning('Web push failed: ' . $report->getReason());
            }
        }
    }
}
