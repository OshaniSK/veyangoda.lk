<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'phone',
        'location_city',
        'avatar',
        'bio',
        'is_verified_seller',
        'is_artisan_certified',
        'is_admin',
        'is_banned',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at'    => 'datetime',
            'password'             => 'hashed',
            'is_admin'             => 'boolean',
            'is_banned'            => 'boolean',
            'is_verified_seller'   => 'boolean',
            'is_artisan_certified' => 'boolean',
        ];
    }

    // ── Relationships ──────────────────────────────────────────────────

    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class);
    }

    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function contactRequestsSent(): HasMany
    {
        return $this->hasMany(ContactRequest::class, 'buyer_id');
    }

    public function contactRequestsReceived(): HasMany
    {
        return $this->hasMany(ContactRequest::class, 'seller_id');
    }

    // ── Helpers ────────────────────────────────────────────────────────

    /**
     * Count unread messages received by this user.
     */
    public function unreadMessageCount(): int
    {
        return $this->receivedMessages()->where('read_status', false)->count();
    }

    /**
     * Get the user's display initial (first character of name, uppercased).
     */
    public function getInitialAttribute(): string
    {
        return strtoupper(substr($this->name, 0, 1));
    }
}
