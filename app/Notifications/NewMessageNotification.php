<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Channels\WebPushChannel;
use App\Channels\FcmChannel;

class NewMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $data;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database', WebPushChannel::class, FcmChannel::class];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type'  => $this->data['type'] ?? 'message',
            'title' => $this->data['title'] ?? 'New Message',
            'body'  => $this->data['body'] ?? '',
            'url'   => $this->data['url'] ?? '/',
            'icon'  => $this->data['icon'] ?? 'message',
        ];
    }

    /**
     * Get the web push representation of the notification.
     */
    public function toWebPush($notifiable)
    {
        return [
            'title' => $this->data['title'] ?? 'New Message',
            'body'  => $this->data['body'] ?? '',
            'url'   => $this->data['url'] ?? '/',
            'icon'  => $this->data['icon'] ?? 'message',
            'tag'   => 'chat-' . $notifiable->id, // Group by recipient
        ];
    }

    /**
     * Get the FCM representation of the notification.
     */
    public function toFcm($notifiable)
    {
        return [
            'title' => $this->data['title'] ?? 'New Message',
            'body'  => $this->data['body'] ?? '',
            'url'   => $this->data['url'] ?? '/',
        ];
    }
}
