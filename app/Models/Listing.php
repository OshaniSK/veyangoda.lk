<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'sub_category_id',
        'title',
        'slug',
        'description',
        'price',
        'location',
        'image_path',
        'status',
        'views_count',
        'brand',
        'model',
        'condition',
        'fuel_type',
        'gear_type',
        'year_min',
        'year_max',
        'gender',
        'item_type',
        'dietary',
        'shelf_life',
        'cuisine',
        'meal_type',
        'flavor',
        'curry_type',
        'rice_type',
        'spice_level',
        'temperature',
        'size',
        'event_type',
        'service_type',
        'occasion',
        // ── Seller contact details ─────────────────────────────────────
        'contact_name',
        'phone_number',
        'whatsapp_number',
        'contact_email',
        'show_phone',
        'show_email',
        // ── Approval workflow ──────────────────────────────────────────
        'rejection_reason',
        'approved_at',
        'approved_by',
    ];

    protected function casts(): array
    {
        return [
            'price'       => 'decimal:2',
            'views_count' => 'integer',
            'show_phone'  => 'boolean',
            'show_email'  => 'boolean',
            'approved_at' => 'datetime',
        ];
    }


    // ── Relationships ──────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function photos(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Photo::class)->orderBy('order', 'asc');
    }

    public function contactRequests(): HasMany
    {
        return $this->hasMany(ContactRequest::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ListingImage::class)->orderBy('sort_order');
    }

    // ── Scopes ─────────────────────────────────────────────────────────

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeRejected(Builder $query): Builder
    {
        return $query->where('status', 'rejected');
    }

    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    // ── Status Helpers ─────────────────────────────────────────────────

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    // ── Accessors ──────────────────────────────────────────────────────

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                $imagePath = $this->image_path ?: $this->photos->first()?->photo_path ?: $this->images->first()?->image_path;
                if (! $imagePath) {
                    return 'https://images.unsplash.com/photo-1584992236310-6edddc08acff?auto=format&fit=crop&w=600&q=80';
                }
                if (str_starts_with($imagePath, 'http')) {
                    return $imagePath;
                }
                return Storage::url($imagePath);
            }
        );
    }

    protected function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rs. ' . number_format((float) $this->price, 2)
        );
    }

    /**
     * Formatted phone number for display: 0771234567 → 077 123 4567
     * Works for both local (077…) and international (+94 77…) formats.
     */
    protected function formattedPhone(): Attribute
    {
        return Attribute::make(
            get: function () {
                $raw = $this->phone_number ?? '';
                if ($raw === '') {
                    return '';
                }
                // +94 prefix → strip and convert to local 0xx for formatting
                if (str_starts_with($raw, '+94')) {
                    $raw = '0' . ltrim(substr($raw, 3), ' ');
                }
                // Format: 0xx xxx xxxx (10 digits) or leave as-is
                $digits = preg_replace('/\D/', '', $raw);
                if (strlen($digits) === 10) {
                    return substr($digits, 0, 3) . ' ' .
                           substr($digits, 3, 3) . ' ' .
                           substr($digits, 6);
                }
                return $this->phone_number;
            }
        );
    }

    /**
     * Returns the WhatsApp number to use — falls back to phone_number when
     * whatsapp_number has not been supplied.
     */
    protected function whatsappContact(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->whatsapp_number ?: $this->phone_number
        );
    }

    /**
     * Increment the view counter atomically.
     */
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }
}
