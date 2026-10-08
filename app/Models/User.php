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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->slug)) {
                $baseSlug = \Illuminate\Support\Str::slug($user->name);
                if (empty($baseSlug)) {
                    $baseSlug = 'user';
                }
                $slug = $baseSlug;
                $count = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $count;
                    $count++;
                }
                $user->slug = $slug;
            }
        });
    }

    protected $fillable = [
        'name',
        'slug',
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
        'is_seller',
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
            'is_seller'            => 'boolean',
        ];
    }

    // ── Relationships ──────────────────────────────────────────────────

    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'following_id', 'follower_id');
    }

    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'following_id');
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

    public function isFollowing($userId): bool
    {
        return $this->followings()->where('following_id', $userId)->exists();
    }

    public function getFollowerCountAttribute(): int
    {
        return $this->followers()->count();
    }

    /**
     * Get the user's display initial (first character of name, uppercased).
     */
    public function getInitialAttribute(): string
    {
        return strtoupper(substr($this->name, 0, 1));
    }
}
