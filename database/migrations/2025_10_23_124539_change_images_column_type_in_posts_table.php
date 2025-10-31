<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Option 1: Change to JSON type (recommended)
        Schema::table('posts', function (Blueprint $table) {
            $table->json('images')->nullable()->change();
        });
        
        // OR Option 2: If JSON change fails, keep as longtext but fix the access
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->longText('images')->nullable()->change();
        });
    }
};