<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('wanted_ads', function (Blueprint $table) {
            $table->id();
            $table->string('title');  // e.g., "Seeking 2-bed apartment"
            $table->text('description')->nullable();
            $table->enum('offer_type', ['rent', 'buy', 'share']);  // Adjust options as needed
            $table->string('district');
            $table->enum('property_type', ['apartment', 'house', 'room', 'office']);  // Customize
            $table->decimal('budget', 10, 2)->nullable();  // Optional: budget range
            $table->timestamps();  // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('wanted_ads');
    }
};