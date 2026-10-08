<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Rename category 'Homemade Food' to 'Food & Flavours'
        DB::table('categories')->where('slug', 'homemade-food')->update([
            'name' => 'Food & Flavours',
            'slug' => 'food-and-flavours',
            'icon' => '🍽️'
        ]);

        // 2. Create sub_categories table
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->timestamps();
        });

        // 3. Update category_filters to support sub_categories
        Schema::table('category_filters', function (Blueprint $table) {
            $table->foreignId('sub_category_id')->nullable()->after('category_id')->constrained('sub_categories')->cascadeOnDelete();
            // Make category_id nullable since a filter could belong to a sub_category directly
            $table->unsignedBigInteger('category_id')->nullable()->change();
        });

        // 4. Update listings table
        Schema::table('listings', function (Blueprint $table) {
            $table->foreignId('sub_category_id')->nullable()->after('category_id')->constrained('sub_categories')->nullOnDelete();
            
            // Add new filter columns
            $table->string('item_type')->nullable(); 
            $table->string('dietary')->nullable();
            $table->string('shelf_life')->nullable();
            $table->string('cuisine')->nullable();
            $table->string('meal_type')->nullable();
            $table->string('flavor')->nullable();
            $table->string('curry_type')->nullable();
            $table->string('rice_type')->nullable();
            $table->string('spice_level')->nullable();
            $table->string('temperature')->nullable();
            $table->string('size')->nullable();
            $table->string('event_type')->nullable();
            $table->string('service_type')->nullable();
            $table->string('occasion')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->dropForeign(['sub_category_id']);
            $table->dropColumn([
                'sub_category_id', 'item_type', 'dietary', 'shelf_life', 'cuisine', 
                'meal_type', 'flavor', 'curry_type', 'rice_type', 'spice_level', 
                'temperature', 'size', 'event_type', 'service_type', 'occasion'
            ]);
        });

        Schema::table('category_filters', function (Blueprint $table) {
            $table->dropForeign(['sub_category_id']);
            $table->dropColumn('sub_category_id');
            $table->unsignedBigInteger('category_id')->nullable(false)->change();
        });

        Schema::dropIfExists('sub_categories');

        DB::table('categories')->where('slug', 'food-and-flavours')->update([
            'name' => 'Homemade Food',
            'slug' => 'homemade-food'
        ]);
    }
};
