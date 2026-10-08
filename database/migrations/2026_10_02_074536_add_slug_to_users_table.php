<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable()->after('name');
        });

        // Backfill existing users
        $users = DB::table('users')->get();
        foreach ($users as $user) {
            $baseSlug = Str::slug($user->name);
            if (empty($baseSlug)) {
                $baseSlug = 'user';
            }
            $slug = $baseSlug;
            $count = 1;
            while (DB::table('users')->where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $count;
                $count++;
            }
            DB::table('users')->where('id', $user->id)->update(['slug' => $slug]);
        }

        // Make it non-nullable after backfilling if needed, but keeping nullable is safer for now
        // Or just let it be.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
