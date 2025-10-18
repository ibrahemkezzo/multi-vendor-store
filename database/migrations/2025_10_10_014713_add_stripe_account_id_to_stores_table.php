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
        Schema::table('stores', function (Blueprint $table) {
            $table->string('stripe_account_id')->nullable()->after('status'); // nullable لأنه قد يتم إضافته لاحقًا
            $table->enum('stripe_status', ['pending', 'active', 'restricted'])->default('pending')->after('stripe_account_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn('stripe_account_id');
            $table->dropColumn('stripe_status');
        });
    }
};
