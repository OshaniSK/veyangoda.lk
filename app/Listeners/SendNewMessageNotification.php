<?php

namespace App\Listeners;

use App\Events\MessageSent;
use App\Notifications\NewMessageNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendNewMessageNotification implements ShouldQueue
{
    use InteractsWithQueue;

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
    public function handle(MessageSent $event): void
    {
        $message = $event->message;
        $sender = $message->sender;
        $receiver = $message->receiver;

        // Never send notification to the sender
        if ($sender->id === $receiver->id) {
            return;
        }

        // Optional: Check if recipient muted notifications
        // if (!$receiver->wants_notifications) return;

        try {
            $receiver->notify(new NewMessageNotification($message, $sender));
        } catch (\Exception $e) {
            Log::error('Failed to send NewMessageNotification: ' . $e->getMessage());
        }
    }
}
