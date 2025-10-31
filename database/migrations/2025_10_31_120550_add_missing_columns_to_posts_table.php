<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            // Check if columns don't exist before adding
            if (!Schema::hasColumn('posts', 'payment_option')) {
                $table->enum('payment_option', ['free', 'premium'])->default('free')->after('status');
            }
            
            if (!Schema::hasColumn('posts', 'subscription_duration')) {
                $table->enum('subscription_duration', ['1_month', '3_months', '6_months', '1_year'])->nullable()->after('payment_option');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            // Optional: remove columns if needed
            // $table->dropColumn(['payment_option', 'subscription_duration']);
        });
    }
};