<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Adds seller contact fields to the listings table so that buyers can
     * reach the seller directly from the ad detail page.
     */
    public function up(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            // Seller's display name for contact (may differ from account name)
            $table->string('contact_name', 100)->nullable()->after('featured');

            // Primary contact number — required at submission time
            $table->string('phone_number', 20)->nullable()->after('contact_name');

            // Optional dedicated WhatsApp number; falls back to phone_number if null
            $table->string('whatsapp_number', 20)->nullable()->after('phone_number');

            // Optional email alternative for buyers
            $table->string('contact_email', 150)->nullable()->after('whatsapp_number');

            // Privacy flags — sellers control what is displayed publicly
            $table->boolean('show_phone')->default(true)->after('contact_email');
            $table->boolean('show_email')->default(false)->after('show_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->dropColumn([
                'contact_name',
                'phone_number',
                'whatsapp_number',
                'contact_email',
                'show_phone',
                'show_email',
            ]);
        });
    }
};
