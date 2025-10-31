<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('type', ['house', 'apartment', 'land', 'commercial']);
            $table->enum('category', ['sale', 'rental', 'land']);
            $table->decimal('price', 15, 2);
            $table->string('price_unit')->nullable();
            $table->string('size')->nullable();
            $table->string('location');
            $table->string('district');
            $table->string('city');
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_hot_deal')->default(false);
            $table->boolean('is_trending')->default(false);
            $table->boolean('is_urgent')->default(false);
            $table->string('status')->default('active');
            $table->json('images')->nullable();
            $table->text('amenities')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('properties');
    }
};