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
        'title',
        'slug',
        'description',
        'price',
        'location',
        'image_path',
        'status',
        'views_count',
    ];

    protected function casts(): array
    {
        return [
            'price'       => 'decimal:2',
            'views_count' => 'integer',
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

    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
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
     * Increment the view counter atomically.
     */
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }
}
