<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const CATEGORIES = [
        ['name' => 'Fashion & Beauty', 'slug' => 'fashion-beauty'],
        ['name' => 'Essentials', 'slug' => 'essentials'],
        ['name' => 'Electronics', 'slug' => 'electronics'],
        ['name' => 'Vehicles', 'slug' => 'vehicles'],
        ['name' => 'Property', 'slug' => 'property'],
        ['name' => 'Pets', 'slug' => 'pets'],
    ];

    public function up(): void
    {
        foreach (self::CATEGORIES as $category) {
            DB::table('categories')->insertOrIgnore([
                ...$category,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('categories')
            ->whereIn('slug', array_column(self::CATEGORIES, 'slug'))
            ->whereNotExists(function ($query) {
                $query->selectRaw('1')
                    ->from('listings')
                    ->whereColumn('listings.category_id', 'categories.id');
            })
            ->delete();
    }
};