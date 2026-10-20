<?php

namespace App\Notifications;

use App\Models\Listing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public readonly Listing $listing) {}

    /**
     * Get the notification's delivery channels.
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
        $adUrl   = route('listings.show', $this->listing->slug);
        $myAdsUrl = route('my-listings.index');

        $fromAddress = config('mail.from.address') ?: 'noreply@veyangoda.lk';
        $fromName    = 'Veyangoda.lk Team';

        return (new MailMessage)
            ->from($fromAddress, $fromName)
            ->subject('Your Advertisement Has Been Approved 🎉')
            ->markdown('emails.ads.approved', [
                'userName'   => $notifiable->name ?? 'Seller',
                'adTitle'    => $this->listing->title,
                'price'      => $this->listing->formatted_price ?? ('Rs. ' . number_format((float) $this->listing->price, 2)),
                'category'   => $this->listing->category?->name ?? 'Classifieds',
                'location'   => $this->listing->location,
                'adUrl'      => $adUrl,
                'myAdsUrl'   => $myAdsUrl,
            ]);
    }

    /**
     * Get the array representation of the notification for the database channel.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $adUrl = route('listings.show', $this->listing->slug);

        return [
            // Exact required keys
            'type'       => 'ad_approved',
            'ad_id'      => $this->listing->id,
            'ad_title'   => $this->listing->title,
            'message'    => 'Your advertisement has been approved and is now live.',
            'url'        => $adUrl,
            'action_url' => route('my-listings.index'),

            // UI Bell dropdown compatibility keys
            'title'      => 'Your ad is now live! 🎉',
            'body'       => 'Your advertisement "' . $this->listing->title . '" has been approved and is now live.',
            'icon'       => 'check-circle',
            'listing_id' => $this->listing->id,
        ];
    }
}
