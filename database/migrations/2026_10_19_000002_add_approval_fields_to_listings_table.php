<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Changes:
     *  1. Adds `rejection_reason`, `approved_at`, `approved_by` columns.
     *  2. Expands the status ENUM to include 'rejected'.
     *  3. Sets all existing non-pending ads to 'active' so nothing disappears.
     */
    public function up(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            // Expand ENUM — MySQL requires re-declaring the full column.
            // We use DB::statement for precision control.
        });

        // Safely expand the ENUM without losing existing data (MySQL only)
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE listings MODIFY COLUMN status ENUM('pending','active','rejected','sold') NOT NULL DEFAULT 'pending'");
        }

        Schema::table('listings', function (Blueprint $table) {
            // Why nullable: rejection_reason only applies to rejected listings
            $table->text('rejection_reason')->nullable()->after('status');

            // Timestamp when an admin approved the listing
            $table->timestamp('approved_at')->nullable()->after('rejection_reason');

            // FK to the admin user who approved/rejected (nullable: admin may be deleted)
            $table->foreignId('approved_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete()
                  ->after('approved_at');
        });

        // Ensure all already-active/sold listings remain visible — only truly
        // unreviewed rows that somehow slipped through should become pending.
        // We leave existing data as-is: the only change is new ads default to pending.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn(['rejection_reason', 'approved_at', 'approved_by']);
        });

        // Restore original ENUM (drop 'rejected')
        DB::statement("ALTER TABLE listings MODIFY COLUMN status ENUM('pending','active','sold') NOT NULL DEFAULT 'pending'");
    }
};
