<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ListingImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'listing_id',
        'image_path',
        'thumbnail_path',
        'is_primary',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Parent listing.
     */
    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }

    /**
     * Public URL for the full-resolution product image.
     */
    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->image_path
                ? (str_starts_with($this->image_path, 'http') ? $this->image_path : Storage::url($this->image_path))
                : asset('images/placeholder-item.jpg')
        );
    }

    /**
     * Public URL for the optimized thumbnail image.
     */
    protected function thumbnailUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->thumbnail_path
                ? (str_starts_with($this->thumbnail_path, 'http') ? $this->thumbnail_path : Storage::url($this->thumbnail_path))
                : $this->url
        );
    }
}
