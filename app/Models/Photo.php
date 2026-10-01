<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo extends Model
{
    use HasFactory;

    protected $table = 'listing_photos';

    protected $fillable = [
        'listing_id',
        'photo_path',
        'order',
    ];

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }
}
