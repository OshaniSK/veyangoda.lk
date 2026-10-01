<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number', 25)->nullable()->after('email');
            $table->string('phone', 25)->nullable()->after('phone_number');
            $table->string('location_city', 100)->nullable()->after('phone');
            $table->string('avatar', 255)->nullable()->after('location_city');
            $table->text('bio')->nullable()->after('avatar');
            $table->boolean('is_verified_seller')->default(false)->after('bio');
            $table->boolean('is_artisan_certified')->default(false)->after('is_verified_seller');

            $table->index(['is_verified_seller', 'is_artisan_certified']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['is_verified_seller', 'is_artisan_certified']);
            $table->dropColumn([
                'phone_number',
                'phone',
                'location_city',
                'avatar',
                'bio',
                'is_verified_seller',
                'is_artisan_certified',
            ]);
        });
    }
};
