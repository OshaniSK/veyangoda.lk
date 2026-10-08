<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'slug', 'icon'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function listings()
    {
        return $this->hasMany(Listing::class, 'sub_category_id');
    }

    public function filters()
    {
        return $this->hasMany(CategoryFilter::class, 'sub_category_id')->orderBy('sort_order');
    }
}
