<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_hero_backgrounds_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeroBackgroundsTable extends Migration
{
    public function up()
    {
        Schema::create('hero_backgrounds', function (Blueprint $table) {
            $table->id();
            $table->string('image_path'); // e.g.: 'hero-bg-1.jpg'
            $table->string('title')->nullable(); // e.g.: 'Modern House'
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hero_backgrounds');
    }
}