<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Log;

class FcmChannel
{
    /**
     * Send the given notification.
     */
    public function send($notifiable, Notification $notification)
    {
        if (! method_exists($notification, 'toFcm')) {
            return;
        }

        $tokens = $notifiable->routeNotificationForFcm();

        if (empty($tokens)) {
            return;
        }

        $payload = $notification->toFcm($notifiable);
        $projectId = env('FIREBASE_PROJECT_ID');
        $credentialsPath = env('FIREBASE_CREDENTIALS');

        if (!$projectId || !$credentialsPath || !file_exists(storage_path($credentialsPath))) {
            Log::warning('FCM not configured correctly.');
            return;
        }

        try {
            $scopes = ['https://www.googleapis.com/auth/firebase.messaging'];
            $credentials = new ServiceAccountCredentials($scopes, storage_path($credentialsPath));
            $authToken = $credentials->fetchAuthToken();
            $accessToken = $authToken['access_token'];

            foreach ($tokens as $token) {
                $response = Http::withToken($accessToken)
                    ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", [
                        'message' => [
                            'token' => $token,
                            'notification' => [
                                'title' => $payload['title'],
                                'body'  => $payload['body'],
                            ],
                            'data' => [
                                'url' => $payload['url'] ?? '',
                            ]
                        ]
                    ]);

                if (!$response->successful()) {
                    $error = $response->json();
                    Log::error('FCM Send Error: ' . json_encode($error));
                    
                    if (isset($error['error']['details'][0]['errorCode']) && 
                        $error['error']['details'][0]['errorCode'] === 'UNREGISTERED') {
                        // Delete expired token
                        $notifiable->deviceTokens()->where('token', $token)->delete();
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('FCM Exception: ' . $e->getMessage());
        }
    }
}
