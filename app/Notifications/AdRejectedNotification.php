<?php

namespace App\Notifications;

use App\Models\Listing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdRejectedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly Listing $listing,
        public readonly string  $reason
    ) {}

    /**
     * Deliver via email and in-app database channel.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Build the mail representation of the notification using Markdown.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $editUrl  = route('my-listings.edit', $this->listing);
        $myAdsUrl = route('my-listings.index');

        $fromAddress = config('mail.from.address') ?: 'noreply@veyangoda.lk';
        $fromName    = 'Veyangoda.lk Team';

        return (new MailMessage)
            ->from($fromAddress, $fromName)
            ->subject('Update on Your Advertisement Submission')
            ->markdown('emails.ads.rejected', [
                'userName' => $notifiable->name ?? 'Seller',
                'adTitle'  => $this->listing->title,
                'reason'   => $this->reason,
                'editUrl'  => $editUrl,
                'myAdsUrl' => $myAdsUrl,
            ]);
    }

    /**
     * Store in the database (in-app notification bell).
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $editUrl = route('my-listings.edit', $this->listing);

        return [
            'type'       => 'ad_rejected',
            'ad_id'      => $this->listing->id,
            'ad_title'   => $this->listing->title,
            'reason'     => $this->reason,
            'message'    => 'Your advertisement needs revisions: ' . $this->reason,
            'url'        => $editUrl,
            'action_url' => route('my-listings.index'),

            // UI Bell dropdown compatibility keys
            'title'      => 'Your ad needs changes',
            'body'       => '"' . $this->listing->title . '" was not approved. ' . $this->reason,
            'icon'       => 'x-circle',
            'listing_id' => $this->listing->id,
        ];
    }
}
