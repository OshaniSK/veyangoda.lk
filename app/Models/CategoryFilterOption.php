<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CategoryFilterOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_filter_id',
        'option_value',
        'sort_order',
    ];

    public function filter(): BelongsTo
    {
        return $this->belongsTo(CategoryFilter::class, 'category_filter_id');
    }
}
