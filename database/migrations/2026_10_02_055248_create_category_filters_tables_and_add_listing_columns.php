<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add icon to categories
        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'icon')) {
                $table->string('icon')->nullable()->after('description');
            }
        });

        // 2. Create category_filters
        Schema::create('category_filters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('filter_name');
            $table->enum('filter_type', ['dropdown', 'text', 'number', 'date']);
            $table->string('placeholder')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 3. Create category_filter_options
        Schema::create('category_filter_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_filter_id')->constrained()->cascadeOnDelete();
            $table->string('option_value');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 4. Add columns to listings
        Schema::table('listings', function (Blueprint $table) {
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('condition')->nullable();
            $table->string('fuel_type')->nullable();
            $table->string('gear_type')->nullable();
            $table->integer('year_min')->nullable();
            $table->integer('year_max')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->dropColumn([
                'brand', 'model', 'condition', 'fuel_type', 'gear_type', 'year_min', 'year_max'
            ]);
        });

        Schema::dropIfExists('category_filter_options');
        Schema::dropIfExists('category_filters');

        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'icon')) {
                $table->dropColumn('icon');
            }
        });
    }
};
