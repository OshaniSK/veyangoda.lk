<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('follows')) {
            Schema::create('follows', function (Blueprint $table) {
                $table->id();
                $table->foreignId('follower_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('following_id')->constrained('users')->onDelete('cascade');
                $table->timestamps();

                $table->unique(['follower_id', 'following_id']);
                $table->index(['follower_id']);
                $table->index(['following_id']);
            });
        }

        // Migrate any pre-existing records from the legacy followers table if present
        if (Schema::hasTable('followers')) {
            if (DB::getDriverName() === 'sqlite') {
                DB::statement('
                    INSERT OR IGNORE INTO follows (follower_id, following_id, created_at, updated_at)
                    SELECT follower_id, following_id, created_at, updated_at FROM followers
                ');
            } else {
                DB::statement('
                    INSERT IGNORE INTO follows (follower_id, following_id, created_at, updated_at)
                    SELECT follower_id, following_id, created_at, updated_at FROM followers
                ');
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};
